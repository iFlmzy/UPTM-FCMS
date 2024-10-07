<?php
include('../config/connection.php');

$iTaskId = $_REQUEST['task'];

if ($iTaskId === "GetSports") {
  $select_query = "SELECT * FROM tbl_sports";
  $select_result = mysqli_query($conn, $select_query);
  if ($select_result) {

    $select_rows = mysqli_num_rows($select_result);
    if ($select_rows > 0) {
      $data['status'] = 0;
      $data['record'] = array();;
      while ($select_info = mysqli_fetch_assoc($select_result)) {
        $data['record'][] = $select_info;
      }
    } else {
      $data['status'] = 1;
      $data['message'] = "No record";
    }
  } else {
    $data['status'] = 444;
    $data['message'] = "Failed";
    $data['error'] = mysqli_error($conn);
  }

  echo json_encode($data);
}

if ($iTaskId === "InsertSports") {

  $sport_name = mysqli_real_escape_string($conn, $_REQUEST['sport_name']);
  $current_date = date('Y-m-d H:i:s');
  $insert_query = "INSERT INTO tbl_sports (sport_name, date_time_create) VALUES ('$sport_name', '$current_date')";
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

if ($iTaskId === "UpdateSports") {
  $sport_id = mysqli_real_escape_string($conn, $_REQUEST['sport_id']);
  $sport_name = mysqli_real_escape_string($conn, $_REQUEST['sport_name']);

  $update_query = "UPDATE tbl_sports SET sport_name = '$sport_name' WHERE sport_id = $sport_id";
  $update_result = mysqli_query($conn, $update_query);
  // echo $update_query; die;
  if ($update_result) {
    $data['status'] = 0;
    $data['message'] = "Success";
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
  }
  echo json_encode($data);
}

if ($iTaskId === "RemoveSports") {

  $sport_id = mysqli_real_escape_string($conn, $_REQUEST['sport_id']);
  $remove_query = "DELETE FROM tbl_sports WHERE sport_id = $sport_id";
  $remove_result = mysqli_query($conn, $remove_query);
  if ($remove_result) {
    $data['status'] = 0;
    $data['message'] = "Success";
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
  }
  echo json_encode($data);
}

mysqli_close($conn);
