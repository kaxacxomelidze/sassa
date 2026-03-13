<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="mb-1">System Settings</h3>
    <p class="text-muted mb-0">Control global branding and default behavior.</p>
  </div>
</div>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>

<div class="card border-0 shadow-sm">
  <div class="card-body">
    <form method="post" action="<?= App::url('settings') ?>" class="row g-3">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <div class="col-md-6"><label class="form-label">System Name</label><input class="form-control" name="system_name" value="<?= e($settings['system_name'] ?? '') ?>"></div>
      <div class="col-md-6"><label class="form-label">Logo Path</label><input class="form-control" name="logo_path" value="<?= e($settings['logo_path'] ?? '') ?>"></div>
      <div class="col-md-4"><label class="form-label">Timezone</label><input class="form-control" name="timezone" value="<?= e($settings['timezone'] ?? 'UTC') ?>"></div>
      <div class="col-md-4"><label class="form-label">Default Language</label><input class="form-control" name="default_language" value="<?= e($settings['default_language'] ?? 'en') ?>"></div>
      <div class="col-md-4"><label class="form-label">Theme</label><select class="form-select" name="theme"><option value="light" <?= (($settings['theme'] ?? 'light') === 'light') ? 'selected' : '' ?>>Light</option><option value="dark" <?= (($settings['theme'] ?? '') === 'dark') ? 'selected' : '' ?>>Dark</option></select></div>
      <div class="col-12"><button class="btn btn-primary">Save Settings</button></div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
