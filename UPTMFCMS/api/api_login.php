<?php

session_start();
include('../config/connection.php');

if (isset($_REQUEST['loginBtn'])) {
  $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
  $password = mysqli_real_escape_string($conn, $_REQUEST['password']);

  $login_query = "SELECT * FROM tbl_student WHERE student_email = '$email' LIMIT 1";
  $login_query_run = mysqli_query($conn, $login_query);

  if (mysqli_num_rows($login_query_run) > 0) {
    $userdata = mysqli_fetch_assoc($login_query_run);
    if (password_verify($password, $userdata['student_password'])) {
      $student_id = $userdata['student_id'];
      $student_name = $userdata['student_name'];
      $student_email = $userdata['student_email'];
      $_SESSION['auth'] = true;
      $_SESSION['student_id'] = $student_id;
      $_SESSION['student_name'] = $student_name;
      $_SESSION['student_email'] = $student_email;
      $_SESSION['message_login'] = 'Logged in successfully';
      header('Location: ../home.php');
    } else {
      $_SESSION['message_login'] = 'Invalid username or password';
      header('Location: ../index.php');
    }
  } else {
    $_SESSION['title'] = 'Failed';
    $_SESSION['message_login'] = 'Invalid username or password';
    header('Location: ../index.php');
  }
}

if (isset($_REQUEST['register_btn'])) {
  $fullname = $_REQUEST['fullname'];
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];
  $currentdatetime = date("Y-m-d H:i:s");
  $hashed_password = password_hash($password, PASSWORD_BCRYPT);
  $insert_query = "INSERT INTO tbl_student (student_name, student_email, student_password, date_time_create) VALUES ('$fullname', '$email', '$hashed_password', '$currentdatetime')";
  if (mysqli_query($conn, $insert_query)) {
    $student_id = mysqli_insert_id($conn);
    $_SESSION['auth'] = true;
    $_SESSION['student_id'] = $student_id;
    $_SESSION['student_name'] = $username;
    $_SESSION['student_email'] = $email;
    $_SESSION['message_register'] = 'Created';
    header('Location: ../home.php');
  } else {
    $_SESSION['message_register'] = 'Cannot create an account';
    header('Location: ../index.php');
  }
  mysqli_close($conn);
}

if (isset($_REQUEST['adminLoginBtn'])) {

  $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
  $password = mysqli_real_escape_string($conn, $_REQUEST['password']);

  $login_query = "SELECT * FROM tbl_admin WHERE admin_email='$email' LIMIT 1";
  $login_query_run = mysqli_query($conn, $login_query);

  if (mysqli_num_rows($login_query_run) > 0) {

    $userdata = mysqli_fetch_assoc($login_query_run);
    if (password_verify($password, $userdata['admin_password'])) {

      $_SESSION['auth_admin'] = true;
      $_SESSION['admin_id'] = true;
      $_SESSION['admin_name'] = true;
      $_SESSION['admin_password'] = true;
      $_SESSION['admin_login_message'] = 'Logged in successfully';
      header('Location: ../admin/dashboard.php');
    } else {
      $_SESSION['admin_login_message'] = 'Invalid username or password';
      header('Location: ../admin/');
    }
  } else {
    $_SESSION['admin_login_message'] = 'Invalid username or password';
    header('Location: ../admin/');
  }
}
