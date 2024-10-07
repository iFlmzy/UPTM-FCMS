<?php include("./includes/header.php") ?>

<div id="root" ng-controller="controller" ng-init="init()">

  <section class="other">
    <div class="text">
      <span class="title text-center">contact</span>
      <span class="desc">get in touch</span>
    </div>
    <div class="backdrop"></div>
    <?php include("./includes/divider.php") ?>
  </section>

  <section class="vh-100 position-relative" style="background-color: #fff; padding: 100px 0;">
    <div>
      <div class="row">
        <div class="col-lg-6">
          <div class="card rounded-0 border-0 h-100">
            <div class="card-body py-5">
              <h1 class="adventis ps-5">Get in touch</h1>
              <p class="ps-5 fs-5">Your email address will not be published. Required fields are marked *</p>
              <form class="px-5 mt-4" id="contactform">
                <div class="form-group mb-4">
                  <h5>Your Name *</h5>
                  <input type="text" id="name" name="name" class="form-control rounded-0" style="padding: 20px 10px;">
                </div>
                <div class="form-group mb-4">
                  <h5>Email Address *</h5>
                  <input type="email" id="email" name="email" class="form-control rounded-0" style="padding: 20px 10px;">
                </div>
                <div class="form-group mb-4">
                  <h5>Message *</h5>
                  <textarea class="form-control rounded-0" id="message" name="message" rows="5" style="resize: none;"></textarea>
                </div>
                <div class="d-inline-block py-3 px-5 text-uppercase border text-light" style="cursor: pointer; background-color: #2b5da2" ng-click="sendMessage()">Post message</div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-6 d-flex align-items-center justify-content-center position-relative">
          <?php include("./includes/divider.php") ?>
          <img src="./img/contact.jpg" alt="contact" style="width: 100%;">
        </div>
      </div>
    </div>

  </section>

</div>

<?php include("./includes/function.php") ?>

<script>
  app.controller("controller", function($scope, $http, $timeout, $sce) {


    $scope.sendMessage = (record) => {

      if (!($("#contactform").valid())) {
        return;
      }

      const name = $("#name").val();
      const email = $("#email").val();
      const message = $("#message").val();

      $http.get("./api/api_contact.php", {
        params: {
          task: "SendMessage",
          name: name,
          email: email,
          message: message,
        },
      }).then(function(response) {
        const data = response.data;
        if (data.status === 0) {
          alert("Thank you for contacting us, the message has been sent out. we will reply your message soon.");
          location.reload();
        } else {
          alert("Something wrong with your entry, please try again");
        }
      }).catch(function(error) {
        console.error(error);
      });
    }

  });

  $(document).ready(function() {
    $("#contactform").validate({
      rules: {
        name: {
          required: true
        },
        email: {
          required: true
        },
        message: {
          required: true
        },
      },
    });
  });
</script>
<?php include("./includes/footer.php") ?>