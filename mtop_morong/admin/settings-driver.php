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
              <h1 class="m-0">Drivers</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">Drivers</li>
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
                  <h3 class="card-title">Driver Table</h3>
                </div>
                <div class="card-body">
                  <div id="div-settings-driver-table">
                    <button id="btn-settings-driver-create" class="btn btn-primary float-right">Create Driver</button>
                    <table class="table table-responsive table-hover table-bordered text-nowrap m-0" id="settingsdrivertable" width="100%">
                      <thead>
                        <tr>
                          <th>Action</th>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Contact #</th>
                          <th>Driver's Licence</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="5">No Data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div id="div-settings-driver-form" style="display: none">
                    <h3>Driver's Information</h3>
                    <form action="#" id="driver-form-submit" autocomplete="off">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Fullname</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dfirstname" id="dfirstname">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label>Middle Initial</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dmidinit" id="dmidinit">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label>Lastname</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dlastname" id="dlastname">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-1">
                          <label>Hse #</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dhse" id="dhse">
                          </div>
                        </div>
                        <div class="col-md-1">
                          <label>Blk #</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dblk" id="dblk">
                          </div>
                        </div>
                        <div class="col-md-1">
                          <label>Lot #</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dlot" id="dlot">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <label>Street</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dst" id="dst">
                          </div>
                        </div>

                        <div class="col-md-5">
                          <label>Subdivision</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dsubd" id="dsubd">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-4">
                          <label>Brgy.</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dbrgy" id="dbrgy">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <label>City/Municipal</label>
                          <div class="form-group">
                            <input type="text" class="form-control" value="Dasmarinas" name="dmun" id="dmun">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <label>Province</label>
                          <div class="form-group">
                            <input type="text" class="form-control" value="Cavite" name="dprov" id="dprov">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-3">
                          <label>Driver's Licence</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="ddrivlic" id="ddrivlic">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <label>License Expiration</label>
                          <div class="form-group">
                            <input type="date" class="form-control" name="ddrivissue" id="ddrivissue">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <label>Place Issued</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="ddrivplace" id="ddrivplace">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <label>Contact No</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dcontact" id="dcontact">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-4">
                          <label>Res. Cert. No</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dctc" id="dctc">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label>Issued On</label>
                          <div class="form-group">
                            <input type="date" class="form-control" name="dctcissue" id="dctcissue">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label>Issued At</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dctcplace" id="dctcplace">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <label>Remarks</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="dremarks" id="dremarks">
                          </div>
                        </div>
                      </div>

                    </form>
                    <div class="float-right">
                      <button class="btn btn-danger float" id="btn-driver-back">Back</button>
                      <button class="btn btn-success" id="btn-driver-save">Save</button>
                      <button class="btn btn-success" id="btn-driver-edit">Save Changes</button>
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
  <script type="text/javascript" src="js/settings-driver.js"></script>

</body>

</html>