<?php
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string
{
    $key = App::$config['security']['csrf_token_name'];
    if (empty($_SESSION[$key])) {
        $_SESSION[$key] = bin2hex(random_bytes(32));
    }
    return $_SESSION[$key];
}

function verify_csrf(): void
{
    $key = App::$config['security']['csrf_token_name'];
    $token = $_POST[$key] ?? '';
    if (!hash_equals($_SESSION[$key] ?? '', $token)) {
        http_response_code(419);
        exit('CSRF validation failed.');
    }
}

function is_post(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function flash(string $key, ?string $value = null): ?string
{
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }
    $msg = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $msg;
}

function mask_secret(?string $value): string
{
    $value = (string) $value;
    $len = strlen($value);
    if ($len <= 4) {
        return $len ? str_repeat('*', $len) : '-';
    }
    return substr($value, 0, 2) . str_repeat('*', max(2, $len - 4)) . substr($value, -2);
}

function app_key(): string
{
    $key = (string)(App::$config['app']['key'] ?? '');
    if ($key === '') {
        return hash('sha256', 'sassa-default-insecure-key-change-me', true);
    }
    if (str_starts_with($key, 'base64:')) {
        return base64_decode(substr($key, 7), true) ?: hash('sha256', $key, true);
    }
    return hash('sha256', $key, true);
}

function encrypt_value(?string $plain): ?string
{
    if ($plain === null || $plain === '') {
        return $plain;
    }
    $iv = random_bytes(16);
    $enc = openssl_encrypt($plain, 'AES-256-CBC', app_key(), OPENSSL_RAW_DATA, $iv);
    if ($enc === false) {
        return $plain;
    }
    return 'enc:' . base64_encode($iv . $enc);
}

function decrypt_value(?string $cipher): ?string
{
    if ($cipher === null || $cipher === '') {
        return $cipher;
    }
    if (!str_starts_with($cipher, 'enc:')) {
        return $cipher;
    }
    $raw = base64_decode(substr($cipher, 4), true);
    if ($raw === false || strlen($raw) < 17) {
        return '';
    }
    $iv = substr($raw, 0, 16);
    $payload = substr($raw, 16);
    $dec = openssl_decrypt($payload, 'AES-256-CBC', app_key(), OPENSSL_RAW_DATA, $iv);
    return $dec === false ? '' : $dec;
}
