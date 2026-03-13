<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="mb-1">Users & Agents</h3>
    <p class="text-muted mb-0">Manage admin/supervisor/agent access and account status.</p>
  </div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-person-plus me-1"></i>Add User</button>
</div>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="alert alert-danger"><?= e($msg) ?></div><?php endif; ?>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td class="fw-semibold"><?= e($u['name']) ?></td>
            <td><?= e($u['email']) ?></td>
            <td><span class="badge text-bg-light border"><?= e($u['role_name']) ?></span></td>
            <td><?= $u['is_active'] ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-secondary">Inactive</span>' ?></td>
            <td class="small text-muted"><?= e($u['created_at']) ?></td>
            <td>
              <form method="post" action="<?= App::url('users/' . (int)$u['id'] . '/toggle') ?>" class="d-inline">
                <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                <button class="btn btn-sm btn-outline-primary">Toggle</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="post" action="<?= App::url('users') ?>">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <div class="modal-header"><h5 class="modal-title">Add User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body row g-2">
        <div class="col-12"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
        <div class="col-12"><label class="form-label">Email</label><input class="form-control" name="email" type="email" required></div>
        <div class="col-12"><label class="form-label">Password</label><input class="form-control" name="password" type="password" minlength="8" required></div>
        <div class="col-12"><label class="form-label">Role</label><select class="form-select" name="role_id" required><?php foreach ($roles as $r): ?><option value="<?= (int)$r['id'] ?>"><?= e($r['name']) ?></option><?php endforeach; ?></select></div>
        <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" checked><label class="form-check-label">Active user</label></div></div>
      </div>
      <div class="modal-footer"><button class="btn btn-primary">Create User</button></div>
    </form>
  </div></div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
