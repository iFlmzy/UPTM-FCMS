<?php

session_start();

if (isset($_SESSION['auth_admin'])) {
    unset($_SESSION['auth_admin']);
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['admin_password']);
    $_SESSION['admin_login_message'] = 'Logged out successfully';
}

header('Location: index.php');
