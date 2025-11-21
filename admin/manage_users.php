<?php
include('../includes/db_connect.php');
session_start();

// --- SECURITY AND AUTHENTICATION ---
// Assume a session variable 'is_admin' is set upon successful admin login.
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // header("Location: login.php"); // Redirect unauthorized users
    // exit();
}

// --- DELETE USER ---
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    // IMPORTANT: Prevent deleting the currently logged-in admin user (if applicable)
    // if ($delete_id == $_SESSION['user_id']) {
    //     // Optionally set error message: $error = "Cannot delete your own account.";
    // } else {
        mysqli_query($conn, "DELETE FROM users WHERE id = $delete_id");
    // }
    header("Location: manage_users.php");
    exit();
}

// --- PAGINATION SETUP ---
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// --- COUNT TOTAL USERS ---
$countQuery = "SELECT COUNT(*) AS total FROM users";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);

// --- FETCH USERS ---
$query = "SELECT id, full_name, email, created_at, role FROM users ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
if (!$result) die("Database query failed: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-users-cog"></i>
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="manage_booking.php"><i class="fa-solid fa-calendar-check"></i> Manage Bookings</a></li>
            <li><a href="manage_packages.php"><i class="fa-solid fa-box"></i> Manage Packages</a></li>
            <li><a href="manage_services.php"><i class="fa-solid fa-concierge-bell"></i> Manage Services</a></li>
            <li><a href="manage_users.php" class="active"><i class="fa-solid fa-users"></i> Manage Users</a></li>
             <li><a href="manage_messages.php"><i class="fa-solid fa-envelope-open-text"></i> Manage Messages</a></li>
            <li><a href="manage_gallery.php"><i class="fa-solid fa-image"></i> Manage Gallery</a></li>
            <li><a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </aside>

    <main class="dashboard-content">
        <header class="dashboard-header">
            <h2><i class="fa-solid fa-users"></i> Manage Users</h2>
            <a href="add_user.php" class="add-btn"><i class="fa-solid fa-user-plus"></i> Add New User</a>
        </header>

        <section class="table-section">
            <table class="service-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td><?= htmlspecialchars($row['full_name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><span class="role <?= strtolower($row['role']) ?>"><?= htmlspecialchars($row['role']); ?></span></td>
                                <td><?= date('Y-m-d', strtotime($row['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="edit_user.php?id=<?= $row['id']; ?>" class="edit-btn"><i class="fa-solid fa-pen"></i></a>
                                    <a href="manage_users.php?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete user <?= $row['full_name'] ?>?');"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center; color:#777;">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <?php if($totalPages > 1): ?>
            <div class="pagination">
                <?php for($i=1; $i<=$totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= $i==$page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </main>
</div>

</body>
</html>