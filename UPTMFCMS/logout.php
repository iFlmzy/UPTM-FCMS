<?php

session_start();

if (isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['student_id']);
    unset($_SESSION['student_name']);
    unset($_SESSION['student_email']);
    $_SESSION['message_login'] = 'Logged out successfully';
}

header('Location: ./');
