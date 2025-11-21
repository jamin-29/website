<?php
$pageTitle = 'Wedding Planner - About Us';
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
  <section class="about-section">
    <img src="assets/images/about.jpg" alt="Wedding Planner Team">
    <div class="about-text">
      <i class="fa-solid fa-heart about-icon"></i>
      <h2>About Our Wedding Planner</h2>
      <p>We are a <span class="highlight">dedicated team</span> of wedding professionals passionate about crafting
        unforgettable celebrations of love.</p>
      <p>From intimate gatherings to grand weddings, we handle every detail with care and creativity.</p>
      <a href="services.php" class="btn-primary">Explore Services</a>
    </div>
  </section>

</body>
<?php include 'includes/footer.php'; ?>

</html>