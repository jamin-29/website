<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update user profile in database
    $query = "UPDATE users SET name = ?, email = ?, phone = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    $stmt->execute();

    echo "Profile updated successfully!";
}
?>

<form method="POST">
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name" value=""><br>
    
    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" value=""><br>
    
    <label for="phone">Phone:</label><br>
    <input type="text" name="phone" id="phone" value=""><br>
    
    <input type="submit" value="Update Profile">
</form>
