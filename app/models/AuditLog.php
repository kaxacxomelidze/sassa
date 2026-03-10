<?php
class AuditLog extends BaseModel
{
    public function add(int $userId, string $action, string $entityType = '', ?int $entityId = null): void
    {
        $stmt = $this->db->prepare('INSERT INTO audit_logs(user_id,action,entity_type,entity_id,ip_address,user_agent) VALUES(?,?,?,?,?,?)');
        $stmt->execute([$userId,$action,$entityType,$entityId,$_SERVER['REMOTE_ADDR'] ?? '',$_SERVER['HTTP_USER_AGENT'] ?? '']);
    }

    public function recent(int $limit = 8): array
    {
        $stmt=$this->db->prepare('SELECT a.*, u.name user_name FROM audit_logs a LEFT JOIN users u ON u.id=a.user_id ORDER BY a.created_at DESC LIMIT ?');
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
