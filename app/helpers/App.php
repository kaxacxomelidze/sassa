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

    public static function basePath(): string
    {
        $configured = trim(parse_url(self::$config['app']['url'] ?? '', PHP_URL_PATH) ?? '', '/');
        $requestPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '', '/');

        if ($configured !== '' && ($requestPath === $configured || str_starts_with($requestPath, $configured . '/'))) {
            return $configured;
        }

        $scriptDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($scriptDir === '.' || $scriptDir === '') {
            return '';
        }

        if (str_ends_with($scriptDir, '/public')) {
            $scriptDir = trim(substr($scriptDir, 0, -7), '/');
        }

        return $scriptDir;
    }

    public static function url(string $path = ''): string
    {
        $base = self::basePath();
        $relative = ltrim($path, '/');
        return '/' . ($base ? $base . '/' : '') . $relative;
    }
}
