<?php
include('../includes/db_connect.php');
session_start();

// DELETE PACKAGE IF 'delete' PARAM IS SET
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM packages WHERE id = $delete_id";
    mysqli_query($conn, $deleteQuery);
    header("Location: manage_packages.php");
    exit();
}

// PAGINATION
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// COUNT TOTAL PACKAGES
$countQuery = "SELECT COUNT(*) AS total FROM packages";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);

// FETCH PACKAGES
$query = "SELECT * FROM packages ORDER BY package_name ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Packages - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_package.css">
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
                <li><a href="manage_packages.php" class="active"><i class="fa-solid fa-box"></i> Manage Packages</a>
                </li>
                <li><a href="manage_services.php"><i class="fa-solid fa-concierge-bell"></i> Manage Services</a></li>
                <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
                <li><a href="manage_messages.php"><i class="fa-solid fa-envelope-open-text"></i> Manage Messages</a></li>
                <li><a href="manage_gallery.php"><i class="fa-solid fa-image"></i> Manage Gallery</a></li>
                <li><a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <header class="dashboard-header">
                <h2><i class="fa-solid fa-box"></i> Manage Packages</h2>
                <a href="add_package.php" class="add-btn"><i class="fa-solid fa-plus"></i> Add Package</a>
            </header>

            <section class="table-section">
                <table class="service-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Package Name</th>
                            <th>Description</th>
                            <th>Price (₱)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']); ?></td>
                                    <td><?= htmlspecialchars($row['package_name']); ?></td>
                                    <td><?= htmlspecialchars($row['description']); ?></td>
                                    <td><?= number_format($row['price'], 2); ?></td>
                                    <td class="actions">
                                        <a href="edit_package.php?id=<?= $row['id']; ?>" class="edit-btn"><i
                                                class="fa-solid fa-pen"></i></a>
                                        <a href="manage_packages.php?delete=<?= $row['id']; ?>" class="delete-btn"
                                            onclick="return confirm('Are you sure you want to delete this package?');"><i
                                                class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center; color:#777;">No packages found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <!-- PAGINATION -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

        </main>
    </div>
</body>

</html>