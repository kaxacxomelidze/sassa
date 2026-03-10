<?php
class Inbox extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM inboxes ORDER BY created_at DESC')->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO inboxes(name,channel_type,is_active) VALUES(?,?,?)');
        $stmt->execute([$data['name'],$data['channel_type'],(int)$data['is_active']]);
    }
}
