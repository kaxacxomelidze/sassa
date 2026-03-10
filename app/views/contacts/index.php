<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h3 class="mb-1">Contacts</h3><p class="text-muted mb-0">Customer directory across all channels.</p></div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal"><i class="bi bi-plus-lg me-1"></i>Add Contact</button>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-5"><input class="form-control" name="search" value="<?= e($_GET['search'] ?? '') ?>" placeholder="Search name, email, phone..."></div>
  <div class="col-md-2"><button class="btn btn-outline-primary w-100">Search</button></div>
</form>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Source</th><th>Created</th></tr></thead>
      <tbody>
      <?php foreach ($contacts as $c): ?>
        <tr>
          <td class="fw-semibold"><?= e($c['name']) ?></td>
          <td><?= e($c['email']) ?></td>
          <td><?= e($c['phone']) ?></td>
          <td><span class="badge rounded-pill text-bg-info-subtle border text-info-emphasis"><?= e($c['channel_source']) ?></span></td>
          <td class="text-muted small"><?= e($c['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addContactModal" tabindex="-1">
  <div class="modal-dialog modal-lg"><div class="modal-content">
    <form method="post" action="<?= App::url('contacts') ?>">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <div class="modal-header"><h5 class="modal-title">Add Contact</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body"><div class="row g-2">
        <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
        <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" name="email"></div>
        <div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
        <div class="col-md-4"><label class="form-label">External ID</label><input class="form-control" name="external_id"></div>
        <div class="col-md-4"><label class="form-label">Channel Source</label><select class="form-select" name="channel_source"><option>website_chat</option><option>whatsapp</option><option>messenger</option><option>instagram</option><option>telegram</option><option>email</option></select></div>
      </div></div>
      <div class="modal-footer"><button class="btn btn-primary">Save Contact</button></div>
    </form>
  </div></div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
