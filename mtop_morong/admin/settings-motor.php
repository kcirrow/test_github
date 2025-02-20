<?php
include '../config/connection.php';
include '../config/class.php';
$class = new Myclass;

$class->islogin();

$coke = $class->getJunjiito();
                
if ($coke['sett_motor'] == 0) {
    
    echo '<script>document.addEventListener("DOMContentLoaded", function() { Swal.fire({'.
      'icon: "warning",'.
      'text: "You are not authorzied to access this page. The system will redirect you to dashboard in a sec.",'.
      'title: "Warning!",'.
     ' showDenyButton: false,'.
     ' confirmButtonText: "Ok",'.
    '}).then((result) => {'.
      'if (result.isConfirmed) {'.
       'window.location.href = "/mtop_morong/admin/dashboard.php";'.
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
              <h1 class="m-0">Motors</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">Motors</li>
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
                  <h3 class="card-title">Motor Table</h3>
                </div>
                <div class="card-body">
                  <div id="div-settings-motor-table">
                    <button id="btn-settings-motor-create" class="btn btn-primary float-right">Create Motor</button>
                    <table class="table table-responsive table-hover table-bordered text-nowrap m-0" id="settingsmotortable" width="100%">
                      <thead>
                        <tr>
                          <th>Action</th>
                          <th>Motor ID</th>
                          <th>Operator ID</th>
                          <th>Operator</th>
                          <th>Driver</th>
                          <th>TODA</th>
                          <th>Engine #</th>
                          <th>Chassis #</th>
                          <th>Last Renew</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="5">No Data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div id="div-settings-motor-form" style="display: none;">
                      <form action="#" method="POST" id="motor-form-submit">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="../dist/img/operator.png" id="moper-img-alt" name="moper-img-alt" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid">
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span style="color:red; font-size:15px;">* </span>
                                        <label>Operator Code</label>
                                        <div class="form-group">
                                            <input type="text" id="mopcode" name="mopcode" class="form-control" readonly required>
                                        </div>
                                   </div>
        
                                   <div class="col-md-8">
                                        <label>Full Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="mname" id="mname" readonly>
                                        </div>
                                   </div>
                                   
                                   <div class="col-md-10">
                                        <label>Address</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="maddress" id="maddress" readonly>
                                        </div>
                                   </div>
        
                                   <div class="col-md-2">
                                        <br>
                                        <button class="btn btn-info btn-block" id="btn-motor-operator" type="button"><i class="fa fa-search"></i></button>
                                  </div>
                                  
                                </div>
                            </div>
                           
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Motor ID: </h5>
                                <h5 id="mid">xxxx</h5>
                                <label>Body #</label>
                                <input type="text" class="form-control" name="mbody" id="mbody" >
                                  <!-- <input type="text" class="form-control" name="mbody" id="mbody" readonly>-->
                                <label>Franchise #</label>
                                <input type="text" class="form-control" name="mmtop" id="mmtop" >
                                 <!--<input type="text" class="form-control" name="mmtop" id="mmtop" disabled>-->
                                <span style="color:red; font-size:15px;">* </span>
                                <label>TODA</label>
                                <select class="form-control" id="mtoda" name="mtoda" required>
                                  <option selected disabled>Select TODA</option>
                                </select>
                                <span style="color:red; font-size:15px;">* </span>
                                <label>Make</label>
                                <select class="form-control" id="mmake" name="mmake">
                                    
                                    <?php
                                        $make = $class->motorMakeOption();
                                            echo "<option selected disabled>Select Make</option>";
                                        foreach ($make as $item) {
                                            echo "<option value='".$item['decription']."'>".$item['decription']."</option>";    
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <h5>Availablity: </h5>
                                <h5 id="mavailability">xxxx</h5>
                                <span style="color:red; font-size:15px;">* </span>
                                <label>Engine #</label>
                                <input type="text" class="form-control" name="mengine" id="mengine" required>
                                <span style="color:red; font-size:15px;">* </span>
                                <label>Chassis #</label>
                                <input type="text" class="form-control" name="mchassis" id="mchassis" required>
                                <label>Year Model</label>
                                <input type="text" class="form-control" name="myrmodel" id="myrmodel" required>
                                <label>Motor Color</label>
                                <input type="text" class="form-control" name="mcolor" id="mcolor" >
                                <label>Date Expired</label>
                                <input type="date" class="form-control" name="mexpired" id="mexpired">
                              </div>
                            <div class="col-md-4">
                                <h5>MTP Year: </h5>
                                <h5 id="mmtpyr">xxxx</h5>
                                <label>Municipal Plate #</label>
                                <input type="text" class="form-control" name="mmunplateno" id="mmunplateno">
                                <span style="color:red; font-size:15px;">* </span>
                                <label>LTO Plate #</label>
                                <input type="text" class="form-control" name="mplate" id="mplate" required>
                                <label>LTO Agency</label>
                                <select class="form-control" id="magency" name="magency" required>
                                    <?php
                                        $lto = $class->ltoOption();
                                            // echo "<option selected disabled>Select LTO Agency</option>";
                                        foreach ($lto as $item) {
                                            echo "<option value='".$item['nm']."'>".$item['nm']."</option>";    
                                        }
                                    ?>
                                </select>
                                <span style="color:red; font-size:15px;">* </span>
                                <label>MV #</label>
                                <input type="text" class="form-control" name="mmvno" id="mmvno" required>
                                <label>Plate Color</label>
                                <select class="form-control" name="mplatecolor" id="mplatecolor" required>
                                    <?php
                                        $pkulay = $class->platekulayOption();
                                            echo "<option selected disabled>Select Plate Color</option>";
                                        foreach ($pkulay as $item) {
                                            echo "<option value='".$item['platekulay']."'>".$item['platekulay']."</option>";    
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-2" style="padding-top: 20px">
                                <input type="checkbox" class="custom-control-input orcr-switch" name="orcr-name-switch" id="orcr-name-switch">
                                <label class="custom-control-label" for="orcr-name-switch">ORCR not owned?</label>
                            </div>
                            <div class="col-md-5">
                                <span style="color:red; font-size:15px;">* </span>
                                <label>Cert. of Reg.</label>
                                <input type="text" class="form-control" name="mcert" id="mcert" required>
                            </div>
                            <div class="col-md-5">
                                <label>Date Issued</label>
                                <input type="date" class="form-control" name="mdtissue" id="mdtissue">
                            </div>
                        </div>
                        <div class="row">
                    <div class="col-md-6">
                        <label>ORCR #</label>
                        <input type="text" class="form-control" name="morcr" id="morcr">
                    </div>
                    <div class="col-md-6">
                        <label>ORCR Date Issued</label>
                        <input type="date" class="form-control" name="morcrdate" id="morcrdate">
                    </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>ORCR registered name:</label>
                                <input type="text" class="form-control" name="morcrname" id="morcrname" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Remarks</label>
                                <input type="text" class="form-control" name="mremarks" id="mremarks">
                            </div>
                        </div>
                      </form>
                      <br>
                      <div class="float-right">
                        <button class="btn btn-danger float" id="btn-motor-back">Back</button>
                        <button class="btn btn-success" id="btn-motor-save">Save</button>
                        <button class="btn btn-success" id="btn-motor-edit">Save Changes</button>
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
    <?php include "modal/motor-operator-search.php"?>
    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>

  </div>

  <?php include "../config/scripts.php"; ?>
  <script type="text/javascript" src="js/settings-motor.js"></script>

</body>

</html> 