<!doctype html>
<html>
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f7f9ff}.widget-card{border:0;border-radius:14px;box-shadow:0 12px 25px rgba(13,110,253,.15)}
.widget-head{background:linear-gradient(120deg,#0d6efd,#3a8bff);color:#fff;border-radius:14px 14px 0 0}
</style>
</head>
<body class="p-3">
<div class="card widget-card overflow-hidden">
  <div class="widget-head p-3"><strong>Live Support</strong><div class="small opacity-75">We usually reply in a few minutes</div></div>
  <div class="card-body">
    <form method="post" action="<?= App::url('widget/start') ?>">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <input class="form-control mb-2" name="name" placeholder="Your name" required>
      <input class="form-control mb-2" name="email" placeholder="Email">
      <textarea class="form-control mb-3" name="message" rows="4" placeholder="How can we help?" required></textarea>
      <button class="btn btn-primary w-100">Start chat</button>
    </form>
  </div>
</div>
</body>
</html>
