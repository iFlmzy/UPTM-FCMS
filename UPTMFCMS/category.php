<?php include("./includes/header.php") ?>
<div class="vh-100" style="margin-top: 100px;" id="root" ng-controller="controller" ng-init="init()">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <button class="btn btn-primary" ng-click="modalCreateCat()" data-bs-toggle="modal" data-bs-target="#modalCreateCat">Create Category</button>
      </div>
      <div class="col-lg-12">
        <div id="grid" style="height: 80vh;" class="ag-theme-quartz"></div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCreateCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Create Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="createcatform">
          <div class="modal-body">
            <div class="form-group">
              <label for="newcatname">Category Name</label>
              <input type="text" class="form-control" id="newcatname" name="newcatname" placeholder="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" ng-click="sendNewCat()">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEditCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Edit Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editcatform">
          <div class="modal-body">
            <div class="form-group">
              <label for="editcatname">Category Name</label>
              <input type="text" class="form-control" id="editcatname" name="editcatname" placeholder="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" ng-click="sendEditCat()">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>



<?php include("./includes/function.php") ?>

<script>
  app.controller("controller", function($scope, $http, $timeout, $sce) {
    var grid = document.querySelector('#grid');
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
        headerName: "Category Name",
        headerClass: "ag-font-header",
        cellClass: "ag-font-cell",
        field: "category_title",
        filter: true
      },
      {
        headerName: "",
        field: "",
        headerClass: "ag-center-header",
        cellClass: "ag-center-cell",
        cellRenderer: renderAction,
        pinned: 'right',
      }
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
      $http.get("./api/api_category.php", {
        params: {
          task: "GetCategory"
        }
      }).then(response => {
        const data = response.data;
        if (data.status === 0) {
          gridApi.setGridOption("rowData", data.record);
        } else {
          gridApi.setGridOption("rowData", []);
        }
      }).catch(error => {
        console.error(error);
      })
    };

    $scope.modalCreateCat = () => {
      $("#newcatname").val("");
    };

    $scope.modalEditCat = (record) => {
      $scope.catData = record;
      $("#editcatname").val(record.category_title);
      $("#modalEditCat").modal("show");
    };

    $scope.sendNewCat = () => {

      if (!($("#createcatform").valid())) {
        return;
      }

      const catname = $("#newcatname").val();
      $http.get("./api/api_category.php", {
        params: {
          task: "InsertCategory",
          category_title: catname
        }
      }).then(response => {
        const data = response.data;
        if (data.status === 0) {
          $scope.init();
          $("#modalCreateCat").modal("hide");
        } else {
          alert("Opps, Something error with your entry, please try again later.");
        }
      }).catch(error => {
        console.error(error);
      })
    };

    $scope.sendEditCat = (record) => {

      if (!($("#editcatform").valid())) {
        return;
      }

      const catname = $("#editcatname").val();
      $http.get("./api/api_category.php", {
        params: {
          task: "UpdateCategory",
          category_id: $scope.catData.category_id,
          category_title: catname
        }
      }).then(response => {
        const data = response.data;
        if (data.status === 0) {
          $scope.init();
          $("#modalEditCat").modal("hide");
        } else {
          alert("Opps, Something error with your entry, please try again later.");
        }
      }).catch(error => {
        console.error(error);
      })
    };

    $scope.sendDeleteCat = (record) => {
      if (confirm(`Are you sure you want to delete ${record.category_title}?`)) {
        $http.get("./api/api_category.php", {
          params: {
            task: "RemoveCategory",
            category_id: record.category_id
          }
        }).then(response => {
          const data = response.data;
          if (data.status === 0) {
            $scope.init();
          } else {
            alert("Opps, Something error with your entry, please try again later.");
          }
        }).catch(error => {
          console.error(error);
        });
      }
    };
  });

  function renderAction(params) {
    const data = encodeURIComponent(JSON.stringify(params.data));
    const button = document.createElement('button');
    button.classList.add('btn', 'btn-primary', 'btn-sm');
    button.innerHTML = 'Edit';
    button.setAttribute('onclick', `editData('${data}')`);

    const button2 = document.createElement('button');
    button2.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
    button2.innerHTML = 'Delete';
    button2.setAttribute('onclick', `deleteData('${data}')`);

    const template = document.createElement('div');
    template.appendChild(button);
    template.appendChild(button2);
    return template.innerHTML;
  };

  function editData(data) {
    const recordData = JSON.parse(decodeURIComponent(data));
    var ang = angular.element($('#root')).scope();
    ang.modalEditCat(recordData);
  };

  function deleteData(data) {
    const recordData = JSON.parse(decodeURIComponent(data));
    var ang = angular.element($('#root')).scope();
    ang.sendDeleteCat(recordData);
  };

  $(document).ready(function() {
    $("#createcatform").validate({
      rules: {
        newsportname: {
          required: true
        },
      },
    });

    $("#editcatform").validate({
      rules: {
        newsportname: {
          required: true
        },
      },
    });
  });
</script>