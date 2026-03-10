<?php
class WidgetController
{
    public function embed(): void
    {
        App::view('partials/widget');
    }

    public function createConversation(): void
    {
        verify_csrf();
        $contactModel = new Contact();
        $contactModel->create([
            'name' => trim($_POST['name'] ?? 'Visitor'),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => '',
            'external_id' => uniqid('web_', true),
            'channel_source' => 'website_chat',
        ]);
        $contactId = (int)App::$db->lastInsertId();
        $conversationId = (new Conversation())->create($contactId, 1, 'Live chat inquiry');
        (new Message())->create([
            'conversation_id' => $conversationId,
            'sender_type' => 'contact',
            'sender_user_id' => null,
            'body' => trim($_POST['message'] ?? ''),
            'message_type' => 'text',
            'delivery_status' => 'received',
            'read_status' => 'unread',
        ]);
        $_SESSION['widget_conversation_id'] = $conversationId;
        App::redirect('widget');
    }
}
