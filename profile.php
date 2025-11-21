<?php
session_start();
include('includes/db_connect.php');

// Fetch user profile
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<h2>Profile of <?php echo $user['name']; ?></h2>
<p>Email: <?php echo $user['email']; ?></p>
<p>Phone: <?php echo $user['phone']; ?></p>
<a href="update_profile.php">Update Profile</a>
