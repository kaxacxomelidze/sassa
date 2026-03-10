<?php
class AuthMiddleware
{
    public static function handle(array $roles = []): void
    {
        if (empty($_SESSION['user'])) {
            App::redirect('login');
        }
        if ($roles && !in_array($_SESSION['user']['role_name'], $roles, true)) {
            http_response_code(403);
            exit('Forbidden');
        }
    }
}
