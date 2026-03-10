<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h3 class="mb-1">Conversations</h3><p class="text-muted mb-0">Track, filter, and work every customer thread.</p></div>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-3"><select class="form-select" name="status"><option value="">All statuses</option><option value="open">open</option><option value="pending">pending</option><option value="resolved">resolved</option><option value="closed">closed</option></select></div>
  <div class="col-md-3"><select class="form-select" name="inbox_id"><option value="">All inboxes</option><?php foreach ($inboxes as $i): ?><option value="<?= $i['id'] ?>"><?= e($i['name']) ?></option><?php endforeach; ?></select></div>
  <div class="col-md-2"><button class="btn btn-outline-primary w-100">Apply</button></div>
</form>

<div class="card border-0 shadow-sm">
  <div class="list-group list-group-flush">
    <?php foreach ($conversations as $c): ?>
    <a class="list-group-item list-group-item-action p-3" href="<?= App::url('conversations/' . $c['id']) ?>">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <strong>#<?= $c['id'] ?> · <?= e($c['contact_name']) ?></strong>
        <div class="d-flex gap-2">
          <span class="badge text-bg-light border"><?= e($c['priority']) ?></span>
          <span class="badge text-bg-secondary"><?= e($c['status']) ?></span>
        </div>
      </div>
      <small class="text-muted"><?= e($c['inbox_name']) ?> • Assigned: <?= e($c['agent_name'] ?? 'Unassigned') ?></small>
    </a>
    <?php endforeach; ?>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
