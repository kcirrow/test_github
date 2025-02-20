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
              <h1 class="m-0">Driver's Permit <p style="display: inline-block;" id="displayStatus"></p>
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Driver's Permit</li>
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
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-stretch flex-column">
                    <div class="card d-flex flex-fill">
                      <div class="card-header text-muted border-bottom-0">
                        Operator Information
                      </div>
                      <div class="card-body pt-0">
                        <div class="row">
                          <div class="col-5 text-center">
                            <img src="../dist/img/operator.png" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid" id="form-operatorimg">
                          </div>
                          <div class="col-7">
                            <h2 class="lead"><b id="form-operatorname">------------------------</b></h2>
                            <p class="text-muted text-sm" id="form-operatorid"></p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                                <p id="form-operatoraddress">N/A</p>
                              </li>
                              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                <p id="form-operatorcontact">N/A</p>
                              </li>
                            </ul>
                          </div>

                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="text-right">
                          <button id="btn-modal-operator-view" class="btn btn-sm btn-primary">
                            <i class="fas fa-user"></i> View Profile
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex align-items-stretch flex-column">
                    <div class="card d-flex flex-fill">
                      <div class="card-header text-muted border-bottom-0">
                        Driver Information
                      </div>
                      <div class="card-body pt-0">
                        <div class="row">
                          <div class="col-5 text-center">
                            <img src="../dist/img/driver.png" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid" id="form-driverimg">
                          </div>
                          <div class="col-7">
                            <h2 class="lead"><b id="form-drivername">------------------------</b></h2>
                            <p class="text-muted text-sm" id="form-driverid"></p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                                <p id="form-driveraddress">N/A</p>
                              </li>
                              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                <p id="form-drivercontact">N/A</p>
                              </li>
                            </ul>
                          </div>

                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="text-right">
                          <button class="btn btn-sm bg-teal" id="btn-modal-driver">
                            <i class="fas fa-plus"></i>
                          </button>
                          <button id="btn-modal-driver-view" class="btn btn-sm btn-primary">
                            <i class="fas fa-user"></i> View Profile
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Motor Information</h3>
                      <div class="card-tools">
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <p>Motor ID: <label id="form-motorid"></label></p>
                          <p>TODA: <label id="form-motortoda"></label></p>
                          <p>Make: <label id="form-motormake"></label></p>
                          <p>Chassis #: <label id="form-motorchassis"></label></p>
                          <p>Engine #: <label id="form-motorengine"></label></p>
                          <p>Plate #: <label id="form-motorplate"></label></p>
                        </div>
                        <div class="col-md-6  ">
                          <p>MTOP #: <label id="form-motormtop"></label></p>
                          <p>TDP #: <label id="form-drivertdp"></label></p>
                          <p>Last Renew: <label id="form-lastrenew"></label></p>
                          <p>TR-CODE: <label id="form-trcode"></label></p>
                          <p>
                            TDP Expiration:
                            <input type="date" class="form-control" name="form-tdpexpdt" id="form-tdpexpdt">
                          </p>
                          <p>
                            Application Year:
                            <select class="form-control" id="form-applicationyear">
                              <option value="2021">2021</option>
                            </select>
                          <p>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="text-right">
                        <button class="btn btn-sm bg-teal" id="btn-modal-motor">
                          <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-primary" id="btn-modal-motor-view">
                          <i class="fas fa-user"></i> View Motor
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button class="btn btn-primary" id="btn-submit-driverpermit">Submit Application</button>
                      <button class="btn btn-success" id="btn-driver-assessment">Assess</button>
                      <button class="btn btn-info" id="btn-driver-release">Release</button>
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
    <?php include "modal/operator-modal.php"; ?>
    <?php include "modal/driver-modal.php"; ?>
    <?php include "modal/motor-modal.php"; ?>
    <?php include "modal/assessment-modal.php"; ?>
    <?php include "modal/release-modal.php"; ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>

  </div>

  <?php include "../config/scripts.php"; ?>
  <script type="text/javascript" src="js/driverspermit-form.js"></script>

</body>

</html>