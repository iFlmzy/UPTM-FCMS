<?php include("./includes/header.php") ?>


<div id="root" ng-controller="controller" ng-init="init()">
  <section class="home">
    <div class="text"><span>An easy way to <br> book your court.</span></div>
    <div class="backdrop"></div>
    <?php include("./includes/divider.php") ?>
  </section>

  <section class="position-relative d-flex justify-content-center align-items-center" style="padding: 100px 0;">
    <div>
      <div class="title-container">
        <div class="title-wrapper">
          <h2 class="title-stroke">intruction</h2>
          <div class="title-desc">attention</div>
        </div>
      </div>
      <p class="mt-3 text-center fw-bold">Please follow all this instruction before you start booking</p>
      <div class="container mt-5">
        <div class="row g-0">
          <div class="col-lg-3">
            <div class="card rounded-0 border-0 h-100">
              <div class="card-body py-5">
                <div class="text-center mb-3 ">
                  <i class="fa-solid fa-person-circle-exclamation" style="font-size: 50px;"></i>
                </div>
                <div class="text-center mb-3">
                  <i class="fa-solid fa-ellipsis" style="font-size: 30px;"></i>
                </div>
                <p class=" text-center fw-bold" style="text-transform: capitalize;">PLEASE MAKE SURE ONLY ONE MEMBER OF THE TEAM DOES THE BOOKING.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card rounded-0 border-0 h-100">
              <div class="card-body py-5" style="background-color: #ed1c24;">
                <div class="text-center mb-3 text-light">
                  <i class="fa-solid fa-circle-exclamation" style="font-size: 50px;"></i>
                </div>
                <div class="text-center mb-3 text-light">
                  <i class="fa-solid fa-ellipsis" style="font-size: 30px;"></i>
                </div>
                <p class=" text-center text-light fw-bold">CANCELLATION HAVE TO BE DONE BEFORE AN HOUR OR ELSE FINE WILL BE TAKEN.</p>
              </div>
              <?php include("./includes/divider.php") ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card rounded-0 border-0 h-100">
              <div class="card-body py-5">
                <div class="text-center mb-3">
                  <i class="fa-solid fa-clock" style="font-size: 50px;"></i>
                </div>
                <div class="text-center mb-3">
                  <i class="fa-solid fa-ellipsis" style="font-size: 30px;"></i>
                </div>
                <p class=" text-center fw-bold">BOOKING ONCE CANCELLED CANNOT BE RESTORED BACK.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 ">
            <div class="card rounded-0 border-0 h-100">
              <div class="card-body py-5" style="background-color: #2b5da2;">
                <div class="text-center mb-3 text-light">
                  <i class="fa-solid fa-futbol" style="font-size: 50px;"></i>
                </div>
                <div class="text-center mb-3 text-light">
                  <i class="fa-solid fa-ellipsis" style="font-size: 30px;"></i>
                </div>
                <p class=" text-center text-light fw-bold">PLEASE BRING YOUR OWN EQUIPMENTS TO PLAY.</p>
              </div>
              <?php include("./includes/divider.php") ?>
            </div>
          </div>
        </div>
      </div>
      <?php include("./includes/divider2.php") ?>
    </div>

  </section>

  <section class="vh-100 position-relative" style="background-color: #f3f3eb; padding: 100px 0;">
    <div>
      <div class="title-container">
        <div class="title-wrapper">
          <h2 class="title-stroke">sports</h2>
          <div class="title-desc2">facilities</div>
        </div>
      </div>
      <p class="mt-3 text-center fw-bold">Please choose the sport facility to start booking</p>
      <div class="container mt-5">
        <div class="row">
          <div class="col-lg-6" ng-repeat="data in sportListing">
            <div class="card rounded-0 border-0 h-100">
              <img src="./img/futsalcourt2.jpg" class="card-img-top" alt="...">
              <div class="w-100" style="position: absolute; bottom: 0; background-color: rgba(0, 0, 0, 0.3); padding: 10px 20px">
                <a class="adventis fw-bold text-decoration-none text-light fs-1" style="cursor: pointer;" ng-click="openBooking(data)">{{data.sport_name}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include("./includes/divider2.php") ?>
  </section>


  <?php include("./includes/function.php") ?>
  <script>
    app.controller("controller", function($scope, $http, $timeout, $sce) {

      $scope.init = function() {
        $http.get("./api/api_sports.php", {
          params: {
            task: "GetSports",
          },
        }).then(function(response) {
          const data = response.data;
          if (data.status === 0) {
            $scope.sportListing = data.record;
          } else {
            $scope.sportListing = [];
          }
        }).catch(function(error) {
          console.error(error);
        });
      }

      $scope.openBooking = function(record) {
        window.open(`./booking.php?sport=${record.sport_id}&text=${record.sport_name}`, "_self");
      }

    });
  </script>
  <?php include("./includes/footer.php") ?>