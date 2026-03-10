<?php
// XAMPP/Apache fallback entrypoint.
// Lets the app run from http://localhost/<project>/ even when mod_rewrite/AllowOverride is not configured.
require __DIR__ . '/public/index.php';
