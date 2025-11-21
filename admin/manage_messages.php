<?php
include('../includes/db_connect.php');
session_start();
// Add logic to check for admin login and redirect if necessary

// --- FETCH MESSAGES (Ordered by Open first) ---
$query = "SELECT id, client_name, subject, status, created_at FROM messages ORDER BY status ASC, created_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Client Messages - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="admin-container">
    
    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-box"></i>
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="manage_booking.php"><i class="fa-solid fa-calendar-check"></i> Manage Bookings</a></li>
            <li><a href="manage_packages.php"><i class="fa-solid fa-box"></i> Manage Packages</a></li>
            <li><a href="manage_services.php"><i class="fa-solid fa-concierge-bell"></i> Manage Services</a></li>
            <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
            <li><a href="manage_gallery.php"><i class="fa-solid fa-image"></i> Manage Gallery</a></li>
            <li><a href="manage_messages.php" class="active"><i class="fa-solid fa-envelope"></i> Manage Messages</a></li>
            <li><a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </li>
        </ul>
    </aside>
    <main class="dashboard-content">
        <header class="dashboard-header">
            <h2><i class="fa-solid fa-message"></i> Client Messages</h2>
        </header>

        <section class="table-section">
            <table class="service-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Received On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td><?= htmlspecialchars($row['client_name']); ?></td>
                                <td><?= htmlspecialchars($row['subject']); ?></td>
                                <td><span class="status <?= $row['status']; ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                                <td><?= date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="reply_message.php?id=<?= $row['id']; ?>" class="edit-btn">
                                        <i class="fa-solid fa-reply"></i> Reply/View
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center;">No client messages found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>