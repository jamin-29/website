<?php
// includes/auth_session.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// helper: check user logged in
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit;
    }
}

function is_admin() {
    return !empty($_SESSION['is_admin']);
}
