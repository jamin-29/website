<?php
session_start();
include('../includes/db_connect.php');

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Get raw password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (empty($full_name) || empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $check_query = "SELECT id FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Email address is already registered.";
        } else {
            // Insert user into database
            $query = "INSERT INTO users (full_name, email, password, role) 
                      VALUES ('$full_name', '$email', '$hashed_password', '$role')";
            
            if (mysqli_query($conn, $query)) {
                $success = "User added successfully!";
                // Optionally clear form data after success:
                // $_POST = array();
            } else {
                $error = "Error adding user: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard-content">
    <header class="dashboard-header">
        <h2><i class="fa-solid fa-user-plus"></i> Add New User</h2>
    </header>

    <div class="form-container">
        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></p>
        <?php elseif ($success): ?>
            <p class="success"><i class="fa-solid fa-check-circle"></i> <?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="add_user.php">
            <div class="input-group">
                <label><i class="fa-solid fa-user"></i> Full Name</label>
                <input type="text" name="full_name" placeholder="Enter full name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-envelope"></i> Email</label>
                <input type="email" name="email" placeholder="Enter email address" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" name="password" placeholder="Enter strong password" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-id-badge"></i> Role</label>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="Admin" <?= (($_POST['role'] ?? '') == 'Admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="Client" <?= (($_POST['role'] ?? '') == 'Client') ? 'selected' : '' ?>>Client</option>
                    <option value="Staff" <?= (($_POST['role'] ?? '') == 'Staff') ? 'selected' : '' ?>>Staff</option>
                </select>
            </div>

            <button type="submit"><i class="fa-solid fa-user-plus"></i> Create User</button>
            <a href="manage_users.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to User List</a>
        </form>
    </div>
</div>

</body>
</html>