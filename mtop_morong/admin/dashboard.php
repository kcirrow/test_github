<?php
include '../config/connection.php';
include '../config/class.php';
$class = new Myclass;

$class->islogin();

$fran = $class->dashboardcount();
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
              <h1 class="m-0">Dashboard </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
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
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-motorcycle" aria-hidden="true"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><?php echo date('Y'); ?> Collection</span>
                  <?php echo $fran['totamt']; ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-motorcycle"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><?php echo date('Y');  ?> Change Motor</span>
                  <?php echo $fran['cm']; ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Change Ownership</span>
                  <?php echo $fran['co']; ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

               <!-- /.col -->
               <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Change Driver</span>
                  <?php echo $fran['cd']; ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><?php echo date('Y'); ?> Dropping</span>
                  <?php echo $fran['drop']; ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-clipboard"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?php echo date('Y'); ?> NEW</span>
                  <?php echo $fran['newrenew']; ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-clipboard"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><?php echo date('Y'); ?> RENEW</span>
                  <?php echo $fran['renew']; ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
          <!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-7">
              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Recent Applications</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table text-nowrap" id="dashboardtable" width="100%">
                      <thead>
                        <tr>
                          <th>TR-Code</th>
                          <th>Name</th>
                          <th>Status</th>
                          <th>Application Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="4" class="text-center">No Recent Application</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Waiting List</h3>
                  <div class="card-tools">
                      <button class="btn btn-info btn-sm" id="open-wlist-modal"><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table text-nowrap" id="waitinglisttable" width="100%">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Name</th>
                          <th>Contact #</th>
                          <th>TODA</th>
                          <th>Status</th>
                          <th>Date Register</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="5" class="text-center">No one is waiting.</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <!-- /.card-footer -->
              </div>
            </div>
            <div class="col-md-5">
              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Expired Franchise</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table text-nowrap" id="dashexprdtable" width="100%">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Name</th>
                          <th>Franchise #</th>
                          <th>TODA</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="4" class="text-center">No Recent Application</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include_once 'modal/expfran-modal.php'; ?>
    <?php include_once 'modal/waitinglist-modal.php';?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>

  </div>

  <?php include "../config/scripts.php"; ?>
  <script type="text/javascript" src="js/dashboard.js"></script>
</body>

</html>