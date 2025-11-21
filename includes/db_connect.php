<?php
// Set up constants using environment variables for security and portability
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1'); // Tries to use the environment variable, falls back to 127.0.0.1
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'wedding_planner');

// The code that was failing, now using the correct host constant
// NOTE: Line 10 in your original file is likely where the mysqli_connect function starts
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    // Log the error securely and display a user-friendly message
    // Never show the raw error message to the public!
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    die("Database connection failed. Please check back later.");
}
?>