<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="row justify-content-center mt-5"><div class="col-md-4">
<div class="card shadow-sm"><div class="card-body">
<h4 class="mb-3">Agent Login</h4>
<?php if ($msg = flash('error')): ?><div class="alert alert-danger"><?= e($msg) ?></div><?php endif; ?>
<form method="post" action="<?= App::url('login') ?>">
  <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
  <div class="mb-2"><label>Email</label><input class="form-control" type="email" name="email" required></div>
  <div class="mb-3"><label>Password</label><input class="form-control" type="password" name="password" required></div>
  <button class="btn btn-primary w-100">Login</button>
</form>
</div></div></div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
