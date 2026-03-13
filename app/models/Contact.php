<?php
class Contact extends BaseModel
{
    public function all(string $search = ''): array
    {
        $sql = 'SELECT * FROM contacts';
        $params = [];
        if ($search !== '') {
            $sql .= ' WHERE name LIKE ? OR email LIKE ? OR phone LIKE ?';
            $params = ["%$search%", "%$search%", "%$search%"];
        }
        $sql .= ' ORDER BY created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO contacts(name,email,phone,external_id,channel_source) VALUES(?,?,?,?,?)');
        $stmt->execute([$data['name'],$data['email'],$data['phone'],$data['external_id'],$data['channel_source']]);
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
    }
}
