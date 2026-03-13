<?php
class WebhookController
{
    private function log(string $source, string $status = 'received'): void
    {
        $payload = file_get_contents('php://input');
        $stmt = App::$db->prepare('INSERT INTO webhooks_log(source,payload,headers,status) VALUES(?,?,?,?)');
        $stmt->execute([$source, $payload, json_encode(getallheaders()), $status]);
    }

    private function verifyMetaChallenge(string $channel): void
    {
        $mode = $_GET['hub_mode'] ?? $_GET['hub.mode'] ?? '';
        $token = $_GET['hub_verify_token'] ?? $_GET['hub.verify_token'] ?? '';
        $challenge = $_GET['hub_challenge'] ?? $_GET['hub.challenge'] ?? '';

        $integration = (new ChannelIntegration())->findByChannel($channel);
        $expected = $integration['webhook_verify_token'] ?? '';

        if ($mode === 'subscribe' && $token !== '' && hash_equals((string)$expected, (string)$token)) {
            http_response_code(200);
            echo $challenge;
            return;
        }

        $this->log($channel, 'verify_failed');
        http_response_code(403);
        echo 'Invalid verify token';
    }

    private function handleInbound(string $source): void
    {
        $this->log($source, 'received');
        header('Content-Type: application/json');
        echo json_encode(['ok' => true, 'source' => $source]);
    }

    public function whatsapp(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
            $this->verifyMetaChallenge('whatsapp');
            return;
        }
        $this->handleInbound('whatsapp');
    }

    public function messenger(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
            $this->verifyMetaChallenge('messenger');
            return;
        }
        $this->handleInbound('messenger');
    }

    public function instagram(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
            $this->verifyMetaChallenge('instagram');
            return;
        }
        $this->handleInbound('instagram');
    }

    public function telegram(): void { $this->handleInbound('telegram'); }
    public function emailParser(): void { $this->handleInbound('email'); }
}
