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
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/bpladmin/source/main1/dist/css/adminlte.min.css">
</head>
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

      <form action="new-password.html" method="post">
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
      </form>

      <p class="mt-3 mb-1">
        <a href="/bpl/login">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/bpl/source/main1/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/bpl/source/main1/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/bpl/source/main1/dist/js/adminlte.min.js"></script>

<script type="text/javascript">
  $(document).ready(function (){
    $("#btn-req").click(function () {
      $.ajax({
        url: "",
        method: "POST",
        data: {email: $("#recovery-email").val()},
        dataType: "JSON",
        success: function (e) {
          console.log(e);
        }
      });
    });
  });
</script>
</body>
</html>
