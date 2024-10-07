<?php
  include('../config/connection.php');
  session_start();
  if (isset($_SESSION['auth_admin'])) {
    $_SESSION['admin_login_message'] = 'You are already logged In';
    header('Location: ./dashboard.php');
    exit();
  }
?>

<!doctype html>
<html lang="en" ng-app="myapp">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <link rel="stylesheet" href="../vendor/bootstrap/bootstrap2.min.css">
  <link rel="stylesheet" href="../vendor/fontawesome/fontawesome.min.css">
  <link rel="stylesheet" href="../vendor/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="../vendor/dropify/dropify.min.css">
  <link rel="stylesheet" href="../vendor/semantic/item.min.css">
  <link rel="stylesheet" href="../vendor/semantic/label.min.css">
  <script src="./assets/vendor/grid/ag-grid-community.min.js"></script>

</head>

<body ng-controller="myCtrl" ng-init="init()" id="root">
  <div class="page-wrapper">

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
              <div class="card mb-0 shadow border-0">
                <div class="card-body">

                  <a href="./" class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="../img/logo.png" width="180" alt="">
                  </a>

                  <?php
                  if (isset($_SESSION['admin_login_message'])) { ?>
                    <div class="alert alert-warning alert-dismissible fade show d-flex justify-content-between">
                      <?= $_SESSION['admin_login_message']; ?>
                    </div>
                  <?php unset($_SESSION['admin_login_message']);
                  }
                  ?>

                  <form class="form" action="../api/api_login.php" method="POST">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                      <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                      <label for="password">Password</label>
                    </div>

                    <button type="submit" name="adminLoginBtn" class="btn btn-primary w-100 rounded">Sign In</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?php include('includes/footer.php') ?>