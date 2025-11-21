<?php
session_start();
include '../includes/db_connect.php'; // Adjust path if necessary

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    
    // Update the booking status to 'Rejected'
    try {
        $sql = "UPDATE bookings SET status = 'Rejected' WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $booking_id]);
        
        header("Location: manage_bookings.php"); // Redirect to Manage Bookings page
        exit();
    } catch (PDOException $e) {
        die("Error updating booking: " . $e->getMessage());
    }
} else {
    echo "Booking ID is missing.";
}
?>
