<?php include('./includes/header.php')  ?>

<div class="body-wrapper" ng-controller="myCtrl" ng-init="init()" id="root">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-lg-12 mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"> <i class="fas fa-plus me-2"></i> Sport</button>
      </div>
      <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Sports</h5>
            <div id="grid" class="ag-theme-quartz" style="height: 60vh"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreate" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create Sport</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form" id="modalCreateForm" autocomplete="off" novalidate="novalidate">
          <div class="modal-body">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="create" name="create" placeholder="">
              <label for="create">Sport</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" ng-click="create()">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEdit" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Sport</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form" id="modalEditForm" autocomplete="off" novalidate="novalidate">
          <div class="modal-body">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="edit" name="edit" placeholder="">
              <label for="edit">Sport Name</label>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" ng-click="update()">Save Changes</button>
          </div>
        </form>
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
        headerName: "Sport Name",
        field: "sport_name",
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
      },
      {
        headerName: "Action",
        headerClass: "ag-header-center",
        cellClass: "ag-cell-center",
        maxWidth: 150,
        cellRenderer: params => {
          if (params.data) {
            var divElement = document.createElement('div');
            divElement.classList.add('d-flex', 'justify-content-center', 'align-items-center');

            var buttonEdit = document.createElement('button');
            buttonEdit.classList.add('btn', 'btn-primary', 'btn-sm');
            buttonEdit.innerHTML = '<i class="fas fa-pencil"></i>';
            buttonEdit.addEventListener('click', function() {
              $scope.openEdit(params.data);
            });

            var buttonDelete = document.createElement('button');
            buttonDelete.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
            buttonDelete.innerHTML = '<i class="fas fa-trash"></i>';
            buttonDelete.addEventListener('click', function() {
              $scope.delete(params.data);
            });

            divElement.appendChild(buttonEdit);
            divElement.appendChild(buttonDelete);

            return divElement;
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
      $http.get('../api/api_sports.php', {
        params: {
          task: "GetSports"
        }
      }).then(response => {
        var data = response.data;
        $scope.product_category = data;
        if (data.status === 0) {
          gridApi.setGridOption('rowData', data.record);
        } else {
          gridApi.setGridOption('rowData', []);
        }

      })
    }

    $scope.openEdit = (info) => {
      $scope.sportData = info;
      $('#edit').val(info.sport_name);
      $('#modalEdit').modal('show');
    }

    $scope.create = () => {

      var sport = $('#create').val();

      $http.get('../api/api_sports.php', {
        params: {
          task: "InsertSports",
          sport_name: sport,
        }
      }).then(response => {
        var data = response.data;
        if (data.status === 0) {
          $('#create').val('');
          location.reload();
        } else {
          alert(data.message)
        }
      })

    }

    $scope.update = () => {

      var sport = $('#edit').val();

      $http.get('../api/api_sports.php', {
        params: {
          task: "UpdateSports",
          sport_id: $scope.sportData.sport_id,
          sport_name: sport,
        }
      }).then(response => {
        var data = response.data;
        if (data.status === 0) {
          location.reload();
        } else {
          alert(data.message);
        }
      })
    }

    $scope.delete = (info) => {

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-danger me-2"
        },
        buttonsStyling: false
      });

      swalWithBootstrapButtons.fire({
        text: `Are you sure to delete "${info.sport_name}"? You won't be able to revert!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $http.get('../api/api_sports.php', {
            params: {
              task: "RemoveSports",
              sport_id: info.sport_id,
            }
          }).then(response => {
            var data = response.data;
            if (data.status === 0) {
              location.reload();
            } else {
              alert(data.message);
            }
          })
        }

      })
    }
  });
</script>

<?php include('./includes/footer.php') ?>