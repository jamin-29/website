<?php
include('../includes/db_connect.php');
session_start();

// --- IMAGE UPLOAD DIRECTORY ---
$uploadDir = '../assets/img/gallery/';

// --- DELETE IMAGE ---
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    // 1. Fetch the file name from the database
    $fileNameQuery = "SELECT file_name FROM gallery WHERE id = $delete_id";
    $fileNameResult = mysqli_query($conn, $fileNameQuery);
    
    if ($fileNameResult && mysqli_num_rows($fileNameResult) > 0) {
        $row = mysqli_fetch_assoc($fileNameResult);
        $fileName = $row['file_name'];
        $filePath = $uploadDir . $fileName;

        // 2. Delete file from the server
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // 3. Delete record from the database
        $deleteQuery = "DELETE FROM gallery WHERE id = $delete_id";
        mysqli_query($conn, $deleteQuery);
    }
    
    // Redirect to avoid resubmission
    header("Location: manage_gallery.php");
    exit();
}

// --- FETCH ALL GALLERY IMAGES ---
$query = "SELECT * FROM gallery ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Gallery - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-camera"></i>
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="manage_booking.php"><i class="fa-solid fa-calendar-check"></i> Manage Bookings</a></li>
            <li><a href="manage_packages.php"><i class="fa-solid fa-box"></i> Manage Packages</a></li>
            <li><a href="manage_services.php"><i class="fa-solid fa-concierge-bell"></i> Manage Services</a></li>
            <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
            <li><a href="manage_gallery.php" class="active"><i class="fa-solid fa-image"></i> Manage Gallery</a></li>
            <li><a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </aside>

    <main class="dashboard-content">
        <header class="dashboard-header">
            <h2><i class="fa-solid fa-image"></i> Manage Gallery</h2>
            <a href="upload_image.php" class="add-btn"><i class="fa-solid fa-upload"></i> Upload Image</a>
        </header>
        
        <div class="gallery-grid">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="gallery-item">
                        <img src="<?= htmlspecialchars($uploadDir . $row['file_name']); ?>" 
                             alt="<?= htmlspecialchars($row['caption']); ?>">
                        <div class="gallery-info">
                            <p class="caption"><?= htmlspecialchars($row['caption']); ?></p>
                            <a href="manage_gallery.php?delete=<?= $row['id']; ?>" class="delete-btn" 
                               onclick="return confirm('Are you sure you want to delete this image?');">
                                <i class="fa-solid fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-images-message">No images found in the gallery. Use the 'Upload Image' button to add photos.</p>
            <?php endif; ?>
        </div>

    </main>
</div>

</body>
</html>