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
              <h1 class="m-0">Change Status</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">Change Status</li>
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
                </div>
                <div class="card-body">
                  <div id="div-settings-motor-table">
                    <!-- <button id="btn-settings-motor-create" class="btn btn-primary float-right">Create Motor</button> -->
                    <table class="table table-responsive table-hover table-bordered text-nowrap m-0" id="settingsstatustable" width="100%">
                      <thead>
                        <tr>
                        <th>Action</th>
                        <th>TR-Code</th>
                        <th>Status</th>
                        <th>Transaction</th>
                        <th>Franchise #</th>
                        <th>Full Name</th>
                        <th>Motor ID</th>
                        <th>Operator ID</th>
                        <th>Driver Name</th>
                        <th>Make</th>
                        <th>Engine #</th>
                        <th>Chassis #</th>
                        <th>Date/Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="10">No Data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div id="div-settings-motor-form" style="display: none;">
                      <form action="#" method="POST" id="motor-form-submit">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span style="color:red; font-size:15px;">* </span>
                                        <label>Operator Code</label> 
                                        <div class="form-group">
                                            <input type="text" id="mopcode" name="mopcode" class="form-control" readonly required>
                                        </div>
                                   </div>
                                   <div class="col-md-6">
                                        <label>Application Number</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="strcode" id="strcode" readonly>
                                        </div>
                                   </div>
                                   
        
                                   <div class="col-md-12">
                                        <label>Full Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="mname" id="mname" readonly>
                                        </div>
                                   </div>
                                   
                                   <div class="col-md-12">
                                        <label>Address</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="maddress" id="maddress" readonly>
                                        </div>
                                   </div>
                                   <div class="col-md-6">
                                        <span style="color:red; font-size:15px;">* </span>
                                        <label>Franchise #</label>
                                        <div class="form-group">
                                        <input type="text" class="form-control" name="mmtop" id="mmtop" readonly>
                                        </div>
                                   </div>
        
                                   <div class="col-md-6">
                                        <label>Make</label>
                                        <div class="form-group">
                                        <input class="form-control" id="mmake" name="mmake" readonly>
                                            <!-- <?php
                                                $make = $class->motorMakeOption();
                                                    echo "<option selected disabled>Select Make</option>";
                                                foreach ($make as $item) {
                                                    echo "<option value='".$item['decription']."'>".$item['decription']."</option>";    
                                                }
                                            ?> -->
                                        </div>
                                   </div>
                                   <div class="col-md-6">
                                        <span style="color:red; font-size:15px;">* </span>
                                        <label>Current Status</label>
                                        <div class="form-group">
                                        <input type="text" class="form-control" name="" id="stags" readonly>
                                        </div>
                                   </div>
        
                                   <div class="col-md-6">
                                        <label>New Status</label>
                                        <div class="form-group">
                                        <select name="stags" class="form-control" onchange="handleInput(this.value, this.id);">
                                            <option selected="" disabled="">- - - -</option>
                                            <!-- <option>FOR FOR INSPECTION</option>
                                            <option>FOR ASSESSMENT</option>
                                            <option>FOR PAYMENT</option> -->
                                            <option value="FOR INSPECTION">FOR INSPECTION</option>
                                            <option value="FOR ASSESSMENT">FOR ASSESSMENT</option>
                                            <option value="FOR PAYMENT">FOR PAYMENT</option>
                                            <option value="FOR RELEASING">FOR RELEASING</option>
                                            </select> 
                                        
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
  <script type="text/javascript" src="js/settings-changestatus.js"></script>

</body>

</html>