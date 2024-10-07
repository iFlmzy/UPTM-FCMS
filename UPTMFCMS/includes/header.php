<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" ng-app="myapp">

<head>
  <title>UPTM FCMS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="./vendor/bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="../vendor/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" type="text/css" href="./vendor/dropify/dropify.min.css">
  <link rel="stylesheet" type="text/css" href="./vendor/semantic/item.min.css">
  <link rel="stylesheet" type="text/css" href="./vendor/semantic/label.min.css">
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="./vendor/grid/ag-grid-community.min.js"></script>

</head>

<body>

  <nav>
    <ul class="nav-bar mb-0">
      <li class="logo position-relative">
        <div class="logo-wrapper">
          <a href="#" class="d-flex justify-content-center align-items-center">
            <img src="./img/logo.png" style="width: auto; height: 120px;" />
          </a>
        </div>
      </li>
      <input type="checkbox" id="check" />
      <span class="menu">
        <li><a class="active" href="./home.php">Home</a></li>
        <li><a href="./sports.php">Sports</a></li>
        <li><a href="./mybooking.php">Booking</a></li>
        <li><a href="./instruction.php">Instruction</a></li>
        <li><a href="./contact.php">Contact Us</a></li>
        <li><a href="./logout.php">Log Out</a></li>
        <label for="check" class="close-menu">
          <i class="fa-solid fa-x"></i>
        </label>
      </span>
      <label for="check" class="open-menu">
        <i class="fa-solid fa-align-right" style="color: #fff;"></i>
      </label>
    </ul>
  </nav>
