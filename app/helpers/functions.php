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
