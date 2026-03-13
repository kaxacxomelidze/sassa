<?php
class DashboardController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $conv = new Conversation();
        App::view('dashboard/index', [
            'stats' => $conv->stats(),
            'contacts' => (new Contact())->countAll(),
            'agents' => (new User())->countAll(),
            'activities' => (new AuditLog())->recent(),
        ]);
    }
}
