<?php include("./includes/header.php") ?>

<div id="root" ng-controller="controller" ng-init="init()">

  <section class="other">
    <div class="text">
      <span class="title text-center">Booking</span>
      <span class="desc">history</span>
    </div>
    <div class="backdrop"></div>
    <?php include("./includes/divider.php") ?>
  </section>

  <section class="position-relative" style="background-color: #fff; padding: 100px 0;">
    <div>
      <div class="container mt-5">
        <div class="row">
          <div class="col-lg-6 mb-3" ng-repeat="data in bookingListing">
            <div class="card rounded-0 border h-100 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h4 class="card-title adventis">
                    {{ data.sport_name }}
                  </h4>
                  <div class="border py-1 px-3 d-inline-block text-capitalize">
                    {{ data.category_title }}
                  </div>
                </div>

                <div class="d-flex align-items-center" style="padding: 20px 0; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
                  <div class="d-flex">
                    <p class="mb-0" style="color: #999;"><i class="fa-solid fa-clock"></i> <span class="ms-2">{{ data.booking_slot | datetime }}</span></p>
                    <p class="ms-3 mb-0" style="color: #999;"><i class="fa-solid fa-stopwatch"></i></i> <span class="ms-2">{{ data.duration }} hours</span></p>
                  </div>
                </div>

                <div class="d-flex mt-3">
                  <div class="border py-2 px-3 d-inline-block text-capitalize">
                    {{ data.booking_status | status }}
                  </div>
                  <div ng-if="data.booking_status === 'pending'" class="border py-2 px-3 d-inline-block ms-2 bg-danger text-light" style="cursor: pointer;" ng-click="sendCancelBooking(data)">
                    Cancel Booking
                  </div>
                </div>
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
  app.filter("datetime", function($filter, $sce) {
    return function(input) {
      if (input && input !== "0000-00-00 00:00:00") {
        const newDate = new Date(input);
        const momentDate = moment(newDate).format("LLL");
        return momentDate
      }

      return "";
    };
  });

  app.filter("status", function($filter, $sce) {
    return function(input) {
      if (input === "pending") {
        return "pending"
      } else if (input === "cancel") {
        return "cancelled"
      } else if (input === "confirm") {
        return "approved"
      } else if (input === "reject") {
        return "rejected"
      }

      return "";
    };
  });

  app.controller("controller", function($scope, $http, $timeout, $sce) {

    $scope.init = function() {
      $http.get("./api/api_booking.php", {
        params: {
          task: "StudentBooking",
          student_id: '<?= $_SESSION['student_id'] ?>'
        },
      }).then(function(response) {
        const data = response.data;
        if (data.status === 0) {
          data.record.forEach(record => {
            record.duration = Number(record.booking_duration) / 60;
          });
          $scope.bookingListing = data.record;
        } else {
          $scope.bookingListing = [];
        }
      }).catch(function(error) {
        console.error(error);
      });
    }

    $scope.sendCancelBooking = (record) => {
      $http.get("./api/api_booking.php", {
        params: {
          task: "CancelBooking",
          booking_id: record.booking_id
        },
      }).then(function(response) {
        const data = response.data;
        if (data.status === 0) {
          $scope.init();
        } else {
          alert("Something wrong with your entry, please try again");
        }
      }).catch(function(error) {
        console.error(error);
      });
    }

  });
</script>
<?php include("./includes/footer.php") ?>