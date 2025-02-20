<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EBPLS | Code Verification</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/bpl/source/login/css/sweetalert2.css" />

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/bpl/source/login/css/style.css" />
  <link rel="stylesheet" href="/bpl/source/login/css/jquery.loadingModal.css" />
  <link rel="stylesheet" href="/bpl/source/main1/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="shortcut icon" href="/bpl/source/login/img/sanrafael.png" type="image/x-icon" />
  <!-- Theme style -->
  <link rel="stylesheet" href="/bpl/source/main1/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
    </div>
    <!-- /.login-logo -->

    <!-- naglagay ako ng style sa dalawang div kase ayaw gumana nung border radius e. -->
    <div id="verifycard" class="card" style="border-radius: 20px;">
      <div class="card-body login-card-body text-center" style="border-radius: 20px;">
        <strong>Password Verification Code</strong>
        <p class="login-box-msg">Enter this verification code sent to your email and mobile number to change your password.</p>

        <div class="input-group">
          <input type="text" id="code" style="padding: 1.375rem 0.75rem !important; letter-spacing: 25px;" class="form-control" maxlength="6">
          <span class="input-group-append">
            <button type="button" id="submit-code" class="fas fa-check"></button>
          </span>
        </div>

        <!-- <p class="mt-3 mb-1">
        <a href="/bpl/login">Login</a>
      </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>

  </div>

  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="/bpl/source/main1/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/bpl/source/login/js/sweetalert2.js"></script>

  <script src="/bpl/source/main1/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/bpl/source/main1/dist/js/adminlte.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      var code = "";
      var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split("&"),
          sParameterName,
          i;

        for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split("=");

          if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ?
              true :
              decodeURIComponent(sParameterName[1]);
          }
        }
      };

      $("#submit-code").click(function() {
        $.ajax({
          url: "/bpladmin/login/validateForgotCode",
          method: "POST",
          data: {
            email: getUrlParameter("email"),
            code: $("#code").val()
          },
          dataType: "JSON",
          success: function(e) {
            Swal.fire({
              icon: "success",
              title: "Hooray!",
              text: "Please input a new password.",
              confirmButtonText: "Proceed",
            }).then((result) => {
              if (result.isConfirmed) {
                code = $("#code").val();
                if (e.bool) {
                  $("#verifycard").remove();
                  $("body").load("confirm_password", function() {
                    $("#newpass, #confirmpass").on("keyup", function() {
                      if ($("#newpass").val() == $("#confirmpass").val()) {
                        $('#confirmpass').addClass('is-valid');
                        $('#confirmpass').removeClass('is-invalid');
                        $('.badge').css('display', 'none');
                      } else {
                        $('#confirmpass').addClass('is-invalid');
                        $('#confirmpass').removeClass('is-valid');
                        $('.badge').removeAttr('style');
                      }
                      if ($("#newpass").val() == "" || $("#confirmpass").val() == "") {
                        $('#confirmpass').removeClass('is-valid');
                        $('#confirmpass').removeClass('is-invalid');
                      }
                    })

                    $("#newpass").keypress(function() {
                      $('#newpass').removeClass('is-invalid');
                    })

                    $("#btn-submit").click(function() {

                      if ($("#newpass , #confirmpass").val() == "" || $("#newpass , #confirmpass").val() == null) {
                        Swal.fire({
                          icon: "error",
                          title: "<strong style='color:#f27474;'>Missing fields</strong>",
                        });
                        $('#newpass').addClass('is-invalid');
                        $('#confirmpass').addClass('is-invalid');
                        return;
                      }

                      if ($("#newpass").val() != $("#confirmpass").val()) {
                        Swal.fire({
                          icon: "error",
                          title: "<strong style='color:#f27474;'>Password didn't match!</strong>",
                        });
                        return;
                      }

                      $.ajax({
                        url: "/bpladmin/login/changePasswordForgot",
                        method: "POST",
                        data: {
                          email: getUrlParameter("email"),
                          code: code,
                          newpass: $("#newpass").val()
                        },
                        dataType: "JSON",
                        success: function(e) {
                          Swal.fire({
                            icon: "success",
                            title: "Hooray!",
                            text: "Please sign in again.",
                            confirmButtonText: "Sign in",
                          }).then((result) => {
                            if (result.isConfirmed) {
                              location.href = "/bpladmin/login"
                            }
                          })
                        }
                      });
                    });
                  });
                } else {}
              }
            });


          }
        });
      });



    });
  </script>
</body>

</html>