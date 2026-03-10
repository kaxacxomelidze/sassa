<?php
if (!function_exists('renderIntegrationForm')) {
    function renderIntegrationForm(array $inboxes, array $it = []): void {
?>
<div class="row g-2">
  <div class="col-md-6"><label class="form-label">Integration Name</label><input class="form-control" name="name" required value="<?= e($it['name'] ?? '') ?>"></div>
  <div class="col-md-6"><label class="form-label">Channel Type</label>
    <select class="form-select" name="channel_type" required>
      <?php foreach (['whatsapp','messenger','instagram','telegram','email','website_chat'] as $channel): ?>
        <option value="<?= $channel ?>" <?= (($it['channel_type'] ?? '') === $channel) ? 'selected' : '' ?>><?= ucfirst($channel) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-6"><label class="form-label">Linked Inbox (optional)</label>
    <select class="form-select" name="inbox_id"><option value="0">Not linked</option><?php foreach ($inboxes as $inbox): ?><option value="<?= (int)$inbox['id'] ?>" <?= ((int)($it['inbox_id'] ?? 0) === (int)$inbox['id']) ? 'selected' : '' ?>><?= e($inbox['name']) ?></option><?php endforeach; ?></select>
  </div>
  <div class="col-md-6"><label class="form-label">API Base URL</label><input class="form-control" name="api_base_url" value="<?= e($it['api_base_url'] ?? '') ?>" placeholder="https://graph.facebook.com/"></div>
  <div class="col-md-6"><label class="form-label">API Key / App ID</label><input class="form-control" name="api_key" value="<?= e($it['api_key'] ?? '') ?>"></div>
  <div class="col-md-6"><label class="form-label">API Secret</label><input class="form-control" name="api_secret" value="<?= e($it['api_secret'] ?? '') ?>"></div>
  <div class="col-md-6"><label class="form-label">Access Token</label><input class="form-control" name="access_token" value="<?= e($it['access_token'] ?? '') ?>"></div>
  <div class="col-md-6"><label class="form-label">Webhook Verify Token</label><input class="form-control" name="webhook_verify_token" value="<?= e($it['webhook_verify_token'] ?? '') ?>"></div>
  <div class="col-md-12"><label class="form-label">Webhook URL (provider callback target)</label><input class="form-control" name="webhook_url" value="<?= e($it['webhook_url'] ?? '') ?>"></div>
  <div class="col-md-12"><label class="form-label">Additional Config JSON</label><textarea class="form-control" name="config_json" rows="3" placeholder='{"phone_number_id":"123"}'><?= e($it['config_json'] ?? '') ?></textarea></div>
  <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" <?= !isset($it['is_active']) || $it['is_active'] ? 'checked' : '' ?>><label class="form-check-label">Active integration</label></div></div>
</div>
<?php
    }
}
