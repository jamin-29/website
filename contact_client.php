<?php
// ===========================================
// CONTACT_CLIENT.PHP
// ===========================================

// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include('includes/db_connect.php');

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message_text']));

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Please fill out all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $query = "INSERT INTO messages (client_name, client_email, subject, message_text) 
                  VALUES ('$name', '$email', '$subject', '$message')";

        if (mysqli_query($conn, $query)) {
            $success = "Your message has been sent successfully. We will reply soon!";
        } else {
            $error = "Error sending message: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Us - Birthday Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- CSS for Contact Form --- */
        :root {
            --color-primary: #004f99;
            --color-accent: #007bff;
            --color-text-dark: #333;
            --color-border: #d1d5db;
            --color-success: #157347;
            --color-error: #bb2124;
            --border-radius: 8px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: var(--color-text-dark);
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e0e0;
        }

        .form-container h2 {
            text-align: center;
            color: var(--color-primary);
            margin-bottom: 20px;
            font-size: 26px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .input-group label::after {
            content: " *";
            color: var(--color-error);
        }

        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--color-border);
            font-size: 15px;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-group input:focus,
        .input-group textarea:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 5px rgba(0, 79, 153, 0.2);
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: var(--color-primary);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #003366;
        }

        .back-to-home {
            display: block;
            margin-top: 15px;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-weight: 600;
            border-radius: var(--border-radius);
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            transition: all 0.3s;
        }

        .back-to-home:hover {
            background-color: var(--color-primary);
            color: #fff;
        }

        .success {
            background-color: #d4edda;
            color: var(--color-success);
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 15px;
            text-align: center;
            font-weight: 600;
        }

        .error {
            background-color: #f8d7da;
            color: var(--color-error);
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 15px;
            text-align: center;
            font-weight: 600;
        }

        @media (max-width: 540px) {
            .form-container {
                margin: 20px 10px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Send Us a Message</h2>

        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="contact_client.php">
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="input-group">
                <label for="message_text">Message</label>
                <textarea id="message_text" name="message_text" rows="6" required></textarea>
            </div>

            <button type="submit">Send Message</button>
        </form>

        <a href="index.php" class="back-to-home">Back to Home</a>
    </div>

</body>

</html>
