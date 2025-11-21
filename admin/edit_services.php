<?php
include('../includes/db_connect.php');
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect back if no ID is provided
    header("Location: manage_services.php");
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT * FROM services WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    // Handle missing or invalid ID
    echo "<script>alert('Service not found.'); window.location.href='manage_services.php';</script>";
    exit();
}

$service = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/add_services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard-content">
    <header class="dashboard-header">
        <h2><i class="fa-solid fa-pen"></i> Edit Service</h2>
    </header>

    <div class="form-container">
        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></p>
        <?php elseif ($success): ?>
            <p class="success"><i class="fa-solid fa-check-circle"></i> <?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="edit_service.php?id=<?= $service_id ?>">
            <div class="input-group">
                <label><i class="fa-solid fa-concierge-bell"></i> Service Name</label>
                <input type="text" name="service_name" value="<?= htmlspecialchars($service['service_name']) ?>" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-align-left"></i> Description</label>
                <textarea name="description"><?= htmlspecialchars($service['description']) ?></textarea>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-money-bill"></i> Price (₱)</label>
                <input type="number" name="price" value="<?= htmlspecialchars($service['price']) ?>" step="0.01" required>
            </div>

            <button type="submit"><i class="fa-solid fa-save"></i> Update Service</button>
            <a href="manage_services.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Services</a>
        </form>
    </div>
</div>

</body>
</html>
