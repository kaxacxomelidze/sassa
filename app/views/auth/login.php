<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="row justify-content-center align-items-center min-vh-100 g-0">
  <div class="col-lg-9">
    <div class="card border-0 shadow-lg overflow-hidden">
      <div class="row g-0">
        <div class="col-md-6 login-panel p-5 text-white d-flex flex-column justify-content-center">
          <h2 class="fw-bold mb-3">Welcome to <?= e(App::$config['app']['name']) ?></h2>
          <p class="mb-4 opacity-75">A modern omnichannel support workspace for Admins, Supervisors, and Agents.</p>
          <ul class="list-unstyled small opacity-75 mb-0">
            <li class="mb-2"><i class="bi bi-check2-circle me-2"></i>Unified inbox for all channels</li>
            <li class="mb-2"><i class="bi bi-check2-circle me-2"></i>Fast team collaboration</li>
            <li><i class="bi bi-check2-circle me-2"></i>Secure role-based access</li>
          </ul>
        </div>
        <div class="col-md-6 p-5 bg-white">
          <h4 class="mb-3">Agent Login</h4>
          <p class="text-muted small">Sign in to continue.</p>
          <?php if ($msg = flash('error')): ?><div class="alert alert-danger"><?= e($msg) ?></div><?php endif; ?>
          <form method="post" action="<?= App::url('login') ?>" class="mt-3">
            <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
            <div class="mb-3"><label class="form-label">Email</label><input class="form-control form-control-lg" type="email" name="email" required></div>
            <div class="mb-4"><label class="form-label">Password</label><input class="form-control form-control-lg" type="password" name="password" required></div>
            <button class="btn btn-primary btn-lg w-100">Login</button>
            <div class="text-muted small mt-3">Demo: <strong>admin@sassa.local / password123</strong></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
