<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Dummy data for notifications (in a real scenario, these would be generated dynamically)
$notifications = [
    ['type' => 'new_booking', 'message' => 'A new booking has been made by John & Jane for June 15, 2025.'],
    ['type' => 'service_update', 'message' => 'The Full Wedding Planning service was updated.']
];

// Function to send email notifications
function sendEmailNotification($subject, $message) {
    $to = "admin@myweddingplanner.com"; // Admin's email address
    $headers = "From: no-reply@myweddingplanner.com\r\n";
    $headers .= "Reply-To: no-reply@myweddingplanner.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    // Send email
    mail($to, $subject, $message, $headers);
}

// Example of sending a notification (you would trigger this when a new booking occurs)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_notification'])) {
    $subject = "New Booking Notification";
    $message = "<p>A new booking has been made by John & Jane for June 15, 2025.</p>";
    sendEmailNotification($subject, $message);
    echo "<p>Notification sent to admin!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email Notification</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Wedding Planner</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="manage_services.php">Manage Services</a></li>
                    <li><a href="manage_bookings.php">Manage Bookings</a></li>
                    <li><a href="generate_report.php">Generate Report</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Email Notification</h1>

            <!-- Send email button -->
            <form action="notifications.php" method="POST">
                <button type="submit" name="send_notification" class="btn-primary">Send New Booking Notification</button>
            </form>

            <h2>Recent Notifications</h2>
            <div class="notifications">
                <ul>
                    <?php foreach ($notifications as $notification): ?>
                        <li class="<?php echo $notification['type']; ?>"><?php echo $notification['message']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>
