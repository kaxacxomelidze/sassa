<?php
class ContactsController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $search = trim($_GET['search'] ?? '');
        App::view('contacts/index', ['contacts' => (new Contact())->all($search)]);
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        verify_csrf();
        (new Contact())->create([
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'external_id' => trim($_POST['external_id'] ?? ''),
            'channel_source' => trim($_POST['channel_source'] ?? 'website'),
        ]);
        (new AuditLog())->add((int)$_SESSION['user']['id'], 'create_contact', 'contact');
        App::redirect('contacts');
    }
}
