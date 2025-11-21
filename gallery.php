<?php
$pageTitle = 'Wedding Planner - Gallery';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <section class="gallery-section">
    <h2>Wedding Moments</h2>
    <div class="gallery-container">
      <div class="gallery-item">
        <img src="assets/images/gallery1.jpg" alt="Beach Wedding">
        <div class="caption"><i class="fa-solid fa-camera"></i> Beach Wedding</div>
      </div>
      <div class="gallery-item">
        <img src="assets/images/gallery2.jpg" alt="Garden Ceremony">
        <div class="caption"><i class="fa-solid fa-leaf"></i> Garden Ceremony</div>
      </div>
      <div class="gallery-item">
        <img src="assets/images/gallery3.jpg" alt="Classic Indoor Venue">
        <div class="caption"><i class="fa-solid fa-champagne-glasses"></i> Classic Indoor Venue</div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>
</body>

</html>