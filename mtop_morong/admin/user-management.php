<?php
include '../config/connection.php';
include '../config/class.php';
$class = new Myclass;

$class->islogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "../config/link1.php"; ?>
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
              <h1 class="m-0">User Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Management</li>
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
                  <h3 class="card-title">User Table</h3>
                  <div class="card-tools">
                    <button class="btn btn-primary" id="btn-create-user"><i class="fa fa-pen-alt"> </i> Create New User</button>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-hover table-bordered text-nowrap m-0" id="usermanagementtable" width="100%">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th>Full Name</th>
                        <th>Position</th>
                        <th>Account Type</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="4">Data</td>
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

    <?php include "modal/user-management-modal.php"; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>

  </div>

  <?php include "../config/script1.php"; ?>
  <script type="text/javascript" src="js/user-table.js"></script>

</body>

</html>