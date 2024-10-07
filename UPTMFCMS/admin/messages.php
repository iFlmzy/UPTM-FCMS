<?php include('./includes/header.php')  ?>

<div class="body-wrapper" ng-controller="myCtrl" ng-init="init()" id="root">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Message List</h5>
            <div id="grid" class="ag-theme-quartz" style="height: 60vh"></div>
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
        maxWidth: 70,
        cellRenderer: params => {
          if (params.data) {
            return params.rowIndex + 1;
          } else {
            return '<img src="https://www.ag-grid.com/example-assets/loading.gif">';
          }
        }
      },
      {
        headerName: "Student Name",
        field: "name",
      },
      {
        headerName: "Student Email",
        field: "email",
      },
      {
        headerName: "Messages",
        field: "message",
      },
      {
        headerName: "Created",
        headerClass: "ag-header-center",
        cellClass: "ag-cell-center",
        maxWidth: 150,
        cellRenderer: params => {
          if (params.data) {
            return datetime(params.data.date_time_create);
          }
        }
      }
    ];

    var gridOptions = {
      columnDefs: columnDefs,
      defaultColDef: {
        flex: 1,
        sortable: false,
        resizable: false,
        filter: false
      },
      rowSelection: 'single',
      rowHeight: 60
    };

    gridApi = agGrid.createGrid(eGridDiv, gridOptions);

    $scope.init = () => {
      $http.get('../api/api_contact.php', {
        params: {
          task: "GetMessage"
        }
      }).then(response => {
        var data = response.data;
        if (data.status == 0) {
          gridApi.setGridOption('rowData', data.record);
        } else {
          gridApi.setGridOption('rowData', []);
        }

      })
    }

    $scope.changeStatus = (id, status) => {
      const statusVal = Number(status) === 1 ? 0 : 1;
      $http.get('./assets/api/messages.php', {
        params: {
          task: "UpdateStatus",
          message_id: id,
          message_read: statusVal
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