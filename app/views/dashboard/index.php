<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="mb-1">Dashboard</h3>
    <p class="text-muted mb-0">Live snapshot of support performance.</p>
  </div>
</div>

<div class="row g-3 mb-4">
<?php foreach (['total'=>'All','open'=>'Open','pending'=>'Pending','resolved'=>'Resolved','closed'=>'Closed','unassigned'=>'Unassigned'] as $k => $label): ?>
  <div class="col-6 col-lg-2">
    <div class="card stat-card h-100">
      <div class="card-body">
        <small class="text-muted d-block"><?= e($label) ?></small>
        <h4 class="mb-0"><?= (int)$stats[$k] ?></h4>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<div class="row g-3">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-transparent"><strong>Recent Activity</strong></div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead><tr><th>User</th><th>Action</th><th class="text-end">Time</th></tr></thead>
          <tbody>
          <?php foreach ($activities as $a): ?>
            <tr>
              <td><?= e($a['user_name'] ?? 'System') ?></td>
              <td><span class="badge text-bg-light border"><?= e($a['action']) ?></span></td>
              <td class="text-end text-muted small"><?= e($a['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm mb-3"><div class="card-body"><small class="text-muted">Total contacts</small><h3 class="mb-0"><?= $contacts ?></h3></div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Total agents</small><h3 class="mb-0"><?= $agents ?></h3></div></div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
