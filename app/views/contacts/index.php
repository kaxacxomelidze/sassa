<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3"><h3>Contacts</h3></div>
<form class="mb-3"><input class="form-control" name="search" placeholder="Search contacts"></form>
<div class="card mb-3"><div class="card-body">
<form method="post" action="<?= App::url('contacts') ?>" class="row g-2">
<input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
<div class="col"><input class="form-control" name="name" placeholder="Name" required></div>
<div class="col"><input class="form-control" name="email" placeholder="Email"></div>
<div class="col"><input class="form-control" name="phone" placeholder="Phone"></div>
<div class="col"><input class="form-control" name="external_id" placeholder="External ID"></div>
<div class="col"><select class="form-select" name="channel_source"><option>website_chat</option><option>whatsapp</option><option>messenger</option></select></div>
<div class="col-12"><button class="btn btn-primary">Add Contact</button></div>
</form>
</div></div>
<table class="table table-striped"><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Source</th><th>Created</th></tr></thead><tbody>
<?php foreach ($contacts as $c): ?><tr><td><?= e($c['name']) ?></td><td><?= e($c['email']) ?></td><td><?= e($c['phone']) ?></td><td><span class="badge bg-info"><?= e($c['channel_source']) ?></span></td><td><?= e($c['created_at']) ?></td></tr><?php endforeach; ?>
</tbody></table>
<?php require __DIR__ . '/../partials/footer.php'; ?>
