<?php
include '../config/connection.php';
include '../config/class.php';
$class = new Myclass;

$class->islogin();
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
              <h1 class="m-0">Tricycle Franchise</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Tricycle Franchise</li>
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
                  <h3 class="card-title">Franchise Table</h3>
                  <div class="card-tools">
                    <button class="btn btn-primary" id="btn-apply-franchise"><i class="fa fa-pen-alt"> </i> Apply Franchise</button>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-responsive table-hover table-bordered text-nowrap m-0" id="franchisetable" width="100%">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th>TR-Code</th>
                        <th>Status</th>
                        <th>Transaction</th>
                        <th>Franchise #</th>
                        <th>Motor ID</th>
                        <th>Operator ID</th>
                        <th>Operator Name</th>
                        <th>Address</th>
                        <th>Make</th>
                        <th>Date/Time</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="10">No Display Data</td>
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
    <?php include "modal/assessment-modal.php"; ?>
    <?php include "modal/release-modal.php"; ?>
    <?php include "modal/inspection-modal.php"; ?>
    <?php include "modal/motor-operator-search.php"; ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>

  </div>

  <?php include "../config/scripts.php"; ?>
  <script type="text/javascript" src="js/franchise-table.js"></script>

</body>

</html>