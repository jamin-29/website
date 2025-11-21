<?php
// includes/config.php
// Update these values before deploying
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'wedding_planner');

// Optionally set site name, email
define('SITE_NAME', 'Wedding Planner');
define('ADMIN_EMAIL', 'admin@example.com');
