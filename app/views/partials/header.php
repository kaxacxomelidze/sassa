<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(App::$config['app']['name']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= App::url('public/assets/css/app.css') ?>" rel="stylesheet">
</head><body>
<div class="d-flex">
<?php if (!empty($_SESSION['user'])): ?>
<nav class="sidebar bg-dark text-white p-3">
  <h5><?= e(App::$config['app']['name']) ?></h5><hr>
  <a href="<?= App::url('dashboard') ?>" class="d-block text-white mb-2">Dashboard</a>
  <a href="<?= App::url('conversations') ?>" class="d-block text-white mb-2">Conversations</a>
  <a href="<?= App::url('contacts') ?>" class="d-block text-white mb-2">Contacts</a>
  <a href="<?= App::url('inboxes') ?>" class="d-block text-white mb-2">Inboxes</a>
  <a href="<?= App::url('logout') ?>" class="d-block text-warning">Logout</a>
</nav>
<?php endif; ?>
<main class="flex-fill p-3"><div class="container-fluid">
