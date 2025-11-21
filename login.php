<?php
session_start();
include('includes/db_connect.php'); // Your database connection file

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 1. Query the database for the user's email
    $query = "SELECT id, email, password, full_name FROM users WHERE email='$email'"; 
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // 2. Verify the hashed password
        if (password_verify($password, $row['password'])) {
            // Success: Set session variables and redirect
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['full_name']; // Used for the "Welcome, Name" message
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password."; 
        }
    } else {
        $error = "Account not found. Please register.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="login-container">
    <form method="POST" action="login.php" class="login-form">
        <h2><i class="fa-solid fa-right-to-bracket"></i> Client Login</h2>

        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></p>
        <?php endif; ?>

        <div class="input-group">
            <label><i class="fa-solid fa-envelope"></i> Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="remember-forgot">
            <label><input type="checkbox" name="remember"> Remember Me</label>
            <a href="forgot_password.php">Forgot Password?</a>
        </div>

        <button type="submit"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</button>

        <p>Don't have an account? <a href="register_client.php"><i class="fa-solid fa-user-plus"></i> Register here</a></p>

        <a href="admin/admin_login.php" class="btn-floating-book"><i class="fa-solid fa-user-shield"></i> Go to Admin Login</a>
    </form>
</div>

</body>
</html>