<?php include("./includes/header.php") ?>

<div id="root" ng-controller="controller" ng-init="init()">

  <section class="other">
    <div class="text">
      <span class="title text-center">attention</span>
      <span class="desc">instruction</span>
    </div>
    <div class="backdrop"></div>
    <?php include("./includes/divider.php") ?>
  </section>

  <section class="vh-100 position-relative" style="background-color: #fff; padding: 100px 0;">
    <div>
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
    </div>

  </section>

</div>

<?php include("./includes/function.php") ?>
<?php include("./includes/footer.php") ?>