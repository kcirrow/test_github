<?php

 
    header("X-Frame-Options: sameorigin");
    header("X-XSS-Protection: 1, mode=block");
    header("X-Content-Type-Options: nosniff");
    header("X-Permitted-Cross-Domain-Policies: none");
    header("Strict-Transport-Security: max-age=31536000, includeSubDomains, preload");
    header("Referrer-Policy: no-referrer-when-downgrade");
    header("Feature-Policy: camera 'none', fullscreen 'self', geolocation *, microphone 'self' https://epayment-uat.judiciary.gov.ph/*");
    header("Content-Security-Policy:  base-uri 'self';form-action 'self'; object-src 'none';");
    header("Expect-CT:  max-age=86400, enforce");
    
include '../../config/connection.php';
include '../../config/class.php';

$class = new myclass;
$class->islogged();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../dist/img/bgdasma.png" type="image/x-icon" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery.loadingModal.css" />
  <link rel="stylesheet" href="css/sweetalert2.css" />
  <link rel="stylesheet" href="css/fa-fontawesome.css" />
  <link rel="stylesheet" href="css/style.css" />
  <title>
    Morong | MTOPs
  </title>
  <style>
    .waitmodal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background-color: #848f89c4;
      background: rgba(255, 255, 255) url("../dist/img/bgcarmona.png") center no-repeat;
    }

    body.loading .waitmodal {
      overflow: hidden;
    }

    body.loading .waitmodal {
      display: block;
    }
  </style>

</head>


<body style="min-height: 542px;">
  <div class="container" id="root">
    <div class="form-container sign-up-container">
      <form class="pad" action="#">
        <img class="imgs" src="img/io2.png">
        <h1 class="hide" style="color: #2d2d2d;">Create Account</h1>
        <label>or use your email for registration</label>
        <div class="btnchange" style="display:flex;flex-direction: row;">
          <button class="ghost1" id="signIn">Sign In</button>
        </div>
      </form>
    </div>

    <div class="form-container sign-in-container">
      <form class="pad" action="../../config/includes.php?var=login" method="POST" id="si-submit">
        <img class="imgs" src="img/bgcarmona.png">
        <h1 class="hide" style="color: #2d2d2d;">Sign in</h1>
        <!-- <span>or use your account</span> -->
        <input class="bg" id="si-email" name="si-email" onchange="handleInput(this.value, this.id);" type="text" placeholder="Username" require />
        <input class="bg" id="si-password" name="si-password" onchange="handleInput(this.value, this.id);" type="password" placeholder="Password" require />
        <!-- <a href="login/forgot" style="font-size: 14px; margin: 5px;">Forgot your password?</a> -->
        <button type="submit">Sign In</button>
      </form>
    </div>


    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <form class="pad1" enctype="multipart/form-data" id="su-submit">
            <h1 class="hide">Sign Up</h1>
            <p id="sumsg">
              Please provide some information to proceed. Thank you!
            </p>
            <input class="bg full" id="su-fullname" onchange="handleInput(this.value, this.id);" type="text" placeholder="Full Name" required />
            <input class="bg" id="su-email" onchange="handleInput(this.value, this.id);" type="email" placeholder="Email" required />
            <input class="bg" id="su-password" onchange="handleInput(this.value, this.id);" type="password" placeholder="Password" required />
            <input class="bg" id="su-confirmpassword" onchange="handleInput(this.value, this.id);" type="password" placeholder="Confirm Password" required><span class="badge badge-danger navbar-badge" style="display: none;">password not match</span></input>
            <input class="bg" id="su-contact" onchange="handleInput(this.value, this.id);" type="number" placeholder="09XXXXXXXXX" required />
            <div class="form-group form-check">
              <label class="form-check-label" style="font-size: 14px; margin: 5px;">
                <input name="checkdp" class="form-check-input" type="checkbox"> I Agree to
                <a href="#" id="dataprivacy-btn" type="button" style="font-size: 14px; margin: 5px; color:#fff;">Data Privacy</a>
              </label>
            </div>
            <button type="submit" class="ghost" style="margin:5px;"> Submit</button>
          </form>
        </div>


        <div class="overlay-panel overlay-right">
          <h1 class="hide">Welcome to MTOPs</h1>
          <p>Motorcycle Tricycle Operator Permit System</p>
          <!--<button id="create-user">Sign Up</button>-->
        </div>
      </div>
    </div>
  </div>

  <div class="waitmodal" style="background-color: #ebeff0a3;"></div>
  <?php include_once "dataprivacy.php"; ?>
  <?php include_once "../modal/user-management-modal.php"; ?>
  <script src="js/main.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="source/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- <script src="source/login/js/jquery.min.js"></script> -->
  <script src="js/sweetalert2.js"></script>
  <!-- <script src="source/login/js/jquery.loadingModal.js"></script> -->
  <script type="text/javascript">
    $(document).ready(function() {
      var state = {};

      handleInput = function(x, y) {
        state[y] = x;
      }

      $("#dataprivacy-btn").on("click", function(e) {
        e.preventDefault();
        $("#dataprivacy").modal("show");
      });

      $("#su-password, #su-confirmpassword").on("keyup", function() {
        if ($("#su-password").val() == $("#su-confirmpassword").val()) {
          $('#su-confirmpassword').addClass('is-valid');
          $('#su-confirmpassword').removeClass('is-invalid');
          $('.badge').css('display', 'none');
        } else {
          $('#su-confirmpassword').addClass('is-invalid');
          $('#su-confirmpassword').removeClass('is-valid');
          $('.badge').removeAttr('style');
        }
        if ($("#su-password").val() == "" || $("#su-confirmpassword").val() == "") {
          $('#su-confirmpassword').removeClass('is-valid');
          $('#su-confirmpassword').removeClass('is-invalid');
        }
      })

      $("#si-submit").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: "../../config/includes.php?var=login",
          method: "POST",
          data: state,
          dataType: "JSON",
          success: function(e) {

            if (e.result) {
              Swal.fire({
                icon: 'success',
                title: "Hoooray!",
                text: e.msg
              });
              window.location.href = "<?php echo $class->base_url(); ?>" + e.location;
            } else {
              Swal.fire({
                icon: 'warning',
                title: "Opps!",
                text: e.msg
              });
            }
          }
        });
      });
    });


    // eto ay para sa loader
  </script>

  <script>
    // function showModal() {
    //   $('body').loadingModal({
    //     text: 'Showing loader animations...'
    //   });

    //   var delay = function(ms) {
    //     return new Promise(function(r) {
    //       setTimeout(r, ms)
    //     })
    //   };
    //   var time = 1000;

    //   delay(time)

    //     .then(function() {
    //       $('body').loadingModal('animation', 'wanderingCubes').loadingModal('backgroundColor', 'green');
    //       return delay(time);
    //     })
    //     .then(function() {
    //       $('body').loadingModal('color', 'white').loadingModal('text', 'Processing ...').loadingModal('backgroundColor', 'gray');
    //       return delay(time);
    //     })
    //     .then(function() {
    //       $('body').loadingModal('animation', 'foldingCube');
    //       return delay(time);
    //     })
    //     .then(function() {
    //       $('body').loadingModal('color', 'white').loadingModal('text', 'Done!').loadingModal('backgroundColor', 'yellow');
    //       return delay(time);
    //     })
    //     .then(function() {
    //       $('body').loadingModal('hide');
    //       return delay(time);
    //     })
    //     .then(function() {
    //       $('body').loadingModal('destroy');
    //     });
    // }

    $body = $("body");
    $(document).on({
      ajaxStart: function() {
        $body.addClass("loading");
      },
      ajaxStop: function() {
        $body.removeClass("loading");
      }
    });
  </script>
</body>

</html>