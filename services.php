<?php
$pageTitle = 'Wedding Planner - Services';
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
    <section class="services-section">
        <h2>Our Wedding Services</h2>
        <div class="service-grid">
            <div class="service-card">
                <i class="fa-solid fa-calendar-check"></i>
                <h3>Full Wedding Planning</h3>
                <p>Complete event management from concept to execution for a seamless and magical experience.</p>
                <p class="price">₱30,000+</p>
            </div>

            <div class="service-card">
                <i class="fa-solid fa-clock"></i>
                <h3>On-the-Day Coordination</h3>
                <p>Relax and enjoy your special day while we take care of all the logistics and vendor coordination.</p>
                <p class="price">₱15,000+</p>
            </div>

            <div class="service-card">
                <i class="fa-solid fa-gem"></i>
                <h3>Design & Styling</h3>
                <p>Personalized themes, floral arrangements, and venue decorations tailored to your love story.</p>
                <p class="price">₱10,000+</p>
            </div>
        </div>
    </section>


    <?php include 'includes/footer.php'; ?>
</body>

</html>