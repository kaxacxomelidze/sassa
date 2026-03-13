<?php
class IntegrationsController
{
    public function index(): void
    {
        AuthMiddleware::handle(['Admin', 'Supervisor']);
        App::view('integrations/index', [
            'integrations' => (new ChannelIntegration())->all(),
            'inboxes' => (new Inbox())->all(),
        ]);
    }

    public function store(): void
    {
        AuthMiddleware::handle(['Admin', 'Supervisor']);
        verify_csrf();
        $payload = $this->payloadFromRequest();

        $error = $this->validate($payload);
        if ($error !== null) {
            flash('error', $error);
            App::redirect('integrations');
        }

        (new ChannelIntegration())->create($payload);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'create_integration', 'channel_integration');
        flash('success', 'Integration added successfully.');
        App::redirect('integrations');
    }

    public function update(int $id): void
    {
        AuthMiddleware::handle(['Admin', 'Supervisor']);
        verify_csrf();
        $payload = $this->payloadFromRequest();

        $error = $this->validate($payload, true);
        if ($error !== null) {
            flash('error', $error);
            App::redirect('integrations');
        }

        (new ChannelIntegration())->update($id, $payload);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'update_integration', 'channel_integration', $id);
        flash('success', 'Integration updated. Leave secret/token blank to keep old values.');
        App::redirect('integrations');
    }

    public function test(int $id): void
    {
        AuthMiddleware::handle(['Admin', 'Supervisor']);
        verify_csrf();

        $integration = (new ChannelIntegration())->find($id);
        if (!$integration) {
            flash('error', 'Integration not found.');
            App::redirect('integrations');
        }

        [$status, $message] = $this->runConfigurationCheck($integration);
        (new ChannelIntegration())->recordTestResult($id, $status, $message);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'test_integration', 'channel_integration', $id);

        flash($status === 'ok' ? 'success' : 'error', 'Integration test: ' . $message);
        App::redirect('integrations');
    }

    public function delete(int $id): void
    {
        AuthMiddleware::handle(['Admin', 'Supervisor']);
        verify_csrf();
        (new ChannelIntegration())->delete($id);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'delete_integration', 'channel_integration', $id);
        flash('success', 'Integration deleted.');
        App::redirect('integrations');
    }

    private function payloadFromRequest(): array
    {
        return [
            'channel_type' => trim($_POST['channel_type'] ?? ''),
            'name' => trim($_POST['name'] ?? ''),
            'inbox_id' => (int)($_POST['inbox_id'] ?? 0),
            'api_base_url' => trim($_POST['api_base_url'] ?? ''),
            'api_key' => trim($_POST['api_key'] ?? ''),
            'api_secret' => trim($_POST['api_secret'] ?? ''),
            'access_token' => trim($_POST['access_token'] ?? ''),
            'webhook_verify_token' => trim($_POST['webhook_verify_token'] ?? ''),
            'webhook_url' => trim($_POST['webhook_url'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'config_json' => trim($_POST['config_json'] ?? ''),
        ];
    }

    private function validate(array $payload, bool $isUpdate = false): ?string
    {
        if ($payload['name'] === '') {
            return 'Integration name is required.';
        }

        $channels = ['whatsapp', 'messenger', 'instagram', 'telegram', 'email', 'website_chat'];
        if (!in_array($payload['channel_type'], $channels, true)) {
            return 'Invalid channel type.';
        }

        if ($payload['api_base_url'] !== '' && !filter_var($payload['api_base_url'], FILTER_VALIDATE_URL)) {
            return 'API base URL must be a valid URL.';
        }

        if ($payload['webhook_url'] !== '' && !filter_var($payload['webhook_url'], FILTER_VALIDATE_URL) && !str_starts_with($payload['webhook_url'], '/')) {
            return 'Webhook URL must be absolute URL or relative path starting with /.';
        }

        if ($payload['config_json'] !== '') {
            json_decode($payload['config_json'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return 'Additional Config JSON is invalid.';
            }
        }

        if (!$isUpdate && $payload['access_token'] === '' && !in_array($payload['channel_type'], ['website_chat', 'email'], true)) {
            return 'Access token is required for this channel.';
        }

        return null;
    }

    private function runConfigurationCheck(array $integration): array
    {
        $missing = [];
        if (trim((string)$integration['name']) === '') $missing[] = 'name';
        if (trim((string)$integration['channel_type']) === '') $missing[] = 'channel_type';
        if (trim((string)$integration['webhook_url']) === '') $missing[] = 'webhook_url';

        if (!in_array($integration['channel_type'], ['website_chat', 'email'], true) && trim((string)$integration['access_token']) === '') {
            $missing[] = 'access_token';
        }

        if ($missing) {
            return ['error', 'Missing required fields: ' . implode(', ', $missing)];
        }

        $json = trim((string)($integration['config_json'] ?? ''));
        if ($json !== '') {
            json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return ['error', 'Config JSON invalid: ' . json_last_error_msg()];
            }
        }

        $apiBase = trim((string)($integration['api_base_url'] ?? ''));
        if ($apiBase !== '' && filter_var($apiBase, FILTER_VALIDATE_URL)) {
            $ch = curl_init($apiBase);
            curl_setopt_array($ch, [
                CURLOPT_NOBODY => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5,
            ]);
            curl_exec($ch);
            $err = curl_error($ch);
            $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($err !== '') {
                return ['error', 'API base URL unreachable: ' . $err];
            }
            if ($code >= 500) {
                return ['error', 'API base URL returned server error: HTTP ' . $code];
            }
        }

        return ['ok', 'Configuration looks valid and endpoint checks passed.'];
    }

}
