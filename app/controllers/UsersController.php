<?php
class UsersController
{
    public function index(): void
    {
        AuthMiddleware::handle(['Admin']);
        $model = new User();
        App::view('users/index', [
            'users' => $model->all(),
            'roles' => $model->roles(),
        ]);
    }

    public function store(): void
    {
        AuthMiddleware::handle(['Admin']);
        verify_csrf();

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $name = trim($_POST['name'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $roleId = (int)($_POST['role_id'] ?? 0);

        if (!$email || $name === '' || strlen($password) < 8 || $roleId < 1) {
            flash('error', 'Invalid user data. Ensure email is valid and password has at least 8 characters.');
            App::redirect('users');
        }

        (new User())->create([
            'role_id' => $roleId,
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'create_user', 'user');
        flash('success', 'User created.');
        App::redirect('users');
    }

    public function toggle(int $id): void
    {
        AuthMiddleware::handle(['Admin']);
        verify_csrf();
        (new User())->toggleStatus($id);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'toggle_user_status', 'user', $id);
        flash('success', 'User status updated.');
        App::redirect('users');
    }
}
