<?php
include('../includes/db_connect.php');
session_start();
// Add logic to check for admin login

$message_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$success = '';
$error = '';

if ($message_id === 0) {
    die("Invalid message ID.");
}

// 1. ALWAYS DEFINE AND FETCH THE MESSAGE DATA FIRST
// This ensures $fetchQuery and $message are available for the entire script.
$fetchQuery = "SELECT * FROM messages WHERE id = $message_id";
$messageResult = mysqli_query($conn, $fetchQuery);
$message = mysqli_fetch_assoc($messageResult);

if (!$message) {
    die("Message not found."); // Stop execution if no message exists for the ID
}

// Extract necessary details for email (defined now that $message exists)
$client_email = $message['client_email'];
$original_subject = $message['subject'];


// 2. HANDLE REPLY SUBMISSION (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_text'])) {
    
    $reply_text = mysqli_real_escape_string($conn, $_POST['reply_text']);
    $new_status = 'Replied';
    
    // Update Database
    $updateQuery = "UPDATE messages SET reply_text = '$reply_text', status = '$new_status' WHERE id = $message_id";
    
    if (mysqli_query($conn, $updateQuery)) {
        $success = "Reply saved successfully! Status updated to 'Replied'.";
        
        // --- EMAIL SENDING LOGIC STARTS HERE ---
        // (Insert your full email sending code block here using $client_email, $original_subject, $reply_text)
        
        // Example email block (replace with your detailed code):
        $to = $client_email;
        $subject = "RE: " . $original_subject;
        $headers = "From: admin@yourdomain.com";
        $email_body = "Dear " . $message['client_name'] . ",\n\n" . $reply_text;

        if (mail($to, $subject, $email_body, $headers)) {
             $success .= " The client has been successfully notified via email.";
        } else {
             $error .= " **Warning:** The database was updated, but the email failed to send.";
        }
        // --- EMAIL SENDING LOGIC ENDS HERE ---

        // Re-fetch the $message data *after* a successful update/reply
        // to display the newly saved reply_text immediately.
        $messageResult = mysqli_query($conn, $fetchQuery);
        $message = mysqli_fetch_assoc($messageResult);
        
    } else {
        $error = "Error saving reply: " . mysqli_error($conn);
    }
}
// 3. Script continues to HTML output using the defined $message variable.
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reply to <?= htmlspecialchars($message['client_name']); ?> - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="admin-container">

    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-box"></i>
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="manage_booking.php"><i class="fa-solid fa-calendar-check"></i> Manage Bookings</a></li>
            <li><a href="manage_packages.php"><i class="fa-solid fa-box"></i> Manage Packages</a></li>
            <li><a href="manage_services.php"><i class="fa-solid fa-concierge-bell"></i> Manage Services</a></li>
            <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
            <li><a href="manage_gallery.php"><i class="fa-solid fa-image"></i> Manage Gallery</a></li>
            <li><a href="manage_messages.php" class="active"><i class="fa-solid fa-envelope"></i> Manage Messages</a></li>
            <li><a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </aside>
    <main class="dashboard-content">
        <header class="dashboard-header">
            <h2><i class="fa-solid fa-reply"></i> Reply to Message #<?= $message['id']; ?></h2>
        </header>

        <?php if ($success): ?><p class="success-message"><?= $success ?></p><?php endif; ?>
        <?php if ($error): ?><p class="error-message"><?= $error ?></p><?php endif; ?>

        <div class="form-container" style="max-width: 800px; margin-top: 20px;">
            
            <div class="input-group">
                <h3>Conversation Details</h3>
                <p><strong>From:</strong> <?= htmlspecialchars($message['client_name']); ?> (<?= htmlspecialchars($message['client_email']); ?>)</p>
                <p><strong>Subject:</strong> <?= htmlspecialchars($message['subject']); ?></p>
                <p><strong>Status:</strong> <span class="status <?= $message['status']; ?>"><?= htmlspecialchars($message['status']); ?></span></p>
                
                <hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">
                
                <h4 style="margin-bottom: 10px; color: var(--color-primary-dark);">Client's Original Message:</h4>
                <p class="original-message-box" style="white-space: pre-wrap; background-color: #f9f9f9; padding: 15px; border-left: 4px solid var(--color-accent); border-radius: 4px;">
                    <?= htmlspecialchars($message['message_text']); ?>
                </p>
            </div>

            <form method="POST" action="reply_message.php?id=<?= $message_id; ?>">
                <div class="input-group" style="margin-top: 20px;">
                    <label for="reply_text">Your Reply</label>
                    <textarea name="reply_text" rows="10" required><?= htmlspecialchars($message['reply_text'] ?? ''); ?></textarea>
                </div>
                
                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <button type="submit" style="flex-grow: 1;"><i class="fa-solid fa-paper-plane"></i> Send Reply & Update Status</button>
                    <a href="manage_messages.php" class="back-btn" style="flex-grow: 1; text-align: center;"><i class="fa-solid fa-arrow-left"></i> Back to Messages List</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>