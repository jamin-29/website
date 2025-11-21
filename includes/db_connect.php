<?php
// FILE: /var/www/html/includes/db_connect.php

// 1. Define constants by securely reading environment variables
//    DB_HOST must be the internal hostname from your Render database service.
//    (e.g., mysql-your-service.svc.render.com)
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));

// Optional: Define the default port (3306 for MySQL)
define('DB_PORT', getenv('DB_PORT') ?: 3306);

// 2. Attempt the connection
// The stack trace showed your connection attempt used the following format:
// mysqli_connect('127.0.0.1', 'root', Object(SensitiveParameterValue), 'wedding_planner')
// We use the defined constants instead.
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// 3. Check for connection failure
if (!$conn) {
    // Log the error securely and display a user-friendly message
    // Never show the raw error message (like the password or error details) to the public!
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    
    // Check if the host variable is missing to provide a more specific error
    if (!DB_HOST) {
        die("FATAL: Database Host environment variable (DB_HOST) is not set. Please check Render configuration.");
    }
    
    die("Database connection failed. Please check the hostname and firewall rules.");
}

// 4. Set character set (Good practice)
mysqli_set_charset($conn, 'utf8mb4');

?>