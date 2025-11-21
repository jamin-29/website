<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php"); // Redirect if not logged in
    exit();
}

// Dummy data for bookings (Replace with actual database query)
$bookings = [
    ['id' => 1, 'name' => 'John & Jane', 'date' => '2025-06-15', 'status' => 'Pending'],
    ['id' => 2, 'name' => 'Alex & Mary', 'date' => '2025-07-20', 'status' => 'Confirmed']
];

// CSV generation (For simplicity, let's generate a CSV)
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="bookings_report.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Booking ID', 'Couple Name', 'Wedding Date', 'Status']); // Column headers

foreach ($bookings as $booking) {
    fputcsv($output, $booking); // Add each booking as a row
}

fclose($output);
exit();
