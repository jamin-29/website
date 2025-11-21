<?php
// ===========================================
// HEADER.PHP
// ===========================================

// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Optional: Get logged-in user name
$welcome_name = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest';
?>

<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Planner</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Link to the combined CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="assets/images/logo.png" alt="Wedding Planner Logo" class="logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                 <li><a href="packages.php">Packages</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact_client.php">Contact</a></li>
                <li><a href="book_now.php">Book a Consultation</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="login.php">Login</a></li> 
                <?php else: ?>
                     <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout (<?php echo $welcome_name; ?>)</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
