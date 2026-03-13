<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(App::$config['app']['name']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="<?= App::url('public/assets/css/app.css') ?>" rel="stylesheet">
</head>
<body>
<?php $user = $_SESSION['user'] ?? null; ?>
<div class="app-shell d-flex">
<?php if ($user): ?>
<aside class="sidebar bg-dark text-white p-3">
    <div class="brand d-flex align-items-center gap-2 mb-4">
        <span class="brand-mark"><i class="bi bi-chat-heart"></i></span>
        <div>
            <strong class="d-block"><?= e(App::$config['app']['name']) ?></strong>
            <small class="text-white-50">Omnichannel Desk</small>
        </div>
    </div>
    <nav class="nav flex-column nav-pills nav-sassa gap-1">
        <a href="<?= App::url('dashboard') ?>" class="nav-link"><i class="bi bi-grid me-2"></i>Dashboard</a>
        <a href="<?= App::url('conversations') ?>" class="nav-link"><i class="bi bi-chat-dots me-2"></i>Conversations</a>
        <a href="<?= App::url('contacts') ?>" class="nav-link"><i class="bi bi-people me-2"></i>Contacts</a>
        <a href="<?= App::url('inboxes') ?>" class="nav-link"><i class="bi bi-inboxes me-2"></i>Inboxes</a>
        <a href="<?= App::url('integrations') ?>" class="nav-link"><i class="bi bi-plug me-2"></i>Integrations</a>
        <a href="<?= App::url('users') ?>" class="nav-link"><i class="bi bi-person-gear me-2"></i>Users</a>
        <a href="<?= App::url('settings') ?>" class="nav-link"><i class="bi bi-sliders me-2"></i>Settings</a>
    </nav>
    <div class="mt-auto pt-3 border-top border-secondary-subtle">
        <div class="small text-white-50 mb-2"><?= e($user['name']) ?> · <?= e($user['role_name']) ?></div>
        <a href="<?= App::url('logout') ?>" class="btn btn-outline-warning btn-sm w-100"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
    </div>
</aside>
<?php endif; ?>

<div class="content-wrap flex-grow-1">
<?php if ($user): ?>
<header class="topbar bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h5 mb-0">Support Workspace</h1>
        <small class="text-muted">Manage all customer conversations in one place</small>
    </div>
    <span class="badge text-bg-light border"><i class="bi bi-shield-check me-1"></i>Secure Session</span>
</header>
<?php endif; ?>
<main class="p-4">
<div class="container-fluid px-0">
