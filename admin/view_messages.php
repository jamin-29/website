<?php
// Initialize variables
$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
}

// Dummy data for messages (replace with actual database query)
$messages = [
    ['id' => 1, 'sender' => 'John Doe', 'subject' => 'Inquiry about services', 'status' => 'unread'],
    ['id' => 2, 'sender' => 'Jane Smith', 'subject' => 'Wedding date availability', 'status' => 'read'],
    // More messages here...
];

// Handle search functionality
if ($search_term !== '') {
    $messages = array_filter($messages, function($message) use ($search_term) {
        return stripos($message['sender'], $search_term) !== false || stripos($message['subject'], $search_term) !== false;
    });
}

// Pagination logic
$per_page = 5;  // Number of messages per page
$total_messages = count($messages);
$total_pages = ceil($total_messages / $per_page);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;
$messages_to_display = array_slice($messages, $offset, $per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/view_messages.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="manage_services.php"><i class="fas fa-cogs"></i> Manage Services</a></li>
                    <li><a href="manage_gallery.php"><i class="fas fa-images"></i> Manage Gallery</a></li>
                    <li><a href="manage_bookings.php"><i class="fas fa-calendar-check"></i> Manage Bookings</a></li>
                    <li><a href="view_messages.php" class="active"><i class="fas fa-envelope"></i> View Messages</a></li>
                    <li><a href="settings.php"><i class="fas fa-cogs"></i> Settings</a></li>
                    <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
            </header>

            <!-- Page Title -->
            <h1>View Messages</h1>

            <!-- Search Bar -->
            <form method="POST" action="view_messages.php" class="search-form">
                <input type="text" name="search" placeholder="Search for a message" value="<?php echo htmlspecialchars($search_term); ?>" />
                <button type="submit" class="btn-primary">Search</button>
            </form>

            <!-- Messages Table -->
            <table class="messages-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages_to_display as $message): ?>
                        <tr>
                            <td><?php echo $message['id']; ?></td>
                            <td><?php echo htmlspecialchars($message['sender']); ?></td>
                            <td><?php echo htmlspecialchars($message['subject']); ?></td>
                            <td><?php echo $message['status'] === 'read' ? 'Read' : 'Unread'; ?></td>
                            <td>
                                <a href="view_message_details.php?id=<?php echo $message['id']; ?>" class="btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="delete_message.php?id=<?php echo $message['id']; ?>" class="btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                                <?php if ($message['status'] === 'unread'): ?>
                                    <a href="mark_as_read.php?id=<?php echo $message['id']; ?>" class="btn-success">
                                        <i class="fas fa-check"></i> Mark as Read
                                    </a>
                                <?php else: ?>
                                    <a href="mark_as_unread.php?id=<?php echo $message['id']; ?>" class="btn-warning">
                                        <i class="fas fa-times"></i> Mark as Unread
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>" class="btn-primary">Previous</a>
                <?php endif; ?>

                <span class="page-numbers">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="btn-primary <?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </span>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>" class="btn-primary">Next</a>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
