<?php require __DIR__ . '/../partials/header.php'; ?>
<h3>Dashboard</h3>
<div class="row g-3 mb-4">
<?php foreach (['total','open','pending','resolved','closed','unassigned'] as $k): ?>
<div class="col-md-2"><div class="card stat-card"><div class="card-body"><small><?= ucfirst($k) ?></small><h4><?= (int)$stats[$k] ?></h4></div></div></div>
<?php endforeach; ?>
<div class="col-md-3"><div class="card"><div class="card-body"><small>Total contacts</small><h4><?= $contacts ?></h4></div></div></div>
<div class="col-md-3"><div class="card"><div class="card-body"><small>Total agents</small><h4><?= $agents ?></h4></div></div></div>
</div>
<div class="card"><div class="card-header">Recent activity</div><ul class="list-group list-group-flush">
<?php foreach ($activities as $a): ?><li class="list-group-item"><?= e($a['user_name'] ?? 'System') ?> - <?= e($a['action']) ?> <span class="text-muted small float-end"><?= e($a['created_at']) ?></span></li><?php endforeach; ?>
</ul></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
