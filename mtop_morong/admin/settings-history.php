<?php
include '../config/connection.php';
include '../config/class.php';
$class = new Myclass;

$class->islogin();

$coke = $class->getJunjiito();
                
if ($coke['sett_opdr'] == 0) {
    
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
              <h1 class="m-0">History</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">History</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="../dist/img/operator.png" alt="User profile picture" id="history-oper-img-alt">
                  </div>

                  <h3 class="profile-username text-center" id="history-operatorname">----------------</h3>

                  <p class="text-muted text-center">Operator</p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Gender</b> <label style="color: #50C7C7" class="float-right" id="history-gender">----</label>
                    </li>
                    <li class="list-group-item">
                      <b>Contact No</b> <label style="color: #50C7C7" class="float-right" id="history-contactno">----</label>
                    </li>
                  </ul>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#trails" data-toggle="tab">Activity</a></li>
                    <li class="nav-item"><a class="nav-link" href="#drivers" data-toggle="tab">Drivers</a></li>
                    <li class="nav-item"><a class="nav-link" href="#motors" data-toggle="tab">Motors</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="trails">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table text-nowrap" id="history-trail-table" width="100%">
                              <thead>
                                <tr>
                                  <td>Transaction Date</td>
                                  <td>Action Made</td>
                                  <td>Trans Details</td>
                                  <td>Action By</td>
                                  <td>PC-Name</td>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td colspan="5" class="text-center">No Data</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="drivers">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table text-nowrap" id="history-drivers-table" width="100%">
                              <thead>
                                <tr>
                                  <th>TR-CODE</th>
                                  <th>Driver's Name</th>
                                  <th>Motor ID</th>
                                  <th>Year</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td colspan="7" class="text-center">No Data</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="motors">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table text-nowrap" id="history-motors-table" width="100%">
                              <thead>
                                <tr>
                                  <th>Motor ID</th>
                                  <th>Franchise No</th>
                                  <th>TODA</th>
                                  <th>Engine</th>
                                  <th>Plate #</th>
                                  <th>Chassis</th>
                                  <th>Status</th>
                                  <th>Last Renew</th>
                                  <th>Franchise Exp</th>
                                  <th>Remarks</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td colspan="10" class="text-center">No Data</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                    <!-- <div class="tab-pane" id="applications">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table text-nowrap" id="history-app-table" width="100%">
                              <thead>
                                <tr>
                                  <th>TR-CODE</th>
                                  <th>Franchise No</th>
                                  <th>Operator</th>
                                  <th>Driver</th>
                                  <th>Motor</th>
                                  <th>Date Application</th>
                                  <th>Status</th>
                                  <th>OR #</th>
                                  <th>OR Date</th>
                                  <th>Remarks</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td colspan="10" class="text-center">No Data</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
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
  <script type="text/javascript" src="js/settings-history.js"></script>

</body>

</html>