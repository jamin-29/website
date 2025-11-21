<?php
session_start();
require_once __DIR__ . '/includes/db_connect.php';
require_once __DIR__ . '/includes/auth_session.php';
// ... (Your database connection file, if needed on this page before header) ...

// ===============================================
// === FIX: LOGIN GATE IMPLEMENTATION ===
// Check if the user ID is NOT set in the session.
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect them immediately to the client login page.
    header('Location: login.php');
    exit();
}
// ===============================================

include('includes/header.php'); 

// Check if the user is logged in AND the name is available
$welcome_name = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest';
?> 

<link rel="stylesheet" href="assets/css/styles.css">
<link rel="stylesheet" href="assets/css/packages.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="welcome-section">
    <h1>Welcome, <?php echo $welcome_name; ?>!</h1>
    <p>Your dream wedding starts here. Explore our services, gallery, and book your package today!</p>

    <div class="welcome-info">
        <h2>Why Choose Us?</h2>
        <ul>
            <li>Experienced wedding planners with over 10 years in the industry.</li>
            <li>Customizable packages to suit your needs and budget.</li>
            <li>Highly rated services for photography, catering, and more.</li>
        </ul>
    </div>

    <a href="book_now.php" class="btn-primary">Book Now</a>

    <div class="social-links">
        <a href="#" class="social-icon">Facebook</a>
        <a href="#" class="social-icon">Instagram</a>
        <a href="#" class="social-icon">Pinterest</a>
    </div>

    <div class="newsletter-signup">
        <h3>Stay Updated</h3>
        <p>Subscribe to our newsletter for the latest wedding planning tips and exclusive offers.</p>
        <form action="#" method="POST">
            <input type="email" placeholder="Enter your email" required>
            <button type="submit">Subscribe</button>
        </form>
    </div>
</div>

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

<section class="packages-section">
    <h2>Our Wedding Packages</h2>
    <p class="section-description">Choose from our carefully curated wedding packages that fit your style and budget.</p>

    <div class="package-grid">
        <div class="package-card">
            <i class="fa-solid fa-ring"></i>
            <h3>Silver Package</h3>
            <ul>
                <li>Basic event coordination</li>
                <li>Standard venue setup</li>
                <li>2 hours photography coverage</li>
                <li>Up to 100 guests</li>
            </ul>
            <p class="price">₱25,000</p>
            <a href="book_now.php" class="btn-secondary">Choose Package</a>
        </div>

        <div class="package-card featured">
            <i class="fa-solid fa-crown"></i>
            <h3>Gold Package</h3>
            <ul>
                <li>Full event planning & coordination</li>
                <li>Customized theme & decor</li>
                <li>Photography & video coverage</li>
                <li>Up to 200 guests</li>
            </ul>
            <p class="price">₱50,000</p>
            <a href="book_now.php" class="btn-secondary">Choose Package</a>
        </div>

        <div class="package-card">
            <i class="fa-solid fa-church"></i>
            <h3>Platinum Package</h3>
            <ul>
                <li>Premium full-service wedding planning</li>
                <li>Luxury venue & styling</li>
                <li>Complete photography & videography team</li>
                <li>Unlimited guests</li>
            </ul>
            <p class="price">₱75,000+</p>
            <a href="book_now.php" class="btn-secondary">Choose Package</a>
        </div>
    </div>
</section>

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

<?php include('includes/footer.php'); ?>