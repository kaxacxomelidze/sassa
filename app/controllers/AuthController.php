<?php
class AuthController
{
    public function showLogin(): void
    {
        App::view('auth/login');
    }

    public function login(): void
    {
        verify_csrf();
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        if (!$email || !$password) {
            flash('error', 'Invalid credentials.');
            App::redirect('login');
        }

        $user = (new User())->findByEmail($email);
        if (!$user || !$user['is_active'] || !password_verify($password, $user['password_hash'])) {
            flash('error', 'Invalid credentials.');
            App::redirect('login');
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role_name' => $user['role_name'],
        ];
        session_regenerate_id(true);
        (new AuditLog())->add($user['id'], 'login');
        App::redirect('dashboard');
    }

    public function logout(): void
    {
        if (!empty($_SESSION['user']['id'])) {
            (new AuditLog())->add((int)$_SESSION['user']['id'], 'logout');
        }
        $_SESSION = [];
        session_destroy();
        App::redirect('login');
    }
}
