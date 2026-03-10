<?php
require __DIR__ . '/../app/helpers/App.php';
require __DIR__ . '/../app/helpers/functions.php';
require __DIR__ . '/../app/helpers/Router.php';
require __DIR__ . '/../app/middleware/AuthMiddleware.php';
foreach (glob(__DIR__ . '/../app/models/*.php') as $file) require $file;
foreach (glob(__DIR__ . '/../app/controllers/*.php') as $file) require $file;

App::init();
$router = new Router();
require __DIR__ . '/../routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
