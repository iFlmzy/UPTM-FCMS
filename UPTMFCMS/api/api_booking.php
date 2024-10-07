<?php
ini_set('memory_limit', '1024M');
include('../config/connection.php');

$iTaskId = $_REQUEST['task'];

if ($iTaskId === "GetBookingTime") {
  $sport_id = mysqli_real_escape_string($conn, $_REQUEST['sport_id']);
  $chosenDate = mysqli_real_escape_string($conn, $_REQUEST['chosen_date']);

  if (empty($chosenDate)) {
    $chosenDate  = date('Y-m-d');
    $chosenDatePlus1 = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
    $chosenDatePlus2 = date('Y-m-d', strtotime('+2 day', strtotime(date('Y-m-d'))));
  } else {
    $chosenDate = date_create($chosenDate);
    $chosenDate = $chosenDate->format('Y-m-d');
    $chosenDatePlus1 = date('Y-m-d', strtotime('+1 day', strtotime($chosenDate)));
    $chosenDatePlus2 = date('Y-m-d', strtotime('+2 day', strtotime($chosenDate)));
  }

  $timeslot = getTimeSlot(60, '07:00', '22:00', $chosenDate);
  $timeslotplus1 = getTimeSlot(60, '07:00', '22:00', $chosenDatePlus1);
  $timeslotplus2 = getTimeSlot(60, '07:00', '22:00', $chosenDatePlus2);

  $select_query = "SELECT * FROM tbl_booking WHERE sport_id = '$sport_id' AND DATE(booking_slot) IN ('$chosenDate', '$chosenDatePlus1', '$chosenDatePlus2') ";
  $select_result = mysqli_query($conn, $select_query);

  if ($select_result) {
    $select_rows = mysqli_num_rows($select_result);
    $data['status'] = 0;
    if ($select_rows > 0) {

      while ($select_info = mysqli_fetch_assoc($select_result)) {
        $booking_slot = $select_info['booking_slot'];
        $booking_slot_str = new DateTime($booking_slot);
        $booking_date = $booking_slot_str->format('Y-m-d');
        $booking_time = $booking_slot_str->format('H:i');
        $booking_duration = (int)$select_info['booking_duration'];

        if ($booking_date === $chosenDate) {
          for ($j = 0; $j < sizeof($timeslot); $j++) {
            if ($booking_time === $timeslot[$j]['slot_start_time']) {
              $timeslot[$j]['availability'] = 'no';
              $totalslots = $booking_duration / 60;
              if (($totalslots > 0) && ($totalslots < 20)) {
                for ($k = 0; $k < $totalslots; $k++) {
                  if ($timeslot[$j + $k] <> '') {
                    $timeslot[$j + $k]['availability'] = 'no';
                  }
                }
              }
            }
          }
        }

        if ($booking_date === $chosenDatePlus1) {
          for ($j = 0; $j < sizeof($timeslotplus1); $j++) {
            if ($booking_time === $timeslotplus1[$j]['slot_start_time']) {
              $timeslotplus1[$j]['availability'] = 'no';
              $totalslots = $booking_duration / 60;
              if (($totalslots > 0) && ($totalslots < 20)) {
                for ($k = 0; $k < $totalslots; $k++) {
                  if ($timeslotplus1[$j + $k] <> '') {
                    $timeslotplus1[$j + $k]['availability'] = 'no';
                  }
                }
              }
            }
          }
        }

        if ($booking_date === $chosenDatePlus2) {
          for ($j = 0; $j < sizeof($timeslotplus2); $j++) {
            if ($booking_time === $timeslotplus2[$j]['slot_start_time']) {
              $timeslotplus2[$j]['availability'] = 'no';
              $totalslots = $booking_duration / 60;
              if (($totalslots > 0) && ($totalslots < 20)) {
                for ($k = 0; $k < $totalslots; $k++) {
                  if ($timeslotplus2[$j + $k] <> '') {
                    $timeslotplus2[$j + $k]['availability'] = 'no';
                  }
                }
              }
            }
          }
        }
      }
    }
  } else {
    $data['status'] = 444;
    $data['message'] = "Failed to get the booking slot time";
    $data['error'] = mysqli_error($conn);
  }

  $data['dates'][0] = $chosenDate;
  $data['dates'][1] = $chosenDatePlus1;
  $data['dates'][2] = $chosenDatePlus2;
  $data['chosenDate'] = $timeslot;
  $data['chosenDatePlus1'] = $timeslotplus1;
  $data['chosenDatePlus2'] = $timeslotplus2;

  echo json_encode($data);
  mysqli_close($conn);
}

if ($iTaskId === "InsertBooking") {

  // Validate and sanitize input data
  $student_id = mysqli_real_escape_string($conn, $_REQUEST['student_id']);
  $sport_id = mysqli_real_escape_string($conn, $_REQUEST['sport_id']);
  $booking_slot = mysqli_real_escape_string($conn, $_REQUEST['booking_slot']);
  $booking_duration = mysqli_real_escape_string($conn, $_REQUEST['booking_duration']);
  $category_id = mysqli_real_escape_string($conn, $_REQUEST['category_id']);
  $current_date = date("Y-m-d H:i:s");
  $insert_query = "INSERT INTO tbl_booking (student_id, sport_id, booking_slot, booking_duration, booking_status, category_id, date_time_create) VALUES ('$student_id', '$sport_id', '$booking_slot', '$booking_duration', 'pending', '$category_id', '$current_date')";
  $insert_result = mysqli_query($conn, $insert_query);

  if ($insert_result) {
    $data['status'] = 0;
    $data['message'] = "Success";
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
    $data['error'] = mysqli_error($conn);
  }

  echo json_encode($data);
}

if ($iTaskId === "StudentBooking") {
  $student_id = mysqli_real_escape_string($conn, $_REQUEST['student_id']);
  $select_query = "SELECT * FROM tbl_booking booking
                   INNER JOIN tbl_sports sport ON sport.sport_id = booking.sport_id
                   INNER JOIN tbl_category cat ON cat.category_id = booking.category_id
                   WHERE booking.student_id = '$student_id' ORDER BY booking.booking_slot DESC";
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

if ($iTaskId === "DashboardBooking") {
  $select_query = "SELECT * FROM tbl_booking booking
                   INNER JOIN tbl_student student ON student.student_id = booking.student_id
                   INNER JOIN tbl_sports sport ON sport.sport_id = booking.sport_id
                   INNER JOIN tbl_category cat ON cat.category_id = booking.category_id
                   WHERE booking.booking_status = 'confirm' ORDER BY booking.booking_slot ASC LIMIT 5";
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

if ($iTaskId === "GetBooking") {
  $select_query = "SELECT * FROM tbl_booking booking
                   INNER JOIN tbl_student student ON student.student_id = booking.student_id
                   INNER JOIN tbl_sports sport ON sport.sport_id = booking.sport_id
                   INNER JOIN tbl_category cat ON cat.category_id = booking.category_id
                   ORDER BY booking.date_time_create DESC";
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

if ($iTaskId === "UpdateBooking") {
  $booking_id = mysqli_real_escape_string($conn, $_REQUEST['booking_id']);
  $booking_status = mysqli_real_escape_string($conn, $_REQUEST['booking_status']);
  $update_query = "UPDATE tbl_booking SET booking_status = '$booking_status' WHERE booking_id = '$booking_id'";
  $update_result = mysqli_query($conn, $update_query);

  if ($update_query) {
    $data['status'] = 0;
    $data['message'] = "Success";
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
    $data['error'] = mysqli_error($conn);
  }

  echo json_encode($data);
}

if ($iTaskId === "CancelBooking") {
  $booking_id = mysqli_real_escape_string($conn, $_REQUEST['booking_id']);
  $update_query = "UPDATE tbl_booking SET booking_status = 'cancel' WHERE booking_id = '$booking_id'";
  $update_result = mysqli_query($conn, $update_query);

  if ($update_query) {
    $data['status'] = 0;
    $data['message'] = "Success";
  } else {
    $data['status'] = 1;
    $data['message'] = "Failed";
    $data['error'] = mysqli_error($conn);
  }

  echo json_encode($data);
}


function getTimeSlot($interval, $start_time, $end_time, $date)
{
  $start = new DateTime($start_time);
  $end = new DateTime($end_time);
  $startTime = $start->format('H:i');
  $endTime = $end->format('H:i');

  $i = 0;
  $time = [];
  while (strtotime($startTime) <= strtotime($endTime)) {
    $start = $startTime;
    $end = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));
    $startTime = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));

    if (strtotime($startTime) <= strtotime($endTime)) {
      $time[$i]['slot_start_time'] = $start;
      $time[$i]['slot_end_time'] = $end;
      $time[$i]['availability'] = 'yes';
      $time[$i]['date'] = $date;
    }
    $i++;
  }
  return $time;
}
