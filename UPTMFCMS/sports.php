<?php include("./includes/header.php") ?>

<div id="root" ng-controller="controller" ng-init="init()">

  <section class="other">
    <div class="text">
      <span class="title text-center">Sports</span>
      <span class="desc">facilities</span>
    </div>
    <div class="backdrop"></div>
    <?php include("./includes/divider.php") ?>
  </section>

  <section class="vh-100 position-relative" style="background-color: #fff; padding: 100px 0;">
    <div>
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

  </section>

</div>

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