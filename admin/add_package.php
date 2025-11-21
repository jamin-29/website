<?php
session_start();
include('../includes/db_connect.php');

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    if (empty($package_name) || empty($price)) {
        $error = "Package name and price are required.";
    } else {
        $query = "INSERT INTO packages (package_name, description, price) VALUES ('$package_name', '$description', '$price')";
        if (mysqli_query($conn, $query)) {
            $success = "Package added successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Package - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard-content">
    <header class="dashboard-header">
        <h2><i class="fa-solid fa-plus"></i> Add New Package</h2>
    </header>

    <div class="form-container">
        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></p>
        <?php elseif ($success): ?>
            <p class="success"><i class="fa-solid fa-check-circle"></i> <?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="add_package.php">
            <div class="input-group">
                <label><i class="fa-solid fa-box"></i> Package Name</label>
                <input type="text" name="package_name" placeholder="Enter package name" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-align-left"></i> Description</label>
                <textarea name="description" placeholder="Enter description (optional)"></textarea>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-money-bill"></i> Price (₱)</label>
                <input type="number" name="price" placeholder="Enter price" step="0.01" required>
            </div>

            <button type="submit"><i class="fa-solid fa-plus"></i> Add Package</button>
            <a href="manage_packages.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Packages</a>
        </form>
    </div>
</div>
</body>
</html>
