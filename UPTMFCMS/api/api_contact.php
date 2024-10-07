<?php
include('../config/connection.php');

$iTaskId = $_REQUEST['task'];

if ($iTaskId === "GetMessage") {

  $current_date = date('Y-m-d H:i:s');
  $select_query = "SELECT * FROM tbl_message ORDER BY date_time_create DESC";
  $select_result = mysqli_query($conn, $select_query);
  if ($select_result) {
    $select_rows = mysqli_num_rows($select_result);
    if ($select_rows > 0) {
      $data['status'] = 0;
      $data['record'] = array();
      while ($select_info = mysqli_fetch_assoc($select_result)) {
        $data['record'][] = $select_info;
      }
    } else {
      $data['status'] = 1;
      $data['message'] = "No record";
    }
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
    $data['error'] = mysqli_error($conn);
  }
  echo json_encode($data);
}

if ($iTaskId === "GetMessageDashboard") {

  $current_date = date('Y-m-d H:i:s');
  $select_query = "SELECT * FROM tbl_message ORDER BY date_time_create DESC LIMIT 5";
  $select_result = mysqli_query($conn, $select_query);
  if ($select_result) {
    $select_rows = mysqli_num_rows($select_result);
    if ($select_rows > 0) {
      $data['status'] = 0;
      $data['record'] = array();
      while ($select_info = mysqli_fetch_assoc($select_result)) {
        $data['record'][] = $select_info;
      }
    } else {
      $data['status'] = 1;
      $data['message'] = "No record";
    }
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
    $data['error'] = mysqli_error($conn);
  }
  echo json_encode($data);
}

if ($iTaskId === "SendMessage") {

  $name = mysqli_real_escape_string($conn, $_REQUEST['name']);
  $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
  $message = mysqli_real_escape_string($conn, $_REQUEST['message']);
  $current_date = date('Y-m-d H:i:s');

  $insert_query = "INSERT INTO tbl_message (name, email, message, date_time_create) VALUES ('$name', '$email', '$message', '$current_date')";
  $insert_result = mysqli_query($conn, $insert_query);
  if ($insert_result) {
    $data['status'] = 0;
    $data['message'] = "Success";
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
  }
  echo json_encode($data);
}


mysqli_close($conn);
