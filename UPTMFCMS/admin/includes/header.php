<?php

include('../config/connection.php');
session_start();
if (!isset($_SESSION['auth_admin'])) {
  $_SESSION['message'] = 'Please log in first';
  header('Location: ./index.php');
  exit();
}

?>

<!doctype html>
<html lang="en" ng-app="myapp">

<head >
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <link rel="stylesheet" href="../vendor/bootstrap/bootstrap2.min.css">
  <link rel="stylesheet" href="../vendor/fontawesome/fontawesome.min.css">
  <link rel="stylesheet" href="../vendor/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="../vendor/dropify/dropify.min.css">
  <link rel="stylesheet" href="../vendor/semantic/item.min.css">
  <link rel="stylesheet" href="../vendor/semantic/label.min.css">
  <script src="../vendor/grid/ag-grid-community.min.js"></script>

</head>

<style>
  body {
    position: relative;
    display: flex;
    overflow: hidden;
  }

  .page-wrapper {
    position: relative;
    width: calc(100% - 280px) !important;
  }

  .body-wrapper {
    overflow: auto;
    height: calc(100vh - 56px);
    background-color: #f7f6f6 !important;
  }

  .body-wrapper::-webkit-scrollbar {
    width: 10px;
  }

  .body-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  .body-wrapper::-webkit-scrollbar-thumb {
    background: #888;
  }

  .body-wrapper::-webkit-scrollbar-thumb:hover {
    background: #555;
  }

  .ag-header {
    border-bottom: 0px !important;
    background-color: #2b5da2 !important;
    color: #fff !important;
    border-radius: 10px !important;
  }

  .ag-header-cell-text {
    color: #fff !important;
  }

  .ag-header-center .ag-header-cell-label {
    justify-content: center;
  }

  .ag-cell-center {
    justify-content: center;
  }

  .ag-root-wrapper {
    border: 0 !important;
  }

  .ag-cell {
    display: flex !important;
    align-items: center !important;
    font-family: poppins, 'sans-serif' !important;
  }

  .ag-row {
    z-index: 0 !important;
  }

  .ag-row.ag-row-focus {
    z-index: 1 !important;
  }

  .number {
    width: 30px;
    height: 30px;
    border-radius: 40px;
    position: absolute;
    bottom: -10px;
    left: 45%;
    border: 3px solid #fff;
    line-height: 2;
    transform: translateX(-50%);
    text-align: center;
    background: #ffb800;
    color: #000;
    font-size: 12px;
    font-weight: 600;
  }
</style>

<body>
  <?php include('./includes/sidebar.php') ?>
  <div class="page-wrapper">
    <?php include('./includes/navbar.php') ?>