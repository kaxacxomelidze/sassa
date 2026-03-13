<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="mb-1">Channel Integrations</h3>
    <p class="text-muted mb-0">Manage API credentials, webhook endpoints, and readiness checks in one place.</p>
  </div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIntegrationModal"><i class="bi bi-plug me-1"></i>Add Integration</button>
</div>

<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="alert alert-danger"><?= e($msg) ?></div><?php endif; ?>

<div class="alert alert-info small d-flex flex-wrap gap-2 align-items-center">
  <span><strong>Webhook endpoints:</strong></span>
  <code><?= App::url('webhooks/whatsapp') ?></code>
  <code><?= App::url('webhooks/messenger') ?></code>
  <code><?= App::url('webhooks/instagram') ?></code>
  <code><?= App::url('webhooks/telegram') ?></code>
  <code><?= App::url('webhooks/email-parser') ?></code>
</div>

<?php require __DIR__ . '/partials/form_fields.php'; ?>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0 integration-table">
      <thead>
      <tr>
        <th>Name</th>
        <th>Channel</th>
        <th>Inbox</th>
        <th>Secret Preview</th>
        <th>Last Test</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($integrations as $it): ?>
        <tr>
          <td class="fw-semibold"><?= e($it['name']) ?><div class="small text-muted"><?= e($it['api_base_url'] ?: '-') ?></div></td>
          <td><span class="badge text-bg-light border text-uppercase"><?= e($it['channel_type']) ?></span></td>
          <td><?= e($it['inbox_name'] ?? '-') ?></td>
          <td class="small">
            <div>Key: <code><?= e(mask_secret($it['api_key'] ?? '')) ?></code></div>
            <div>Token: <code><?= e(mask_secret($it['access_token'] ?? '')) ?></code></div>
          </td>
          <td class="small text-muted"><?= e($it['last_test_at'] ?? 'Never') ?><div><?= e($it['last_test_message'] ?? '-') ?></div></td>
          <td>
            <?php if (($it['last_test_status'] ?? '') === 'ok'): ?>
              <span class="badge text-bg-success">Ready</span>
            <?php elseif (($it['last_test_status'] ?? '') === 'error'): ?>
              <span class="badge text-bg-danger">Needs Fix</span>
            <?php else: ?>
              <span class="badge text-bg-secondary">Not Tested</span>
            <?php endif; ?>
            <?= $it['is_active'] ? '<div class="small text-success">Active</div>' : '<div class="small text-muted">Inactive</div>' ?>
          </td>
          <td>
            <div class="d-flex gap-1 flex-wrap">
              <form method="post" action="<?= App::url('integrations/' . (int)$it['id'] . '/test') ?>" class="d-inline">
                <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                <button class="btn btn-sm btn-outline-success">Test</button>
              </form>
              <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editIntegration<?= (int)$it['id'] ?>">Edit</button>
              <form method="post" action="<?= App::url('integrations/' . (int)$it['id'] . '/delete') ?>" class="d-inline">
                <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this integration?')">Delete</button>
              </form>
            </div>
          </td>
        </tr>

        <div class="modal fade" id="editIntegration<?= (int)$it['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
            <form method="post" action="<?= App::url('integrations/' . (int)$it['id'] . '/update') ?>" class="integration-form">
              <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
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
  <div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
    <form method="post" action="<?= App::url('integrations') ?>" class="integration-form">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <div class="modal-header"><h5 class="modal-title">Add Integration</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body"><?php renderIntegrationForm($inboxes); ?></div>
      <div class="modal-footer"><button class="btn btn-primary">Save Integration</button></div>
    </form>
  </div></div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
