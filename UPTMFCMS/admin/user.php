<?php include('./includes/header.php')  ?>

<div class="body-wrapper" ng-controller="myCtrl" ng-init="init()" id="root">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-lg-12 mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"> <i class="fas fa-plus me-2"></i> Admin</button>
      </div>
      <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Admin</h5>
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
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create Admin</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form" id="modalCreateForm">
          <div class="modal-body">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="name" name="name" placeholder="">
              <label for="name">Admin Name</label>
            </div>
            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="">
              <label for="email">Admin Email</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="">
              <label for="password">Admin Password</label>
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
          }
        }
      },
      {
        headerName: "Admin Name",
        cellRenderer: params => {
          if (params.data) {
            return params.data.admin_name;
          }
        }
      },
      {
        headerName: "Admin Email",
        cellRenderer: params => {
          if (params.data) {
            return params.data.admin_email
          }
        }
      },
      {
        headerName: "Action",
        headerClass: "ag-header-center",
        cellClass: "ag-cell-center",
        maxWidth: 110,
        cellRenderer: params => {
          if (params.data) {
            var divElement = document.createElement('div');
            divElement.classList.add('d-flex', 'justify-content-center', 'align-items-center');
            var buttonDelete = document.createElement('button');
            buttonDelete.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
            buttonDelete.innerHTML = '<i class="fas fa-trash"></i>';
            buttonDelete.addEventListener('click', function() {
              $scope.delete(params.data);
            });

            divElement.appendChild(buttonDelete);

            return divElement;
          }
        }
      },
    ];

    var gridOptions = {
      columnDefs: columnDefs,
      defaultColDef: {
        flex: 1,
        sortable: false,
        filter: false,
        resizable: false

      },
      rowSelection: 'single',
      rowHeight: 60
    };

    gridApi = agGrid.createGrid(eGridDiv, gridOptions);

    $scope.init = () => {
      $http.get('../api/api_admin.php', {
        params: {
          task: "GetAdmin"
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

    $scope.create = () => {

      var name = $('#name').val();
      var email = $('#email').val();
      var password = $('#password').val();

      $http.get('../api/api_admin.php', {
        params: {
          task: "CreateAdmin",
          admin_name: name,
          admin_email: email,
          admin_password: password,
        }
      }).then(response => {
        var data = response.data;

        if (data.status === 0) {
          location.reload();
        } else {
          alert(data.message)
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
        text: `Are you sure to delete "${info.admin_name}"? You won't be able to revert!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $http.get('../api/api_admin.php', {
            params: {
              task: "RemoveAdmin",
              admin_id: info.admin_id,
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


    const createForm = new JustValidate('#modalCreateForm', {
      validateBeforeSubmitting: true,
    });

    createForm.onSuccess(event => {
      $scope.createUser();
    });

  });

  const changeStatus = (id, status) => {
    var ang = angular.element($('#root')).scope();
    ang.changeStatus(id, status);
  }
</script>

<?php include('./includes/footer.php') ?>