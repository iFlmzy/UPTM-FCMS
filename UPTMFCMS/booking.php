<?php include("./includes/header.php") ?>

<div id="root" ng-controller="controller" ng-init="init()">

  <section class="other">
    <div class="text">
      <span class="title text-center">Booking</span>
      <span class="desc"><?= $_GET['text'] ?></span>
    </div>
    <div class="backdrop"></div>
    <?php include("./includes/divider.php") ?>
  </section>

  <section class="container" style="padding: 50px 0;">
    <div class="appointment-content">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <input class="form-control" type="date" name="chosendate" id="chosendate" style="width: 15%;" ng-model="selectedDate" ng-change="onchangeDate()">
          <button type="button" class="btn btn-link text-decoration-none" ng-click="getNextDate()">Next 3 days</button>
        </div>
        <div class="card-body p-0">
          <div class="row g-0">
            <div class="col-4">
              <div class="card border-0">
                <div class="card-header text-center">
                  <span class="text-center w-100" ng-bind-html="list.dates[0] | dates"></span>
                </div>
                <div class="card-body">
                  <div class="d-flex flex-wrap justify-content-center align-items-center w-100" ng-repeat="data in list.chosenDate">
                    <div class="cat action">
                      <label>
                        <input type="checkbox" ng-attr-id="todayslot{{$index}}" name="todayslot" ng-value="data.slot_start_time" ng-disabled="data.availability === 'no'" ng-model="todayslot" ng-click="onchangeToday()"><span>{{data.slot_start_time | showtime}} - {{data.slot_end_time | showtime}}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card border-0">
                <div class="card-header text-center">
                  <span class="text-center w-100" ng-bind-html="list.dates[1] | dates"></span>
                </div>
                <div class="card-body">
                  <div class="d-flex flex-wrap justify-content-center align-items-center w-100" ng-repeat="data in list.chosenDatePlus1">
                    <div class="cat action">
                      <label>
                        <input type="checkbox" ng-attr-id="tomorrowslot{{$index}}" name="tomorrowslot" ng-value="data.slot_start_time" ng-disabled="data.availability === 'no'" ng-model="tomorrowslot" ng-click="onchangeTomorrow()"><span>{{data.slot_start_time | showtime}} - {{data.slot_end_time | showtime}}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card border-0">
                <div class="card-header text-center">
                  <span class="text-center w-100" ng-bind-html="list.dates[2] | dates"></span>
                </div>
                <div class="card-body">
                  <div class="d-flex flex-wrap justify-content-center align-items-center w-100" ng-repeat="data in list.chosenDatePlus2">
                    <div class="cat action">
                      <label>
                        <input type="checkbox" ng-attr-id="aftertomorrowslot{{$index}}" name="aftertomorrowslot" ng-value="data.slot_start_time" ng-disabled="data.availability === 'no'" ng-model="aftertomorrowslot" ng-click="onchangeAfterTomorrow()"><span>{{data.slot_start_time | showtime}} - {{data.slot_end_time | showtime}}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div style="border-bottom: 1px solid #ddd; margin: 10px 20px"></div>
        <div class="card-body p-0">
          <h4 class="adventis px-4 mt-3">Choose Reason</h4>
          <div class="my-3 px-4">
            <div class="row">
              <div class="col" ng-repeat="data in reasonList">
                <div class="reason reason-action">
                  <label>
                    <input type="radio" ng-attr-id="reason{{$index}}" name="reason" ng-value="data.category_id" ng-model="reason"><span>{{ data.category_title }}</span>
                  </label>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="card-footer d-flex flex-row-reverse">
          <button class="btn border-dark text-light rounded-0" style="padding: 10px 30px; background-color: #ed1c24;" type="button" ng-click="sendBooking()">Submit</button>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("./includes/function.php") ?>
<script>
  var today = new Date();
  var chosen_date = moment(new Date()).format("YYYY-MM-DD");
  document.getElementById("chosendate").value = chosen_date;

  app.filter("dates", function($sce) {
    return function(input) {
      var today = new Date();
      var oriDate = new Date(input);
      var createdOn = new Date(input);
      var msInDay = 24 * 60 * 60 * 1000;

      createdOn.setHours(0, 0, 0, 0);
      today.setHours(0, 0, 0, 0);

      var diff = (+today - +createdOn) / msInDay;
      var str =
        dayStr(oriDate.getDay()) +
        ", " +
        oriDate.getDate() +
        "" +
        $sce.trustAsHtml(ordinalDate(oriDate.getDate()).sup()) +
        " " +
        monthStr(oriDate.getMonth() + 1);

      return $sce.trustAsHtml(str);
    };
  });

  app.filter("scheduled", function($sce) {
    return function(input) {
      var today = new Date();
      var oriDate = new Date(input);
      var createdOn = new Date(input);
      var msInDay = 24 * 60 * 60 * 1000;

      createdOn.setHours(0, 0, 0, 0);
      today.setHours(0, 0, 0, 0);

      var diff = (+today - +createdOn) / msInDay;
      var str =
        "Currently Scheduled: " + " " +
        oriDate.getDate() +
        "" +
        $sce.trustAsHtml(ordinalDate(oriDate.getDate()).sup()) +
        " " +
        monthStr(oriDate.getMonth() + 1) + " " + oriDate.getFullYear() + " " + formatAMPM(oriDate);

      return $sce.trustAsHtml(str);
    };
  });

  app.filter("showtime", function($filter, $sce) {
    return function(input) {
      var today = new Date();
      var oriDate = new Date(input);
      var createdOn = new Date(input);
      var msInDay = 24 * 60 * 60 * 1000;

      createdOn.setHours(0, 0, 0, 0);
      today.setHours(0, 0, 0, 0);

      var diff = (+today - +createdOn) / msInDay;
      var str = formatAMPM(oriDate);

      return $sce.trustAsHtml(str);
    };
  });

  app.controller("controller", function($scope, $http, $timeout, $sce) {

    $scope.selectedDate = chosen_date;
    $scope.todayDate = new Date().getTime();

    $scope.init = function() {
      $http.get("./api/api_booking.php", {
        params: {
          task: "GetBookingTime",
          chosen_date: chosen_date,
          sport_id: '<?= $_GET['sport'] ?>',
        },
      }).then(function(response) {
        var data = response.data;

        $('.table-date-time').css('display', 'block');
        $('.loader').css('display', 'none');

        for (var i = 0; i < data.chosenDate.length; i++) {
          const startDateIso = data.chosenDate[i].date + "T" + data.chosenDate[i].slot_start_time;
          const endDateIso = data.chosenDate[i].date + "T" + data.chosenDate[i].slot_end_time;
          data.chosenDate[i].slot_start_time = new Date(startDateIso);;
          data.chosenDate[i].slot_end_time = new Date(endDateIso);
        }

        for (var i = 0; i < data.chosenDatePlus1.length; i++) {
          const startDateIso = data.chosenDatePlus1[i].date + "T" + data.chosenDatePlus1[i].slot_start_time;
          const endDateIso = data.chosenDatePlus1[i].date + "T" + data.chosenDatePlus1[i].slot_end_time;
          data.chosenDatePlus1[i].slot_start_time = new Date(startDateIso);;
          data.chosenDatePlus1[i].slot_end_time = new Date(endDateIso);
        }

        for (var i = 0; i < data.chosenDatePlus2.length; i++) {
          const startDateIso = data.chosenDatePlus2[i].date + "T" + data.chosenDatePlus2[i].slot_start_time;
          const endDateIso = data.chosenDatePlus2[i].date + "T" + data.chosenDatePlus2[i].slot_end_time;
          data.chosenDatePlus2[i].slot_start_time = new Date(startDateIso);;
          data.chosenDatePlus2[i].slot_end_time = new Date(endDateIso);
        }

        $scope.list = data;
        $scope.getReason();

      }).catch(function(error) {
        console.error(error);
      });
    }

    $scope.getReason = function() {
      $http.get("./api/api_category.php", {
        params: {
          task: "GetCategory",
        },
      }).then(function(response) {
        var data = response.data;
        if (data.status === 0) {
          $scope.reasonList = data.record;
        } else {
          $scope.reasonList = [];
        }


      }).catch(function(error) {
        console.error(error);
      });
    }

    $scope.getNextDate = function() {
      var newDate = new Date(chosen_date).getTime() + (86400000 * 3);
      var date = new Date(newDate);

      chosen_date =
        date.getFullYear() +
        "-" +
        String((date.getMonth() + 1)).padStart(2, '0') +
        "-" +
        String(date.getDate()).padStart(2, '0');

      $scope.init();

    };

    $scope.onchangeDate = function() {
      $scope.selectedDate = document.getElementById("chosendate").value
      chosen_date = document.getElementById("chosendate").value;
      $scope.init();
    }

    $scope.onchangeToday = function() {
      const selectedToday = document.getElementsByName("todayslot");
      if (selectedToday.length > 0) {
        const slotArr = [];
        for (let i = 0; i < selectedToday.length; i++) {
          const slot = selectedToday[i];
          if (slot.checked) {
            const datetime = moment(new Date(slot.value)).format("YYYY-MM-DD HH:mm:Ss");
            const time = new Date(datetime).getHours();
            slotArr.push(time);
          }
        }

        for (let i = 0; i < slotArr.length - 1; i++) {
          if (slotArr[i] + 1 !== slotArr[i + 1]) {
            $scope.resetToday();
          }
        }
      }

      $scope.resetTomorrow();
      $scope.resetAfterTomorrow();
    }

    $scope.onchangeTomorrow = function() {
      const selected = document.getElementsByName("tomorrowslot");
      if (selected.length > 0) {
        const slotArr = [];
        for (let i = 0; i < selected.length; i++) {
          const slot = selected[i];
          if (slot.checked) {
            const datetime = moment(new Date(slot.value)).format("YYYY-MM-DD HH:mm:Ss");
            const time = new Date(datetime).getHours();
            slotArr.push(time);
          }
        }

        for (let i = 0; i < slotArr.length - 1; i++) {
          if (slotArr[i] + 1 !== slotArr[i + 1]) {
            $scope.resetTomorrow();
          }
        }
      }

      $scope.resetToday();
      $scope.resetAfterTomorrow();
    }

    $scope.onchangeAfterTomorrow = function() {
      const selected = document.getElementsByName("aftertomorrowslot");
      if (selected.length > 0) {
        const slotArr = [];
        for (let i = 0; i < selected.length; i++) {
          const slot = selected[i];
          if (slot.checked) {
            const datetime = moment(new Date(slot.value)).format("YYYY-MM-DD HH:mm:Ss");
            const time = new Date(datetime).getHours();
            slotArr.push(time);
          }
        }

        for (let i = 0; i < slotArr.length - 1; i++) {
          if (slotArr[i] + 1 !== slotArr[i + 1]) {
            $scope.resetAfterTomorrow();
          }
        }
      }

      $scope.resetTomorrow();
      $scope.resetToday();
    }

    $scope.resetToday = () => {
      const selected = document.getElementsByName("todayslot");
      if (selected.length > 0) {
        for (let i = 0; i < selected.length; i++) {
          const slot = selected[i];
          if (slot.checked) {
            slot.checked = false;
          }
        }
      }

    }

    $scope.resetTomorrow = () => {
      const selectedTomorrow = document.getElementsByName("tomorrowslot");
      if (selectedTomorrow.length > 0) {
        for (let i = 0; i < selectedTomorrow.length; i++) {
          const slot = selectedTomorrow[i];
          if (slot.checked) {
            slot.checked = false;
          }
        }
      }

    }

    $scope.resetAfterTomorrow = () => {
      const selectedAfterTomorrow = document.getElementsByName("aftertomorrowslot");
      if (selectedAfterTomorrow.length > 0) {
        for (let i = 0; i < selectedAfterTomorrow.length; i++) {
          const slot = selectedAfterTomorrow[i];
          if (slot.checked) {
            slot.checked = false;
          }
        }
      }
    }

    $scope.sendBooking = function() {
      const todayslot = document.getElementsByName("todayslot");
      const tomorrowslot = document.getElementsByName("tomorrowslot");
      const aftertomorrowslot = document.getElementsByName("aftertomorrowslot");
      const slotArr = [];

      if (todayslot.length > 0) {
        for (let i = 0; i < todayslot.length; i++) {
          const slot = todayslot[i];
          if (slot.checked) {
            const datetime = moment(new Date(slot.value)).format("YYYY-MM-DD HH:mm:Ss")
            slotArr.push(datetime);
          }
        }
      }

      if (tomorrowslot.length > 0) {
        for (let i = 0; i < tomorrowslot.length; i++) {
          const slot = tomorrowslot[i];
          if (slot.checked) {
            const datetime = moment(new Date(slot.value)).format("YYYY-MM-DD HH:mm:Ss")
            slotArr.push(datetime);
          }
        }
      }

      if (aftertomorrowslot.length > 0) {
        for (let i = 0; i < aftertomorrowslot.length; i++) {
          const slot = aftertomorrowslot[i];
          if (slot.checked) {
            const datetime = moment(new Date(slot.value)).format("YYYY-MM-DD HH:mm:Ss")
            slotArr.push(datetime);
          }
        }
      }

      if (slotArr.length == 0) {
        return alert("Please choose the booking slot");
      }

      const reason = document.getElementsByName("reason");
      let reasonval = 0;
      for (let i = 0; i < reason.length; i++) {
        const slot = reason[i];
        if (slot.checked) {
          reasonval = slot.value;
        }
      }

      if (Number(reasonval) === 0) {
        return alert("Please choose the reason");
      }

      $http.get("./api/api_booking.php", {
        params: {
          task: "InsertBooking",
          student_id: '<?= $_SESSION['student_id'] ?>',
          sport_id: '<?= $_GET['sport'] ?>',
          booking_slot: slotArr[0],
          booking_duration: slotArr.length * 60,
          category_id: reasonval
        }
      }).then(response => {
        const data = response.data;
        if (data.status === 0) {
          window.open("./mybooking.php", "_self");
          // location.reload();
        } else {
          alert(data.message);
        }
      })
    }

  });

  function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? "0" + minutes : minutes;
    var strTime = hours + ":" + minutes + " " + ampm;
    return strTime;
  }

  function monthStr(month) {
    switch (month) {
      case 1:
        return "Jan";
      case 2:
        return "Feb";
      case 3:
        return "Mar";
      case 4:
        return "Apr";
      case 5:
        return "May";
      case 6:
        return "Jun";
      case 7:
        return "Jul";
      case 8:
        return "Aug";
      case 9:
        return "Sep";
      case 10:
        return "Oct";
      case 11:
        return "Nov";
      case 12:
        return "Dec";
    }
  }

  function dayStr(day) {
    switch (day) {
      case 0:
        return "Sun";
      case 1:
        return "Mon";
      case 2:
        return "Tue";
      case 3:
        return "Wed";
      case 4:
        return "Thu";
      case 5:
        return "Fri";
      case 6:
        return "Sat";
    }
  }

  function ordinalDate(ordinal) {
    var s = ["th", "st", "nd", "rd"];
    var v = ordinal % 100;
    return (s[(v - 20) % 10] || s[v] || s[0]);
  }

  function getDates(input) {
    var today = new Date();
    var oriDate = new Date(input);
    var createdOn = new Date(input);
    var msInDay = 24 * 60 * 60 * 1000;

    createdOn.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    var diff = (+today - +createdOn) / msInDay;
    var str =
      dayStr(oriDate.getDay()) +
      ", " +
      oriDate.getDate() +
      "" +
      ordinalDate(oriDate.getDate()).sup() +
      " " +
      monthStr(oriDate.getMonth() + 1) +
      " " +
      oriDate.getFullYear();
    return str;
  }

  function getDateTime(input) {
    var today = new Date();
    var oriDate = new Date(input);
    var createdOn = new Date(input);
    var msInDay = 24 * 60 * 60 * 1000;

    createdOn.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    var diff = (+today - +createdOn) / msInDay;
    var str = formatAMPM(oriDate);

    return str;
  }

  function parseDate(input, format) {
    format = format || 'yyyy-mm-dd'; // default format
    var parts = input.match(/(\d+)/g),
      i = 0,
      fmt = {};
    // extract date-part indexes from the format
    format.replace(/(yyyy|dd|mm)/g, function(part) {
      fmt[part] = i++;
    });

    return new Date(parts[fmt['yyyy']], parts[fmt['mm']] - 1, parts[fmt['dd']]);
  }
</script>
<?php include("./includes/footer.php") ?>