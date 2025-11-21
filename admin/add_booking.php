<?php
include('../includes/db_connect.php');
session_start();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    if(empty($full_name) || empty($event_type) || empty($event_date) || empty($status)) {
        $error = "Please fill all required fields.";
    } else {
        $query = "INSERT INTO bookings (full_name, email, phone, event_type, event_date, event_location, status)
                  VALUES ('$full_name', '$email', '$phone', '$event_type', '$event_date', '$event_location', '$status')";
        if(mysqli_query($conn, $query)) {
            $success = "Booking added successfully!";
        } else {
            $error = "Error: ".mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Booking - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="dashboard-content">
    <header class="dashboard-header">
        <h2><i class="fa-solid fa-plus"></i> Add Booking</h2>
    </header>

    <div class="form-container">
        <?php if($error): ?>
            <p class="error"><?= $error ?></p>
        <?php elseif($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="add_booking.php">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email">
            </div>

            <div class="input-group">
                <label>Phone</label>
                <input type="text" name="phone">
            </div>

            <div class="input-group">
                <label>Event Type</label>
                <input type="text" name="event_type" required>
            </div>

            <div class="input-group">
                <label>Event Date</label>
                <input type="date" name="event_date" required>
            </div>

            <div class="input-group">
                <label>Event Location</label>
                <input type="text" name="event_location">
            </div>

            <div class="input-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="">Select Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <button type="submit"><i class="fa-solid fa-plus"></i> Add Booking</button>
            <a href="manage_booking.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </form>
    </div>
</div>
</body>
</html>
