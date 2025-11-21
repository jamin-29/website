<?php
session_start();
include('../config/db_connect.php');

if (!isset($_GET['id'])) {
    header("Location: manage_bookings.php");
    exit();
}

$id = intval($_GET['id']);

// Optional confirmation (JS prompt in manage_bookings.php is better)
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $deleteQuery = "DELETE FROM bookings WHERE id = $id";
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: manage_bookings.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting booking: " . mysqli_error($conn);
    }
} else {
    // Redirect to manage page with JS confirmation prompt
    echo "<script>
            if(confirm('Are you sure you want to delete this booking?')) {
                window.location.href='delete_booking.php?id=$id&confirm=yes';
            } else {
                window.location.href='manage_bookings.php';
            }
          </script>";
}
?>
