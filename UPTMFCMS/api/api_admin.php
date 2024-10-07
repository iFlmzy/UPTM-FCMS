<?php
include('../config/connection.php');
$iTaskId = $_REQUEST['task'];

if ($iTaskId === "GetAdmin") {
    $select_query = "SELECT * FROM tbl_admin";
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
            $data['message'] = "No records";
        }
    } else {
        $data['status'] = 1;
        $data['message'] = "Failed";
        $data['error'] = mysqli_error($conn);
    }

    echo json_encode($data);
}

if ($iTaskId === 'CreateAdmin') {
    $admin_name = $_REQUEST['admin_name'];
    $admin_email = $_REQUEST['admin_email'];
    $admin_password = $_REQUEST['admin_password'];
    $admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $current_date = date("Y-m-d H:i:s");
    $insert_query = "INSERT INTO tbl_admin (admin_name, admin_email, admin_password) VALUES ('$admin_name', '$admin_email', '$admin_password')";
    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        $data['status'] = 0;
        $data['message'] = "Added successfully";
    } else {
        $data['status'] = 1;
        $data['message'] = "Failed to create user";
        $data['error'] = mysqli_error($conn);
    }

    echo json_encode($data);
    $conn->close();
}

if ($iTaskId === "RemoveAdmin") {

    $admin_id = mysqli_real_escape_string($conn, $_REQUEST['admin_id']);
    $remove_query = "DELETE FROM tbl_admin where admin_id = $admin_id";
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
