<?php

session_start();
include('../config/connection.php');

$iTaskId = $_REQUEST['task'];

if ($iTaskId === 'GetAnalytics') {

  // GET CUSTOMER REGISTERED -----------------------------

  $latestDate = getLatestStudentCreationDate($conn);
  $chartData = array();
  for ($i = 7; $i >= 0; $i--) {
    $monthDate = date('Y-m-01', strtotime("-$i months", strtotime($latestDate)));
    $endOfMonth = date('Y-m-t 23:59:59', strtotime($monthDate));
    $formattedDate = date('M Y', strtotime($monthDate));
    $student_count = getStudentCountForMonth($conn, $monthDate, $endOfMonth);
    $chartData[] = array('date' => $formattedDate, 'student_count' => $student_count);
  }

  $data['student'] = $chartData;

  // GET ORDERS ------------------------------------------

  $latestDate = getLatestBooking($conn);
  $chartData2 = array();
  for ($i = 7; $i >= 0; $i--) {
    $monthDate = date('Y-m-01', strtotime("-$i months", strtotime($latestDate)));
    $endOfMonth = date('Y-m-t 23:59:59', strtotime($monthDate));
    $formattedDate = date('M Y', strtotime($monthDate));
    $bookingCount = getBookingCountForMonth($conn, $monthDate, $endOfMonth);
    $chartData2[] = array('date' => $formattedDate, 'booking_count' => $bookingCount);
  }

  $data['booking'] = $chartData2;
  echo json_encode($data);
  $conn->close();
}

function getLatestStudentCreationDate($conn)
{
  $sql = "SELECT MAX(date_time_create) AS latest_date FROM tbl_student";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['latest_date'];
  }

  return date('Y-m-d');
}

function getStudentCountForMonth($conn, $startOfMonth, $endOfMonth)
{
  $sql = "SELECT COUNT(*) AS student_count FROM tbl_student WHERE date_time_create BETWEEN '$startOfMonth' AND '$endOfMonth'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return (int)$row['student_count'];
  }

  return 0;
}

function getLatestBooking($conn)
{
  $sql = "SELECT MAX(date_time_create) AS latest_date FROM tbl_booking WHERE booking_status = 'confirm'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['latest_date'];
  }

  return date('Y-m-d');
}

function getBookingCountForMonth($conn, $startOfMonth, $endOfMonth)
{
  $sql = "SELECT COUNT(*) AS booking_count FROM tbl_booking WHERE date_time_create BETWEEN '$startOfMonth' AND '$endOfMonth' AND booking_status = 'confirm'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return (int)$row['booking_count'];
  }

  return 0;
}
