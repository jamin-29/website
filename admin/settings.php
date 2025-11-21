<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

/* ---- Demo: read current settings (replace with DB fetch) ---- */
$current = [
    'site_name'    => 'Mylene & My’s Wedding Planner',
    'tagline'      => 'Your perfect day, perfectly planned.',
    'logo'         => '../assets/img/logo.png',
    'admin_name'   => 'Admin',
    'admin_email'  => 'admin@example.com',
    'avatar'       => '../assets/img/avatar.png',
    'notify_inbox' => true,
    'notify_booking' => true,
    'notify_daily_summary' => false,
    'theme'        => 'light',
    'smtp_host'    => 'smtp.example.com',
    'smtp_port'    => '587',
    'smtp_user'    => 'no-reply@example.com',
    'smtp_encryption' => 'tls'
];

/* ---- Handle POST (replace with DB update + file handling) ---- */
$flash = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF would go here
    // Save posted fields (you’ll persist to DB)
    $current['site_name']   = $_POST['site_name'] ?? $current['site_name'];
    $current['tagline']     = $_POST['tagline'] ?? $current['tagline'];
    $current['admin_name']  = $_POST['admin_name'] ?? $current['admin_name'];
    $current['admin_email'] = $_POST['admin_email'] ?? $current['admin_email'];
    $current['notify_inbox'] = isset($_POST['notify_inbox']);
    $current['notify_booking'] = isset($_POST['notify_booking']);
    $current['notify_daily_summary'] = isset($_POST['notify_daily_summary']);
    $current['theme'] = $_POST['theme'] ?? $current['theme'];

    $current['smtp_host'] = $_POST['smtp_host'] ?? $current['smtp_host'];
    $current['smtp_port'] = $_POST['smtp_port'] ?? $current['smtp_port'];
    $current['smtp_user'] = $_POST['smtp_user'] ?? $current['smtp_user'];
    $current['smtp_pass'] = $_POST['smtp_pass'] ?? ''; // don’t echo back
    $current['smtp_encryption'] = $_POST['smtp_encryption'] ?? $current['smtp_encryption'];

    // TODO: handle file uploads for logo/avatar securely (MIME checks, move_uploaded_file)
    // if (!empty($_FILES['logo']['name'])) { ... } 
    // if (!empty($_FILES['avatar']['name'])) { ... }

    $flash = 'Settings saved successfully.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Settings • Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="../assets/css/settings.css"/>
</head>
<body>
<div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header"><h2>Admin Panel</h2></div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="admin_dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="manage_services.php"><i class="fa-solid fa-briefcase"></i> Manage Services</a></li>
                <li><a href="manage_gallery.php"><i class="fa-solid fa-images"></i> Manage Gallery</a></li>
                <li><a href="manage_bookings.php"><i class="fa-solid fa-calendar-check"></i> Manage Bookings</a></li>
                <li><a href="view_messages.php"><i class="fa-solid fa-envelope"></i> View Messages</a></li>
                <li><a class="active" href="settings.php"><i class="fa-solid fa-gear"></i> Settings</a></li>
                <li><a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main -->
    <main class="main-content">
        <header class="top-bar">
            <div class="brand-title"><?= htmlspecialchars($current['site_name']) ?></div>
            <div class="user-info">Welcome, <?= htmlspecialchars($current['admin_name']) ?></div>
        </header>

        <h1>Settings</h1>
        <?php if ($flash): ?>
            <div class="flash success"><i class="fa-regular fa-circle-check"></i> <?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-btn active" data-tab="general"><i class="fa-solid fa-building"></i> General</button>
            <button class="tab-btn" data-tab="profile"><i class="fa-solid fa-user"></i> Profile</button>
            <button class="tab-btn" data-tab="security"><i class="fa-solid fa-shield-halved"></i> Security</button>
            <button class="tab-btn" data-tab="notifications"><i class="fa-solid fa-bell"></i> Notifications</button>
            <button class="tab-btn" data-tab="smtp"><i class="fa-solid fa-envelope-circle-check"></i> Email/SMTP</button>
            <button class="tab-btn" data-tab="theme"><i class="fa-solid fa-circle-half-stroke"></i> Theme</button>
        </div>

        <form method="POST" enctype="multipart/form-data" class="cards">
            <!-- GENERAL -->
            <section id="general" class="tab-panel active">
                <div class="card">
                    <h3><i class="fa-solid fa-building"></i> Site Info</h3>
                    <div class="grid-2">
                        <label>Site Name
                            <input type="text" name="site_name" value="<?= htmlspecialchars($current['site_name']) ?>" required>
                        </label>
                        <label>Tagline
                            <input type="text" name="tagline" value="<?= htmlspecialchars($current['tagline']) ?>">
                        </label>
                    </div>
                    <div class="grid-2 align-center">
                        <label class="file-label">Logo
                            <input type="file" name="logo" accept="image/*" id="logoInput">
                        </label>
                        <div class="preview">
                            <img id="logoPreview" src="<?= htmlspecialchars($current['logo']) ?>" alt="Logo Preview">
                        </div>
                    </div>
                </div>
            </section>

            <!-- PROFILE -->
            <section id="profile" class="tab-panel">
                <div class="card">
                    <h3><i class="fa-solid fa-user"></i> Admin Profile</h3>
                    <div class="grid-2">
                        <label>Display Name
                            <input type="text" name="admin_name" value="<?= htmlspecialchars($current['admin_name']) ?>" required>
                        </label>
                        <label>Email
                            <input type="email" name="admin_email" value="<?= htmlspecialchars($current['admin_email']) ?>" required>
                        </label>
                    </div>
                    <div class="grid-2 align-center">
                        <label class="file-label">Avatar
                            <input type="file" name="avatar" accept="image/*" id="avatarInput">
                        </label>
                        <div class="preview">
                            <img id="avatarPreview" src="<?= htmlspecialchars($current['avatar']) ?>" alt="Avatar Preview">
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECURITY -->
            <section id="security" class="tab-panel">
                <div class="card">
                    <h3><i class="fa-solid fa-shield-halved"></i> Change Password</h3>
                    <div class="grid-3">
                        <label>Current Password
                            <input type="password" name="current_password" autocomplete="current-password">
                        </label>
                        <label>New Password
                            <input type="password" name="new_password" autocomplete="new-password">
                        </label>
                        <label>Confirm New Password
                            <input type="password" name="confirm_password" autocomplete="new-password">
                        </label>
                    </div>
                    <p class="hint"><i class="fa-regular fa-lightbulb"></i> Use 8+ chars, mix of letters, numbers, and symbols.</p>
                </div>
            </section>

            <!-- NOTIFICATIONS -->
            <section id="notifications" class="tab-panel">
                <div class="card">
                    <h3><i class="fa-solid fa-bell"></i> Notifications</h3>
                    <div class="switch-row">
                        <span>New contact messages</span>
                        <label class="switch">
                            <input type="checkbox" name="notify_inbox" <?= $current['notify_inbox'] ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="switch-row">
                        <span>New/updated bookings</span>
                        <label class="switch">
                            <input type="checkbox" name="notify_booking" <?= $current['notify_booking'] ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="switch-row">
                        <span>Daily email summary</span>
                        <label class="switch">
                            <input type="checkbox" name="notify_daily_summary" <?= $current['notify_daily_summary'] ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- SMTP -->
            <section id="smtp" class="tab-panel">
                <div class="card">
                    <h3><i class="fa-solid fa-envelope-circle-check"></i> Email / SMTP</h3>
                    <div class="grid-3">
                        <label>SMTP Host
                            <input type="text" name="smtp_host" value="<?= htmlspecialchars($current['smtp_host']) ?>">
                        </label>
                        <label>Port
                            <input type="number" name="smtp_port" value="<?= htmlspecialchars($current['smtp_port']) ?>">
                        </label>
                        <label>Encryption
                            <select name="smtp_encryption">
                                <option value="tls" <?= $current['smtp_encryption']==='tls'?'selected':''; ?>>TLS</option>
                                <option value="ssl" <?= $current['smtp_encryption']==='ssl'?'selected':''; ?>>SSL</option>
                                <option value="none" <?= $current['smtp_encryption']==='none'?'selected':''; ?>>None</option>
                            </select>
                        </label>
                    </div>
                    <div class="grid-2">
                        <label>Username
                            <input type="text" name="smtp_user" value="<?= htmlspecialchars($current['smtp_user']) ?>">
                        </label>
                        <label>Password
                            <input type="password" name="smtp_pass" value="" placeholder="••••••••">
                        </label>
                    </div>
                    <p class="hint"><i class="fa-regular fa-lightbulb"></i> We never show existing SMTP passwords—enter only to change.</p>
                </div>
            </section>

            <!-- THEME -->
            <section id="theme" class="tab-panel">
                <div class="card">
                    <h3><i class="fa-solid fa-circle-half-stroke"></i> Theme</h3>
                    <div class="theme-row">
                        <label class="theme-option">
                            <input type="radio" name="theme" value="light" <?= $current['theme']==='light'?'checked':''; ?>>
                            <div class="theme-card light"><i class="fa-solid fa-sun"></i> Light</div>
                        </label>
                        <label class="theme-option">
                            <input type="radio" name="theme" value="dark" <?= $current['theme']==='dark'?'checked':''; ?>>
                            <div class="theme-card dark"><i class="fa-solid fa-moon"></i> Dark</div>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Save -->
            <div class="actions">
                <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
            </div>
        </form>
    </main>
</div>

<script>
/* Tabs */
document.querySelectorAll('.tab-btn').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(btn.dataset.tab).classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});

/* Live previews */
const preview = (inputId, imgId) => {
  const input = document.getElementById(inputId);
  if (!input) return;
  input.addEventListener('change', e=>{
    const file = e.target.files?.[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    const img = document.getElementById(imgId);
    if (img) img.src = url;
  });
};
preview('logoInput','logoPreview');
preview('avatarInput','avatarPreview');
</script>
</body>
</html>
