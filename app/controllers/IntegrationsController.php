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
        (new ChannelIntegration())->create($payload);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'create_integration', 'channel_integration');
        App::redirect('integrations');
    }

    public function update(int $id): void
    {
        AuthMiddleware::handle(['Admin', 'Supervisor']);
        verify_csrf();
        $payload = $this->payloadFromRequest();
        (new ChannelIntegration())->update($id, $payload);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'update_integration', 'channel_integration', $id);
        App::redirect('integrations');
    }

    public function delete(int $id): void
    {
        AuthMiddleware::handle(['Admin', 'Supervisor']);
        verify_csrf();
        (new ChannelIntegration())->delete($id);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'delete_integration', 'channel_integration', $id);
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
}
