<?php include('./includes/header.php') ?>

<style>
  .ag-header {
    border-bottom: 0px !important
  }

  .ag-root-wrapper {
    border: 0 !important;
  }

  .ag-row {
    border: 0 !important;

  }

  .ag-cell {
    display: flex !important;
    align-items: center !important;
    font-family: poppins, 'sans-serif' !important;
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

<div class="body-wrapper" ng-controller="myCtrl" ng-init="init()" id="root">
  <div class="container-fluid p-4">
    <div class="row">

      <div class="col-lg-12 mb-3">
        <div class="row">
          <div class="col-lg-6">
            <div class="card border-0 pb-0 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <p style="line-height: 1;">
                  <span class="card-title h3" style="color: #DD2F6E;">{{totalStudent}}</span> <br>
                  <span class="card-text">Student</span>
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Pro 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc.-->
                  <path fill="#DD2F6E" d="M320 128a96 96 0 1 0 -192 0 96 96 0 1 0 192 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM32 480H416c-1.2-79.7-66.2-144-146.3-144H178.3c-80 0-145 64.3-146.3 144zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z" />
                </svg>
              </div>
              <div id="line1"></div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card border-0 pb-0 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <p style="line-height: 1;">
                  <span class="card-title h3" style="color: #DD2F6E;">{{totalBooking}}</span> <br>
                  <span class="card-text">Booking</span>
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512"><!--!Font Awesome Pro 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc.-->
                  <path fill="#DD2F6E" d="M145.5 68c5.3-20.7 24.1-36 46.5-36s41.2 15.3 46.5 36c1.8 7.1 8.2 12 15.5 12h18c8.8 0 16 7.2 16 16v32H192 96V96c0-8.8 7.2-16 16-16h18c7.3 0 13.7-4.9 15.5-12zM192 0c-32.8 0-61 19.8-73.3 48H112C91.1 48 73.3 61.4 66.7 80H64C28.7 80 0 108.7 0 144V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V144c0-35.3-28.7-64-64-64h-2.7c-6.6-18.6-24.4-32-45.3-32h-6.7C253 19.8 224.8 0 192 0zM320 112c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32V144c0-17.7 14.3-32 32-32v16c0 17.7 14.3 32 32 32h96 96c17.7 0 32-14.3 32-32V112zM208 80a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zM171.3 235.3c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0L112 249.4 99.3 236.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l24 24c6.2 6.2 16.4 6.2 22.6 0l48-48zM192 272c0 8.8 7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm-32 96c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm-48 24a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                </svg>
              </div>
              <div id="line2"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100 border-0 pb-0 shadow-sm">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">Recent Messages</h5>
            <div id="gridMessages" style="height: 60vh" class="ag-theme-quartz"></div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100 border-0 pb-0 shadow-sm">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">Latest Booking</h5>
            <div class="ui divided items">
              <div class="item" ng-repeat="data in bookingList">
                <div class="middle aligned content">
                  <div class="header">{{data.student_name}} ({{data.duration}} hours)</div>
                  <div class="description" style="line-height: 1;">
                    <span>{{data.sport_name}}</span>
                  </div>
                  <div class="description d-flex justify-content-between mb-0" style="line-height: 1;">
                    <span>{{data.booking_slot |datetime}}</span>
                    <span>{{data.category_title}}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>
<?php include('./includes/function.php') ?>

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
  app.controller("myCtrl", function myCtrl($scope, $http, $timeout) {

    var grid = document.querySelector('#gridMessages');
    var gridColumn = [{
        headerName: "No",
        headerClass: "ag-center-header",
        cellClass: "ag-center-cell",
        field: "",
        maxWidth: 70,
        cellRenderer: params => {
          if (params) {
            return params.rowIndex + 1
          }
        }
      },
      {
        headerName: "Student Name",
        headerClass: "ag-font-header",
        cellClass: "ag-font-cell",
        field: "name",
        filter: true
      },
      {
        headerName: "Student Email",
        field: "email",
        headerClass: "ag-center-header",
        cellClass: "ag-center-cell",
      },
      {
        headerName: "Messages",
        field: "message",
        headerClass: "ag-center-header",
        cellClass: "ag-center-cell",
      },
    ];

    var gridOpts = {
      columnDefs: gridColumn,
      rowHeight: 70,
      defaultColDef: {
        flex: 1,
        resizable: false,
        sortable: false,
        filter: false
      }
    };

    let gridApi = agGrid.createGrid(grid, gridOpts);

    $scope.init = () => {
      $http.get('../api/api_dashboard.php', {
        params: {
          task: 'GetAnalytics'
        }
      }).then(response => {
        var data = response.data;
        $scope.totalStudent = data.student.reduce((sum, entry) => sum + entry.student_count, 0);
        $scope.totalBooking = data.booking.reduce((sum, entry) => sum + entry.booking_count, 0);

        var options = {
          series: [{
            name: 'Student',
            data: data.student.map(record => record.student_count)
          }],
          chart: {
            height: 100,
            type: 'area',
            sparkline: {
              enabled: true
            },
          },
          stroke: {
            width: 2,
            curve: 'smooth',
            colors: ['#ea4989']
          },
          xaxis: {
            type: 'datetime',
            categories: data.student.map(record => record.date),
            tickAmount: 10,
            labels: {
              formatter: function(value, timestamp, opts) {
                return opts.dateFormatter(new Date(timestamp), 'MMM yy')
              }
            }
          },
          colors: ['rgba(234, 73, 137, .13)'],
        };

        var options2 = {
          series: [{
            name: 'Booking',
            data: data.booking.map(record => record.booking_count)
          }],
          chart: {
            height: 100,
            type: 'area',
            sparkline: {
              enabled: true
            },
          },
          stroke: {
            width: 2,
            curve: 'smooth',
            colors: ['#ea4989']
          },
          xaxis: {
            type: 'datetime',
            categories: data.booking.map(record => record.date),
            tickAmount: 10,
            labels: {
              formatter: function(value, timestamp, opts) {
                return opts.dateFormatter(new Date(timestamp), 'MMM yy')
              }
            }
          },
          colors: ['rgba(234, 73, 137, .13)'],
        };

        new ApexCharts(document.querySelector("#line1"), options).render();
        new ApexCharts(document.querySelector("#line2"), options2).render();

        $scope.getMessage();
        $scope.getBooking();
      })
    }

    $scope.getMessage = () => {
      $http.get('../api/api_contact.php', {
        params: {
          task: 'GetMessageDashboard'
        }
      }).then(response => {
        const data = response.data;
        if (data.status === 0) {
          gridApi.setGridOption("rowData", data.record);
        } else {
          gridApi.setGridOption("rowData", []);
        }
      })
    }

    $scope.getBooking = () => {
      $http.get('../api/api_booking.php', {
        params: {
          task: 'DashboardBooking'
        }
      }).then(response => {
        const data = response.data;
        if (data.status === 0) {
          data.record.forEach(record => {
            record.duration = Number(record.booking_duration) / 60;
          });
          $scope.bookingList = data.record;
        } else {
          $scope.bookingList = [];
        }
      })
    }
  });
</script>
<?php include('./includes/footer.php') ?>