<?php
include('../config/connection.php');

$iTaskId = $_REQUEST['task'];

if ($iTaskId === "GetCategory") {
  $select_query = "SELECT * FROM tbl_category";
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

if ($iTaskId === "InsertCategory") {

  $category_title = mysqli_real_escape_string($conn, $_REQUEST['category_title']);
  $current_date = date('Y-m-d H:i:s');
  $insert_query = "INSERT INTO tbl_category (category_title, date_time_create) VALUES ('$category_title', '$current_date')";
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

if ($iTaskId === "UpdateCategory") {
  $category_id = mysqli_real_escape_string($conn, $_REQUEST['category_id']);
  $category_title = mysqli_real_escape_string($conn, $_REQUEST['category_title']);

  $update_query = "UPDATE tbl_category SET category_title = '$category_title' WHERE category_id = $category_id";
  $update_result = mysqli_query($conn, $update_query);
  if ($update_result) {
    $data['status'] = 0;
    $data['message'] = "Success";
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
  }
  echo json_encode($data);
}

if ($iTaskId === "RemoveCategory") {

  $category_id = mysqli_real_escape_string($conn, $_REQUEST['category_id']);
  $remove_query = "DELETE FROM tbl_category where category_id = $category_id";
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
