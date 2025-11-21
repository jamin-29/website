<?php
include('../includes/db_connect.php');
session_start();

$success = '';
$error = '';

if(!isset($_GET['id'])) {
    header("Location: manage_bookings.php");
    exit();
}

$booking_id = intval($_GET['id']);
$query = "SELECT * FROM bookings WHERE id=$booking_id LIMIT 1";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)==0) {
    header("Location: manage_bookings.php");
    exit();
}
$booking = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']=='POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $update = "UPDATE bookings SET 
               full_name='$full_name', email='$email', phone='$phone',
               event_type='$event_type', event_date='$event_date',
               event_location='$event_location', status='$status'
               WHERE id=$booking_id";

    if(mysqli_query($conn, $update)) {
        $success = "Booking updated successfully!";
        $booking = array_merge($booking, $_POST);
    } else {
        $error = "Error: ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="dashboard-content">
    <header class="dashboard-header">
        <h2><i class="fa-solid fa-pen"></i> Edit Booking</h2>
    </header>

    <div class="form-container">
        <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        <?php if($success): ?><p class="success"><?= $success ?></p><?php endif; ?>

        <form method="POST" action="edit_booking.php?id=<?= $booking_id ?>">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($booking['full_name']) ?>" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($booking['email']) ?>">
            </div>
            <div class="input-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($booking['phone']) ?>">
            </div>
            <div class="input-group">
                <label>Event Type</label>
                <input type="text" name="event_type" value="<?= htmlspecialchars($booking['event_type']) ?>" required>
            </div>
            <div class="input-group">
                <label>Event Date</label>
                <input type="date" name="event_date" value="<?= htmlspecialchars($booking['event_date']) ?>" required>
            </div>
            <div class="input-group">
                <label>Event Location</label>
                <input type="text" name="event_location" value="<?= htmlspecialchars($booking['event_location']) ?>">
            </div>
            <div class="input-group">
                <label>Status</label>
                <select name="status" required>
                    <?php
                    $statuses = ['Pending','Confirmed','Completed','Cancelled'];
                    foreach($statuses as $s) {
                        $selected = $booking['status']==$s ? 'selected' : '';
                        echo "<option value='$s' $selected>$s</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit"><i class="fa-solid fa-save"></i> Update Booking</button>
            <a href="manage_bookings.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </form>
    </div>
</div>
</body>
</html>
