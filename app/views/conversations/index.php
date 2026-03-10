<?php require __DIR__ . '/../partials/header.php'; ?>
<h3>Conversations</h3>
<form class="row g-2 mb-3">
<div class="col-md-3"><select class="form-select" name="status"><option value="">All statuses</option><option>open</option><option>pending</option><option>resolved</option><option>closed</option></select></div>
<div class="col-md-3"><select class="form-select" name="inbox_id"><option value="">All inboxes</option><?php foreach ($inboxes as $i): ?><option value="<?= $i['id'] ?>"><?= e($i['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-2"><button class="btn btn-outline-primary">Filter</button></div>
</form>
<div class="list-group">
<?php foreach ($conversations as $c): ?>
<a class="list-group-item list-group-item-action" href="<?= App::url('conversations/' . $c['id']) ?>">
  <div class="d-flex justify-content-between"><strong>#<?= $c['id'] ?> <?= e($c['contact_name']) ?></strong><span class="badge bg-secondary"><?= e($c['status']) ?></span></div>
  <small><?= e($c['inbox_name']) ?> • Assigned: <?= e($c['agent_name'] ?? 'Unassigned') ?></small>
</a>
<?php endforeach; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
