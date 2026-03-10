<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="mb-1">Channel Integrations</h3>
    <p class="text-muted mb-0">Save API credentials and webhook settings for WhatsApp, Messenger, Instagram, Telegram, and Email.</p>
  </div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIntegrationModal"><i class="bi bi-plug me-1"></i>Add Integration</button>
</div>

<div class="alert alert-info small">
  Configure API details here first. Then connect provider webhooks to: 
  <code><?= App::url('webhooks/whatsapp') ?></code>, <code><?= App::url('webhooks/messenger') ?></code>, <code><?= App::url('webhooks/instagram') ?></code>, <code><?= App::url('webhooks/telegram') ?></code>, <code><?= App::url('webhooks/email-parser') ?></code>
</div>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>Name</th><th>Channel</th><th>Inbox</th><th>Webhook URL</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach ($integrations as $it): ?>
        <tr>
          <td class="fw-semibold"><?= e($it['name']) ?></td>
          <td><span class="badge text-bg-light border"><?= e($it['channel_type']) ?></span></td>
          <td><?= e($it['inbox_name'] ?? '-') ?></td>
          <td class="small text-muted"><?= e($it['webhook_url']) ?></td>
          <td><?= $it['is_active'] ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-secondary">Inactive</span>' ?></td>
          <td>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editIntegration<?= (int)$it['id'] ?>">Edit</button>
            <form method="post" action="<?= App::url('integrations/' . (int)$it['id'] . '/delete') ?>" class="d-inline">
              <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this integration?')">Delete</button>
            </form>
          </td>
        </tr>

        <div class="modal fade" id="editIntegration<?= (int)$it['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-lg"><div class="modal-content">
            <form method="post" action="<?= App::url('integrations/' . (int)$it['id'] . '/update') ?>">
              <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
              <?php require __DIR__ . '/partials/form_fields.php'; ?>
              <div class="modal-header"><h5 class="modal-title">Edit Integration</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
              <div class="modal-body"><?php renderIntegrationForm($inboxes, $it); ?></div>
              <div class="modal-footer"><button class="btn btn-primary">Save Changes</button></div>
            </form>
          </div></div>
        </div>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addIntegrationModal" tabindex="-1">
  <div class="modal-dialog modal-lg"><div class="modal-content">
    <form method="post" action="<?= App::url('integrations') ?>">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <?php require __DIR__ . '/partials/form_fields.php'; ?>
      <div class="modal-header"><h5 class="modal-title">Add Integration</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body"><?php renderIntegrationForm($inboxes); ?></div>
      <div class="modal-footer"><button class="btn btn-primary">Save Integration</button></div>
    </form>
  </div></div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
