<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password</title>
  <base href="<?php echo base_url(); ?>">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="source/main1/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="source/login/css/sweetalert2.css" />
  <link rel="stylesheet" href="source/login/css/jquery.loadingModal.css" />
  <link rel="stylesheet" href="source/login/css/style.css" />
  <link rel="stylesheet" href="source/main1/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="source/main1/dist/css/adminlte.min.css">
  <link rel="shortcut icon" href="source/login/img/sanrafael.png" type="image/x-icon" />
</head>
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
    background: rgba(255, 255, 255) url("source/main/img/load.gif") center no-repeat;
  }

  body.loading .waitmodal {
    overflow: hidden;
  }

  body.loading .waitmodal {
    display: block;
  }
</style>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
    </div>
    <!-- /.login-logo -->

    <!-- naglagay ako ng style sa dalawang div kase ayaw gumana nung border radius e. -->
    <div class="card" style="border-radius: 20px;">
      <div class="card-body login-card-body" style="border-radius: 20px;">
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        <div class="input-group mb-3">
          <input type="text" id="recovery-email" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button id="btn-req" class="btn btn-primary-xxx btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>

        <p class="mt-3 mb-1">
          <a href="login">Login</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <div class="waitmodal" style="background-color: #ebeff0a3;"></div>
  <!-- jQuery -->
  <script src="source/main1/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="source/main1/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="source/login/js/sweetalert2.js"></script>
  <script src="source/main1/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="source/main1/dist/js/adminlte.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#btn-req").click(function() {
        $.ajax({
          url: "login/sendEmailForgot",
          method: "POST",
          data: {
            email: $("#recovery-email").val()
          },
          dataType: "JSON",
          success: function(e) {
            Swal.fire({
              title: "Hooray!",
              text: "Verification Code was sent to your email and mobile number.",
              confirmButtonText: `Okay`,
              icon: "success",
            }).then((result) => {
              if (result.isConfirmed) {
                if (e.bool) {
                  location.href = "login/verify?email=" + $("#recovery-email").val();
                } else {}
              }
            })
          }
        });
      });
    });
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