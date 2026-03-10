<?php require __DIR__ . '/../partials/header.php'; ?>
<h3>Inboxes / Channels</h3>
<div class="card mb-3"><div class="card-body"><form method="post" action="<?= App::url('inboxes') ?>" class="row g-2">
<input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
<div class="col"><input class="form-control" name="name" placeholder="Inbox name" required></div>
<div class="col"><select class="form-select" name="channel_type"><option>website_chat</option><option>whatsapp</option><option>messenger</option><option>instagram</option><option>telegram</option><option>email</option></select></div>
<div class="col-auto form-check mt-2"><input class="form-check-input" type="checkbox" name="is_active" checked><label class="form-check-label">Active</label></div>
<div class="col-12"><button class="btn btn-primary">Create Inbox</button></div>
</form></div></div>
<table class="table"><thead><tr><th>Name</th><th>Channel</th><th>Status</th></tr></thead><tbody>
<?php foreach ($inboxes as $i): ?><tr><td><?= e($i['name']) ?></td><td><?= e($i['channel_type']) ?></td><td><?= $i['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' ?></td></tr><?php endforeach; ?>
</tbody></table>
<?php require __DIR__ . '/../partials/footer.php'; ?>
