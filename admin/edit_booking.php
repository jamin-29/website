<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the booking details from the database
    // Example: Assuming you have a bookings table
    // $sql = "SELECT * FROM bookings WHERE id = ?";
    // Fetch the booking details and fill the form

    $booking = [
        'couple_name' => 'John & Jane',
        'email' => 'john.jane@example.com',
        'wedding_date' => '2025-06-15',
        'status' => 'Pending',
        'service' => 'Full Wedding Planning'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
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
            <h1>Edit Booking</h1>

            <form action="edit_booking.php?id=<?php echo $id; ?>" method="POST" class="booking-form">
                <label for="couple_name">Couple Name</label>
                <input type="text" id="couple_name" name="couple_name" value="<?php echo $booking['couple_name']; ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $booking['email']; ?>" required>

                <label for="wedding_date">Wedding Date</label>
                <input type="date" id="wedding_date" name="wedding_date" value="<?php echo $booking['wedding_date']; ?>" required>

                <label for="service">Service</label>
                <select id="service" name="service" required>
                    <option value="Full Wedding Planning" <?php echo ($booking['service'] == 'Full Wedding Planning') ? 'selected' : ''; ?>>Full Wedding Planning</option>
                    <option value="Catering Services" <?php echo ($booking['service'] == 'Catering Services') ? 'selected' : ''; ?>>Catering Services</option>
                    <option value="Month-of Coordination" <?php echo ($booking['service'] == 'Month-of Coordination') ? 'selected' : ''; ?>>Month-of Coordination</option>
                </select>

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Pending" <?php echo ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Confirmed" <?php echo ($booking['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="Cancelled" <?php echo ($booking['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>

                <button type="submit" class="btn-primary">Update Booking</button>
            </form>
        </main>
    </div>
</body>
</html>
