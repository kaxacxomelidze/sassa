<?php
class Conversation extends BaseModel
{
    public function stats(): array
    {
        return [
            'total' => (int)$this->db->query('SELECT COUNT(*) FROM conversations')->fetchColumn(),
            'open' => (int)$this->db->query("SELECT COUNT(*) FROM conversations WHERE status='open'")->fetchColumn(),
            'pending' => (int)$this->db->query("SELECT COUNT(*) FROM conversations WHERE status='pending'")->fetchColumn(),
            'closed' => (int)$this->db->query("SELECT COUNT(*) FROM conversations WHERE status='closed'")->fetchColumn(),
            'unassigned' => (int)$this->db->query('SELECT COUNT(*) FROM conversations WHERE assigned_user_id IS NULL')->fetchColumn(),
            'resolved' => (int)$this->db->query("SELECT COUNT(*) FROM conversations WHERE status='resolved'")->fetchColumn(),
        ];
    }

    public function all(array $filters = []): array
    {
        $sql = 'SELECT c.*, ct.name contact_name, i.name inbox_name, u.name agent_name FROM conversations c
                JOIN contacts ct ON ct.id=c.contact_id
                JOIN inboxes i ON i.id=c.inbox_id
                LEFT JOIN users u ON u.id=c.assigned_user_id WHERE 1=1';
        $params=[];
        if (!empty($filters['status'])) { $sql .= ' AND c.status=?'; $params[]=$filters['status']; }
        if (!empty($filters['inbox_id'])) { $sql .= ' AND c.inbox_id=?'; $params[]=$filters['inbox_id']; }
        $sql .= ' ORDER BY c.updated_at DESC';
        $stmt=$this->db->prepare($sql);$stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt=$this->db->prepare('SELECT c.*, ct.name contact_name, ct.email, ct.phone, i.name inbox_name FROM conversations c JOIN contacts ct ON ct.id=c.contact_id JOIN inboxes i ON i.id=c.inbox_id WHERE c.id=?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(int $contactId, int $inboxId, string $subject='Website Chat'): int
    {
        $stmt=$this->db->prepare("INSERT INTO conversations(contact_id,inbox_id,subject,status,priority) VALUES(?,?,?,'open','normal')");
        $stmt->execute([$contactId,$inboxId,$subject]);
        return (int)$this->db->lastInsertId();
    }
}
