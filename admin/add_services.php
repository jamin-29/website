<?php
session_start();
include('../includes/db_connect.php');

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    if (empty($service_name) || empty($price)) {
        $error = "Service name and price are required.";
    } else {
        $query = "INSERT INTO services (service_name, description, price) 
                  VALUES ('$service_name', '$description', '$price')";
        if (mysqli_query($conn, $query)) {
            $success = "Service added successfully!";
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
    <title>Add Service - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/add_services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard-content">
    <header class="dashboard-header">
        <h2><i class="fa-solid fa-plus"></i> Add New Service</h2>
    </header>

    <div class="form-container">
        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></p>
        <?php elseif ($success): ?>
            <p class="success"><i class="fa-solid fa-check-circle"></i> <?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="add_services.php">
            <div class="input-group">
                <label><i class="fa-solid fa-concierge-bell"></i> Service Name</label>
                <input type="text" name="service_name" placeholder="Enter service name" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-align-left"></i> Description</label>
                <textarea name="description" placeholder="Enter description (optional)"></textarea>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-money-bill"></i> Price (₱)</label>
                <input type="number" name="price" placeholder="Enter price" step="0.01" required>
            </div>

            <button type="submit"><i class="fa-solid fa-plus"></i> Add Service</button>
            <a href="manage_services.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Services</a>
        </form>
    </div>
</div>

</body>
</html>
