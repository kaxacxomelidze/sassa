<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h3 class="mb-1">Inboxes / Channels</h3><p class="text-muted mb-0">Prepare channels for omnichannel routing.</p></div>
</div>

<div class="card border-0 shadow-sm mb-3">
  <div class="card-body">
    <form method="post" action="<?= App::url('inboxes') ?>" class="row g-2 align-items-end">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <div class="col-md-4"><label class="form-label">Inbox Name</label><input class="form-control" name="name" placeholder="Website Chat" required></div>
      <div class="col-md-4"><label class="form-label">Channel Type</label><select class="form-select" name="channel_type"><option>website_chat</option><option>whatsapp</option><option>messenger</option><option>instagram</option><option>telegram</option><option>email</option></select></div>
      <div class="col-md-2"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" checked><label class="form-check-label">Active</label></div></div>
      <div class="col-md-2"><button class="btn btn-primary w-100">Create</button></div>
    </form>
  </div>
</div>

<div class="row g-3">
<?php foreach ($inboxes as $i): ?>
  <div class="col-md-6 col-xl-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <h5 class="mb-1"><?= e($i['name']) ?></h5>
          <?= $i['is_active'] ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-secondary">Inactive</span>' ?>
        </div>
        <small class="text-muted"><?= e(strtoupper($i['channel_type'])) ?></small>
        <p class="text-muted mt-3 mb-0 small">API/webhook credentials can be attached in future integrations.</p>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
