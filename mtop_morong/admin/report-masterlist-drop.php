<?php
include '../config/connection.php';
include '../config/class.php';
$class = new Myclass;

$class->islogin();

$coke = $class->getJunjiito();
                
if ($coke['rep_drop'] == 0) {
    
    echo '<script>document.addEventListener("DOMContentLoaded", function() { Swal.fire({'.
      'icon: "warning",'.
      'text: "You are not authorzied to access this page. The system will redirect you to dashboard in a sec.",'.
      'title: "Warning!",'.
     ' showDenyButton: false,'.
     ' confirmButtonText: "Ok",'.
    '}).then((result) => {'.
      'if (result.isConfirmed) {'.
       'window.location.href = "/mtop_carmona/admin/dashboard.php";'.
      '}'.
   ' });});</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "../config/links.php"; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <?php include "../config/topnav.php"; ?>

    <!-- Main Sidebar Container -->
    <?php include "../config/sidenav.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Masterlist Drop</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Report</li>
                <li class="breadcrumb-item active">Masterlist Drop</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Masterlist Drop Table</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                      <label style="padding-right: 5px">TODA: 
                       <select class="form-control" id="toda" name="toda" required>
                          <option selected disabled>Select TODA</option>
                        </select></label>
                    <label style="padding-right: 5px">From: <input type="date" class="form-control" id="datefrom"></label>
                    <label>To: <input type="date" class="form-control" id="dateto"></label>
                    <label class="cntrbtn"><button class="btn btn-info" id="btn-report-masterlist-drop-search">Search</button></label>
                  </div>
                  <table class="table table-responsive table-hover table-bordered text-nowrap m-0" id="drop-masterlist-table" width="100%">
                    <thead>
                      <tr>
                        <th>Body #</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Initial</th>
                        <th>Address</th>
                        <th>Make</th>
                        <th>Engine #</th>
                        <th>Chassis #</th>
                        <th>LTO Plate</th>
                        <th>TODA</th>
                        <th>Reason</th>
                        <th>Date Application</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="14">No Data</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>

  </div>

  <?php include "../config/scripts.php"; ?>
  <script type="text/javascript" src="js/report.js"></script>

</body>

</html>