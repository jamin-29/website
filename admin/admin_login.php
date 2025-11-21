<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dummy admin credentials (replace with DB logic for production)
    $username = "admin";
    $password = "123";

    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    if ($input_username == $username && $input_password == $password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php"); 
        exit();
    } else {
        $error_message = "Invalid credentials. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/admin_login.css">

    <!-- ✅ Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <section class="content">
        <h1><i class="fa-solid fa-user-shield"></i> Admin Login</h1>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="admin_login.php" method="POST">
            <label for="username"><i class="fa-solid fa-user"></i> Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
        </form>

        <!-- Navigation Links -->
        <a href="../index.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back to Landing Page</a>
        <a href="../login.php" class="btn-floating-book"><i class="fa-solid fa-key"></i> Go to User Login</a>
    </section>
</body>
</html>
