<?php
class User extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT u.*, r.name AS role_name FROM users u JOIN roles r ON r.id=u.role_id WHERE email=? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM users WHERE is_active=1')->fetchColumn();
    }

    public function all(): array
    {
        $sql = 'SELECT u.*, r.name AS role_name FROM users u JOIN roles r ON r.id=u.role_id ORDER BY u.created_at DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function roles(): array
    {
        return $this->db->query('SELECT * FROM roles ORDER BY id')->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO users(role_id,name,email,password_hash,is_active) VALUES(?,?,?,?,?)');
        $stmt->execute([$data['role_id'], $data['name'], $data['email'], $data['password_hash'], $data['is_active']]);
    }

    public function toggleStatus(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE users SET is_active = IF(is_active=1,0,1), updated_at=NOW() WHERE id=?');
        $stmt->execute([$id]);
    }
}
