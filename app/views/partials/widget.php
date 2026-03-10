<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-3">
<div class="card"><div class="card-body"><h6>Live Chat</h6>
<form method="post" action="<?= App::url('widget/start') ?>">
<input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
<input class="form-control mb-2" name="name" placeholder="Your name" required>
<input class="form-control mb-2" name="email" placeholder="Email">
<textarea class="form-control mb-2" name="message" placeholder="How can we help?" required></textarea>
<button class="btn btn-primary w-100">Start chat</button>
</form></div></div></body></html>
