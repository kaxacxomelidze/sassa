<?php
class ConversationsController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $filters = [
            'status' => $_GET['status'] ?? '',
            'inbox_id' => $_GET['inbox_id'] ?? '',
        ];
        App::view('conversations/index', [
            'conversations' => (new Conversation())->all($filters),
            'inboxes' => (new Inbox())->all(),
        ]);
    }

    public function show(int $id): void
    {
        AuthMiddleware::handle();
        App::view('conversations/show', [
            'conversation' => (new Conversation())->find($id),
            'messages' => (new Message())->byConversation($id),
        ]);
    }
}
