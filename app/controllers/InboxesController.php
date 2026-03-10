<?php
class InboxesController
{
    public function index(): void
    {
        AuthMiddleware::handle(['Admin','Supervisor']);
        App::view('inboxes/index', ['inboxes' => (new Inbox())->all()]);
    }

    public function store(): void
    {
        AuthMiddleware::handle(['Admin','Supervisor']);
        verify_csrf();
        (new Inbox())->create([
            'name' => trim($_POST['name'] ?? ''),
            'channel_type' => trim($_POST['channel_type'] ?? 'website_chat'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        App::redirect('inboxes');
    }
}
