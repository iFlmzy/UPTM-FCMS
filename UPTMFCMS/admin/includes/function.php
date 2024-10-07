</div>
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/moment/moment.min.js"></script>
<script src="../vendor/popper/popper.min.js"></script>
<script src="../vendor/bootstrap/bootstrap.min.js"></script>
<script src="../vendor/fontawesome/fontawesome.min.js"></script>
<script src="../vendor/angular/angular.min.js"></script>
<script src="../vendor/angular/angular-animate.min.js"></script>
<script src="../vendor/angular/angular-sanitize.min.js"></script>
<script src="../vendor/angular/ui-bootstrap.min.js"></script>
<script src="../vendor/angular/xeditable.min.js"></script>
<script src="../vendor/sweetalert2/sweetalert2.min.js"></script>
<script src="../vendor/dropify/dropify.min.js"></script>
<script src="../vendor/apexchart/apexcharts.min.js"></script>
<script src="../vendor/justValidate/just-validate.min.js"></script>

<script src="./assets/js/main.js"></script>

<script>
  var app = angular.module('myapp', ['ui.bootstrap', 'ngSanitize', 'ngAnimate', 'xeditable']);

  function datetime(date) {
    const newDate = new Date(date);
    const momentDate = moment(newDate).format('ll');
    return momentDate;
  }

  function currency(data) {
    data = Number(data);

    const formattedAmount = data.toLocaleString("en-MY", {
      style: "currency",
      currency: "MYR",
    });

    return formattedAmount;
  }

  app.filter("currency", function() {
    return function(input) {
      var money = new Intl.NumberFormat("ms-MY", {
        style: "currency",
        currency: "MYR",
      }).format(input);

      return money;
    };
  });
</script>