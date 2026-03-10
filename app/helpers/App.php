<?php
class App
{
    public static array $config = [];
    public static PDO $db;

    public static function init(): void
    {
        self::$config = require __DIR__ . '/../../config/config.php';
        date_default_timezone_set(self::$config['app']['timezone']);

        if (session_status() === PHP_SESSION_NONE) {
            session_name(self::$config['app']['session_name']);
            session_set_cookie_params([
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }

        $db = self::$config['db'];
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $db['host'], $db['port'], $db['name'], $db['charset']);
        self::$db = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function view(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }

    public static function redirect(string $path): void
    {
        header('Location: ' . self::url($path));
        exit;
    }

    public static function url(string $path = ''): string
    {
        return rtrim(self::$config['app']['url'], '/') . '/' . ltrim($path, '/');
    }
}
