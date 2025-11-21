<?php
session_start();
include('includes/db_connect.php'); // Database connection

// === NEW LOGIN GATE ===
// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirects user to your login page
    exit();
}
// ======================

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and escape all input data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $services = mysqli_real_escape_string($conn, $_POST['services']);
    $packages = mysqli_real_escape_string($conn, $_POST['packages']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Optionally, include the user_id in the bookings table
    $user_id = $_SESSION['user_id']; 

    $query = "INSERT INTO bookings (full_name, email, phone, services, packages, event_date, event_location, message)
              VALUES ('$full_name', '$email', '$phone', '$services', '$packages', '$event_date', '$event_location', '$message')";

    // If you add user_id to the bookings table, the query should look like this:
    /*
    $query = "INSERT INTO bookings (user_id, full_name, email, phone, services, packages, event_date, event_location, message)
              VALUES ('$user_id', '$full_name', '$email', '$phone', '$services', '$packages', '$event_date', '$event_location', '$message')";
    */

    if (mysqli_query($conn, $query)) {
        $success = "Your booking has been submitted successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now - Wedding Planner</title>
    <link rel="stylesheet" href="assets/css/booking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="booking-container">
    <form method="POST" action="book_now.php" class="booking-form">
        <h2><i class="fa-solid fa-calendar-check"></i> Book Your Event</h2>

        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></p>
        <?php elseif ($success): ?>
            <p class="success"><i class="fa-solid fa-check-circle"></i> <?php echo $success; ?></p>
        <?php endif; ?>

        <div class="input-group">
            <label><i class="fa-solid fa-user"></i> Full Name</label>
            <input type="text" name="full_name" placeholder="Enter your full name" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-envelope"></i> Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-phone"></i> Phone Number</label>
            <input type="text" name="phone" placeholder="Enter your phone number" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-heart"></i> Services</label>
            <select name="services" required>
                <option value="">Select a service</option>
                <option value="Wedding Planning">Wedding Planning</option>
                <option value="Photography & Videography">Photography & Videography</option>
                <option value="Venue Decoration">Venue Decoration</option>
                <option value="Bridal Styling">Bridal Styling</option>
            </select>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-gift"></i> Package</label>
            <select name="packages" required>
                <option value="">Select a package</option>
                <option value="Silver Package">Silver Package</option>
                <option value="Gold Package">Gold Package</option>
                <option value="Platinum Package">Platinum Package</option>
                <option value="Custom Package">Custom Package</option>
            </select>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-calendar-days"></i> Event Date</label>
            <input type="date" name="event_date" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-location-dot"></i> Event Location</label>
            <input type="text" name="event_location" placeholder="Enter location" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-message"></i> Message / Notes</label>
            <textarea name="message" rows="4" placeholder="Additional details..."></textarea>
        </div>

        <button type="submit"><i class="fa-solid fa-paper-plane"></i> Submit Booking</button>

        <a href="index.php" class="back-home"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>
    </form>
</div>

</body>
</html>