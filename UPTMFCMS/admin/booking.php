<?php include('./includes/header.php')  ?>

<div class="body-wrapper" ng-controller="myCtrl" ng-init="init()" id="root">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Booking</h5>
            <div id="grid" class="ag-theme-quartz" style="height: 70vh"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('./includes/function.php') ?>

<script type="text/javascript">
  app.controller("myCtrl", function myCtrl($scope, $http, $timeout) {

    var gridApi;
    var eGridDiv = document.querySelector('#grid');

    var columnDefs = [{
        headerName: "No",
        headerClass: "ag-header-center",
        cellClass: "ag-cell-center",
        maxWidth: 100,
        cellRenderer: params => {
          if (params.data) {
            return params.rowIndex + 1;
          }
        }
      },
      {
        headerName: "Student Name",
        field: "student_name",
        wrapText: true,
        autoHeight: true,
      },
      {
        headerName: "Sports",
        field: "sport_name",
        wrapText: true,
        autoHeight: true,
        maxWidth: 150,
      },
      {
        headerName: "Reason",
        wrapText: true,
        autoHeight: true,
        maxWidth: 200,
        field: "category_title"
      },
      {
        headerName: "Booking Slot",
        maxWidth: 250,
        field: "booking_slot",
        cellRenderer: params => {
          if (params.data) {
            const newDate = new Date(params.data.booking_slot);
            const momentDate = moment(newDate).format("LLL")
            return momentDate;
          }
        }
      },
      {
        headerName: "Booking Duration",
        maxWidth: 200,
        headerClass: "ag-header-center",
        cellClass: "ag-cell-center",
        field: "booking_duration",
        cellRenderer: params => {
          if (params.data) {
            return `${params.data.booking_duration / 60} hours`
          }
        }
      },
      {
        headerName: "Status",
        headerClass: "ag-header-center",
        cellClass: "ag-cell-center",
        maxWidth: 150,
        cellRenderer: params => {

          var status = params.data.booking_status === 'pending' ? 'Pending' : params.data.booking_status === 'confirm' ? 'Confirmed' : params.data.booking_status === 'reject' ? 'Rejected' : 'Cancelled';
          var statusColor = params.data.booking_status === 'pending' ? '' : params.data.booking_status === 'confirm' ? 'green' : params.data.booking_status === 'reject' ? 'red' : 'purple';
          var element = `
            <div class="ui ${statusColor} tiny label">${status}</div>
          `;

          return element;
        }
      },
      {
        headerName: "Action",
        headerClass: "ag-header-center",
        cellClass: "ag-cell-center",
        maxWidth: 100,
        cellRenderer: params => {
          if (params.data.booking_status === 'pending') {
            var element = `
              <button class="btn btn-success btn-sm" onclick="changeStatus(${params.data.booking_id}, 'confirm')">
                <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" height="12" width="12" viewBox="0 0 448 512"><!--!Font Awesome Pro 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc.--><path d="M443.3 100.7c6.2 6.2 6.2 16.4 0 22.6l-272 272c-6.2 6.2-16.4 6.2-22.6 0l-144-144c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L160 361.4 420.7 100.7c6.2-6.2 16.4-6.2 22.6 0z"/></svg>            
              </button>

              <button class="btn btn-danger btn-sm me-1" onclick="changeStatus(${params.data.booking_id}, 'reject')">
                <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" height="12" width="12" viewBox="0 0 384 512"><!--!Font Awesome Pro 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc.--><path d="M380.2 58.3c5.7-6.7 4.9-16.8-1.9-22.5s-16.8-4.9-22.6 1.9L192 231.2 28.2 37.7c-5.7-6.7-15.8-7.6-22.5-1.9s-7.6 15.8-1.9 22.5L171 256 3.8 453.7c-5.7 6.7-4.9 16.8 1.9 22.6s16.8 4.9 22.5-1.9L192 280.8 355.8 474.3c5.7 6.7 15.8 7.6 22.6 1.9s7.6-15.8 1.9-22.6L213 256 380.2 58.3z"/></svg>
              </button>
            `;

            return element;
          }
        }
      },
    ];

    var gridOptions = {
      columnDefs: columnDefs,
      defaultColDef: {
        flex: 1,
        sortable: false,
        resizable: false,
        filter: false
      },
      pagination: true,
      rowSelection: 'single',
      rowHeight: 60
    };

    gridApi = agGrid.createGrid(eGridDiv, gridOptions);

    $scope.init = () => {
      $http.get('../api/api_booking.php', {
        params: {
          task: "GetBooking"
        }
      }).then(response => {
        var data = response.data;
        $scope.sales = data;
        if (data.status === 0) {
          gridApi.setGridOption('rowData', data.record);
        } else {
          gridApi.setGridOption('rowData', []);
        }
      })
    }

    $scope.changeStatus = function(id, status) {
      $http.get('../api/api_booking.php', {
        params: {
          task: "UpdateBooking",
          booking_id: id,
          booking_status: status
        }
      }).then(response => {
        var data = response.data;
        if (data.status == 0) {
          location.reload();
        } else {
          alert(data.message);
        }
      })
    }
  });

  const changeStatus = (id, status) => {
    var ang = angular.element($('#root')).scope();
    ang.changeStatus(id, status);
  }
</script>

<?php include('./includes/footer.php') ?>