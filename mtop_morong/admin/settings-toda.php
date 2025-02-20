<?php
include '../config/connection.php';
include '../config/class.php';
$class = new Myclass;

$class->islogin();

$coke = $class->getJunjiito();
                
if ($coke['sett_toda'] == 0) {
    
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
              <h1 class="m-0">TODA</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">TODA</li>
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
                  <h3 class="card-title">TODA Table</h3>
                </div>
                <div class="card-body">
                  <div id="div-settings-toda-table">
                    <button id="btn-settings-toda-create" class="btn btn-primary float-right">Add TODA</button>
                    <table class="table table-hover table-bordered text-nowrap m-0" id="settingstodatable" width="100%">
                      <h1>carlo</h1>
                      <thead>
                        <tr>
                          <th>Action</th>
                          <th>TODA Code</th>
                          <th>TODA Route</th>
                          <th>TODA Remarks</th>
                          <th>Franchise Allowed</th>
                          <th>Franchise Left</th>
                          <th>Range</th>
                          <th width="10%">Active Franchise as of (<?php echo date("M d, Y"); ?>)</th>
                          <th>President</th>
                          <th>Contact No.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="5">No Data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div id="div-settings-toda-form" style="display: none">
                    <form action="#" method="POST" id="toda-form-submit">
                      <div class="row">
                        <div class="col-md-3">
                          <label>TODA Code</label>
                          <input type="text" class="form-control" name="tcode" id="tcode">
                        </div>
                        <div class="col-md-5">
                          <label>TODA Route</label>
                          <input type="text" class="form-control" name="troute" id="troute">
                        </div>
                        <div class="col-md-4">
                          <label>TODA Remarks</label>
                          <input type="text" class="form-control" name="tremarks" id="tremarks">
                        </div>
                        <div class="col-md-4">
                          <label>President</label>
                          <input type="text" class="form-control" name="tpres" id="tpres">
                        </div>
                        <div class="col-md-4">
                          <label>Contact No:</label>
                          <input type="text" class="form-control" name="tcontactno" id="tcontactno">
                        </div>
                        <div class="col-md-4">
                          <label>TEST</label>
                          <input type="text" class="form-control" name="ttest" id="ttest">
                        </div>
                      </div>
                    </form>
                    <br>
                    <div class="float-right">
                      <button class="btn btn-danger float" id="btn-toda-back">Back</button>
                      <button class="btn btn-success" id="btn-toda-save">Save</button>
                      <button class="btn btn-success" id="btn-toda-edit">Save Changes</button>
                    </div>
                  </div>

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
  <script type="text/javascript" src="js/settings-toda.js"></script>

</body>

</html>
