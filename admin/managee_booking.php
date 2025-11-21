<?php
include('../includes/db_connect.php');
session_start();

// Handle search/filter input
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Pagination setup
$limit = 10; // bookings per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total bookings
$countQuery = "SELECT COUNT(*) AS total FROM bookings 
               WHERE full_name LIKE '%$search%' 
                  OR event_type LIKE '%$search%' 
                  OR status LIKE '%$search%'";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch bookings for current page
$query = "SELECT * FROM bookings 
          WHERE full_name LIKE '%$search%' 
             OR event_type LIKE '%$search%' 
             OR status LIKE '%$search%' 
          ORDER BY event_date DESC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings - Wedding Planner Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/manage_booking.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-logo">
        <i class="fa-solid fa-gem"></i>
        <h2>Admin Panel</h2>
    </div>
    <ul class="sidebar-menu">
        <li><a href="admin_dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
        <li><a href="managee_booking.php" class="active"><i class="fa-solid fa-calendar-check"></i> Manage Bookings</a></li>
        <li><a href="manage_packages.php"><i class="fa-solid fa-box"></i> Manage Packages</a></li>
        <li><a href="manage_services.php"><i class="fa-solid fa-concierge-bell"></i> Manage Services</a></li>
        <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
        <li><a href="gallery.php"><i class="fa-solid fa-image"></i> Gallery</a></li>
    </ul>
    <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="dashboard-content">
    <div class="dashboard-header">
        <h2><i class="fa-solid fa-calendar-check"></i> Manage Bookings</h2>
    </div>

    <!-- SEARCH BAR -->
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search by Name, Event Type, or Status..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
        <?php if($search): ?>
            <a href="managee_booking.php" class="clear-btn">Clear</a>
        <?php endif; ?>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Event Type</th>
                    <th>Event Date</th>
                    <th>Event Location</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td data-label="ID"><?= $row['id'] ?></td>
                        <td data-label="Full Name"><?= htmlspecialchars($row['full_name']) ?></td>
                        <td data-label="Event Type"><?= htmlspecialchars($row['event_type']) ?></td>
                        <td data-label="Event Date"><?= htmlspecialchars($row['event_date']) ?></td>
                        <td data-label="Event Location"><?= htmlspecialchars($row['event_location']) ?></td>
                        <td data-label="Phone"><?= htmlspecialchars($row['phone']) ?></td>
                        <td data-label="Status"><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                        <td data-label="Actions" class="action-btns">
                            <a href="edit_booking.php?id=<?= $row['id'] ?>" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <a href="delete_booking.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this booking?')"><i class="fa-solid fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center; color:#777;">No bookings found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <?php if($totalPages > 1): ?>
        <div class="pagination">
            <?php for($i=1; $i<=$totalPages; $i++): ?>
                <a href="?page=<?= $i ?><?= $search ? '&search='.urlencode($search) : '' ?>" class="<?= $i==$page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
