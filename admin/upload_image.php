<?php
session_start();
include('../includes/db_connect.php');

$success = '';
$error = '';

// --- CONFIGURATION ---
// __DIR__ is the directory of the current script (admin/)
// dirname(__DIR__) is the parent directory (Wedding_Planner_Website/)
$baseDir = dirname(__DIR__); 
$uploadPath = '/assets/img/gallery/';
$uploadDir = $baseDir . $uploadPath;

// --- STEP 1: Ensure the directory exists ---
// Use realpath for better path resolution if needed, but primarily check existence
if (!is_dir($uploadDir)) {
    // Attempt to create the directory recursively (true) with full permissions (0777)
    if (!mkdir($uploadDir, 0777, true)) {
        $error = "Critical Error: Failed to create the upload directory: " . $uploadDir;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$error) {
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $file = $_FILES['gallery_file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = "File upload failed with error code: " . $file['error'];
    } elseif ($file['size'] == 0) {
        $error = "Please select a file to upload.";
    } else {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            $error = "Only JPG, JPEG, PNG, and WEBP files are allowed.";
        } else {
            // Generate a unique file name
            $newFileName = uniqid('img_', true) . '.' . $fileExtension;
            $destination = $uploadDir . $newFileName; // Use the fixed $uploadDir

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // Insert record into database
                $query = "INSERT INTO gallery (file_name, caption) 
                          VALUES ('$newFileName', '$caption')";
                
                if (mysqli_query($conn, $query)) {
                    $success = "Image uploaded and saved successfully!";
                    $caption = '';
                } else {
                    $error = "Error saving record to database: " . mysqli_error($conn);
                    unlink($destination); 
                }
            } else {
                // Debugging output retained for path confirmation
                $error = "Failed to move uploaded file. Check directory permissions. Target Path: " . $destination;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Image - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard-content">
    <header class="dashboard-header">
        <h2><i class="fa-solid fa-upload"></i> Upload New Image</h2>
    </header>

    <div class="form-container">
        <?php if ($error): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></p>
        <?php elseif ($success): ?>
            <p class="success"><i class="fa-solid fa-check-circle"></i> <?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="upload_image.php" enctype="multipart/form-data">
            
            <div class="input-group">
                <label for="gallery_file"><i class="fa-solid fa-image"></i> Select Image File</label>
                <input type="file" name="gallery_file" id="gallery_file" accept=".jpg, .jpeg, .png, .webp" required>
            </div>

            <div class="input-group">
                <label for="caption"><i class="fa-solid fa-tag"></i> Caption (Optional)</label>
                <input type="text" name="caption" id="caption" placeholder="Short description or event name" value="<?= htmlspecialchars($caption ?? '') ?>">
            </div>

            <button type="submit"><i class="fa-solid fa-upload"></i> Upload Image</button>
            <a href="manage_gallery.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Gallery</a>
        </form>
    </div>
</div>

</body>
</html>