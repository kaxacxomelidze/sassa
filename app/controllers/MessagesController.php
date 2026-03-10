<?php
class MessagesController
{
    public function storeAjax(): void
    {
        AuthMiddleware::handle();
        verify_csrf();
        header('Content-Type: application/json');
        $body = trim($_POST['body'] ?? '');
        if ($body === '') {
            echo json_encode(['ok' => false, 'error' => 'Message body is required']);
            return;
        }
        (new Message())->create([
            'conversation_id' => (int)$_POST['conversation_id'],
            'sender_type' => 'agent',
            'sender_user_id' => (int)$_SESSION['user']['id'],
            'body' => $body,
            'message_type' => $_POST['message_type'] ?? 'text',
            'delivery_status' => 'sent',
            'read_status' => 'unread',
        ]);
        echo json_encode(['ok' => true]);
    }

    public function poll(int $conversationId): void
    {
        AuthMiddleware::handle();
        header('Content-Type: application/json');
        echo json_encode((new Message())->byConversation($conversationId));
    }
}
