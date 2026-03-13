<?php
class WebhookController
{
    private function log(string $source): void
    {
        $payload = file_get_contents('php://input');
        $stmt = App::$db->prepare('INSERT INTO webhooks_log(source,payload,headers,status) VALUES(?,?,?,?)');
        $stmt->execute([$source, $payload, json_encode(getallheaders()), 'received']);
        header('Content-Type: application/json');
        echo json_encode(['ok' => true, 'source' => $source, 'status' => 'placeholder']);
    }

    public function whatsapp(): void { $this->log('whatsapp'); }
    public function messenger(): void { $this->log('messenger'); }
    public function instagram(): void { $this->log('instagram'); }
    public function telegram(): void { $this->log('telegram'); }
    public function emailParser(): void { $this->log('email'); }
}
