<?php 
session_start();
include('includes/db_connect.php'); // Database connection

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get and sanitize all input fields, including the new 'full_name'
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // 2. Check if email already exists in the 'users' table
        $check_query = "SELECT * FROM users WHERE email='$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Email is already registered!";
        } else {
            // 3. Hash the password before saving
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Note: Ensure your 'users' table has a 'full_name' column.
            $insert_query = "INSERT INTO users (full_name, email, password) 
                             VALUES ('$full_name', '$email', '$hashed_password')";
            
            if (mysqli_query($conn, $insert_query)) {
                
                // Optional: Auto-login and redirect upon successful registration
                $new_user_id = mysqli_insert_id($conn);
                $_SESSION['user_id'] = $new_user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $full_name;
                
                header('Location: index.php'); // Redirect to home page after registration
                exit();
                
            } else {
                $error = "Database error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="login-container">
    <form method="POST" action="register_client.php" class="login-form">
        <h2><i class="fa-solid fa-user-plus"></i> Register Client Account</h2>

        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></p>
        <?php elseif ($success): ?>
            <p class="success"><i class="fa-solid fa-circle-check"></i> <?php echo $success; ?></p>
        <?php endif; ?>

        <div class="input-group">
            <label><i class="fa-solid fa-user"></i> Full Name</label>
            <input type="text" name="full_name" placeholder="Enter your full name" required value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>">
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-envelope"></i> Email</label>
            <input type="email" name="email" placeholder="Enter your email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-lock"></i> Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm your password" required>
        </div>

        <button type="submit"><i class="fa-solid fa-user-plus"></i> Register</button>

        <p>Already have an account? <a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login here</a></p>
    
    </form>
</div>
</body>
</html>