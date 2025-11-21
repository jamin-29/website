<?php
session_start();

// Include the database connection file
include 'includes/db_connect.php';  // Ensure the path is correct

// Initialize error message and success message
$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate user inputs
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if ($stmt === false) {
            $error_message = "Error preparing SQL query: " . $conn->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error_message = "Email already exists. Please use a different email.";
            } else {
                // Insert new user into the database
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                
                // Check if the query preparation was successful
                if ($stmt === false) {
                    $error_message = "Error preparing SQL query: " . $conn->error;
                } else {
                    $stmt->bind_param("sss", $username, $email, $hashed_password);
                    if ($stmt->execute()) {
                        $success_message = "Account created successfully. You can now log in.";
                    } else {
                        $error_message = "There was an error creating your account. Please try again.";
                    }
                }
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Create an Account</h2>

        <!-- Success or Error Message -->
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php elseif ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Sign Up Form -->
        <form action="signup.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>

            <button type="submit" class="login-btn">Sign Up</button>

            <p class="login-link">Already have an account? <a href="login.php">Log in here</a>.</p>
        </form>
    </div>
</body>
</html>
