<?php
class Message extends BaseModel
{
    public function byConversation(int $conversationId): array
    {
        $stmt = $this->db->prepare('SELECT m.*, u.name agent_name FROM messages m LEFT JOIN users u ON u.id=m.sender_user_id WHERE conversation_id=? ORDER BY created_at ASC');
        $stmt->execute([$conversationId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare("INSERT INTO messages(conversation_id,sender_type,sender_user_id,body,message_type,delivery_status,read_status) VALUES(?,?,?,?,?,?,?)");
        $stmt->execute([$data['conversation_id'],$data['sender_type'],$data['sender_user_id'],$data['body'],$data['message_type'],$data['delivery_status'],$data['read_status']]);
        $this->db->prepare('UPDATE conversations SET updated_at=NOW() WHERE id=?')->execute([$data['conversation_id']]);
    }
}
