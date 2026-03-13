<?php
class HealthController
{
    public function index(): void
    {
        header('Content-Type: application/json');
        try {
            App::$db->query('SELECT 1');
            echo json_encode([
                'ok' => true,
                'app' => App::$config['app']['name'] ?? 'Sassa Support',
                'time' => date('c'),
                'db' => 'up',
            ]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'db' => 'down', 'error' => 'database_unreachable']);
        }
    }
}
