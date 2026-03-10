<?php
class ChannelIntegration extends BaseModel
{
    public function all(): array
    {
        $sql = 'SELECT ci.*, i.name AS inbox_name FROM channel_integrations ci LEFT JOIN inboxes i ON i.id = ci.inbox_id ORDER BY ci.created_at DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM channel_integrations WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO channel_integrations(channel_type,name,inbox_id,api_base_url,api_key,api_secret,access_token,webhook_verify_token,webhook_url,is_active,config_json) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
        $stmt->execute([
            $data['channel_type'],
            $data['name'],
            $data['inbox_id'] ?: null,
            $data['api_base_url'],
            $data['api_key'],
            $data['api_secret'],
            $data['access_token'],
            $data['webhook_verify_token'],
            $data['webhook_url'],
            $data['is_active'],
            $data['config_json'] ?: null,
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE channel_integrations SET channel_type=?, name=?, inbox_id=?, api_base_url=?, api_key=?, api_secret=?, access_token=?, webhook_verify_token=?, webhook_url=?, is_active=?, config_json=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([
            $data['channel_type'],
            $data['name'],
            $data['inbox_id'] ?: null,
            $data['api_base_url'],
            $data['api_key'],
            $data['api_secret'],
            $data['access_token'],
            $data['webhook_verify_token'],
            $data['webhook_url'],
            $data['is_active'],
            $data['config_json'] ?: null,
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM channel_integrations WHERE id = ?');
        $stmt->execute([$id]);
    }
}
