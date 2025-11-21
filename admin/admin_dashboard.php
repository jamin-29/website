<?php
session_start();
include('../includes/db_connect.php');

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch Dashboard Data (Placeholder logic)
// You would add SQL queries here to get counts, latest bookings, etc.
// Example: $total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Wedding Planner</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-heart"></i>
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_dashboard.php" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="manage_booking.php"><i class="fa-solid fa-calendar-check"></i> Manage Bookings</a></li>
            <li><a href="manage_packages.php"><i class="fa-solid fa-box"></i> Manage Packages</a></li>
            <li><a href="manage_services.php"><i class="fa-solid fa-concierge-bell"></i> Manage Services</a></li>
            <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
            <li><a href="manage_messages.php"><i class="fa-solid fa-envelope-open-text"></i> Manage Messages</a></li>
            <li><a href="manage_gallery.php"><i class="fa-solid fa-image"></i> Manage Gallery</a></li>
            <li><a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </aside>

    <main class="dashboard-content">
        <header class="dashboard-header">
            <h2><i class="fa-solid fa-gauge"></i> Admin Dashboard</h2>
        </header>

        <div class="dashboard-grid">
            <div class="card">
                <i class="fa-solid fa-calendar-check"></i>
                <h3>Manage Bookings</h3>
                <p>View and manage client bookings.</p>
                <a href="manage_booking.php" class="card-btn">Go</a>
            </div>

            <div class="card">
                <i class="fa-solid fa-box"></i>
                <h3>Manage Packages</h3>
                <p>Add or edit wedding packages.</p>
                <a href="manage_packages.php" class="card-btn">Go</a>
            </div>

            <div class="card">
                <i class="fa-solid fa-concierge-bell"></i>
                <h3>Manage Services</h3>
                <p>Modify available wedding services.</p>
                <a href="manage_services.php" class="card-btn">Go</a>
            </div>

            <div class="card">
                <i class="fa-solid fa-users"></i>
                <h3>Manage Users</h3>
                <p>View and manage registered user accounts.</p>
                <a href="manage_users.php" class="card-btn">Go</a>
            </div>

            <div class="card">
                <i class="fa-solid fa-envelope-open-text"></i>
                <h3>Manage Messages</h3>
                <p>Review and reply to client inquiries.</p>
                <a href="manage_messages.php" class="card-btn">Go</a>
            </div>

            <div class="card">
                <i class="fa-solid fa-image"></i>
                <h3>Manage Gallery</h3>
                <p>Upload and organize event photos.</p>
                <a href="manage_gallery.php" class="card-btn">Go</a>
            </div>
        </div>
    </main>
</div>

</body>
</html>