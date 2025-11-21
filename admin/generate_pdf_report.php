<?php
session_start();
include('../config/db_connect.php');

if (!isset($_GET['id'])) {
    header("Location: manage_bookings.php");
    exit();
}

$id = intval($_GET['id']);
$error = '';
$success = '';

// Fetch existing booking
$query = "SELECT * FROM bookings WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: manage_bookings.php");
    exit();
}

$booking = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $updateQuery = "UPDATE bookings 
                    SET full_name='$full_name', event_type='$event_type', date='$date', status='$status' 
                    WHERE id=$id";

    if (mysqli_query($conn, $updateQuery)) {
        $success = "Booking updated successfully!";
        header("Refresh: 1; url=manage_bookings.php");
    } else {
        $error = "Error updating booking: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
</head>
<body>
<h2>Edit Booking</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST" action="">
    <label>Client Name:</label><br>
    <input type="text" name="client_name" value="<?= htmlspecialchars($booking['client_name']) ?>" required><br><br>

    <label>Event Type:</label><br>
    <input type="text" name="event_type" value="<?= htmlspecialchars($booking['event_type']) ?>" required><br><br>

    <label>Date:</label><br>
    <input type="date" name="date" value="<?= htmlspecialchars($booking['date']) ?>" required><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="Pending" <?= $booking['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Confirmed" <?= $booking['status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
        <option value="Completed" <?= $booking['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
        <option value="Cancelled" <?= $booking['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
    </select><br><br>

    <button type="submit">Update Booking</button>
    <a href="manage_bookings.php">Cancel</a>
</form>
</body>
</html>
