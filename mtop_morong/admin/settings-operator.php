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
                            <h1 class="m-0">Operators / Drivers</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item">Settings</li>
                                <li class="breadcrumb-item active">Operators</li>
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
                                    <h3 class="card-title">Operator Table</h3>
                                </div>
                                <div class="card-body">
                                    <div id="div-settings-operator-table">
                                        <button id="btn-settings-operator-create" class="btn btn-primary float-right">Create Operator</button>
                                        <table class="table table-responsive table-hover table-bordered text-nowrap m-0" id="settingsoperatortable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Operator ID</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Contact #</th>
                                                    <th>Gender</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5">No Data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="div-settings-operator-form" style="display: none">
                                        <h3>Operator's Information</h3>
                                        <form action="#" id="operator-form-submit" autocomplete="off" enctype="multipart/form-data">
                                            <div class="row">
                                                 <div class="col-md-4 text-center">
                                                    <img src="../dist/img/operator.png" id="oper-img-alt" name="oper-img-alt" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid">
                                                    <input type="file" name="oper-img" id="oper-img">
                                                    <button class="btn btn-success btn-sm" id="open-photo"><i class="fa fa-camera"></i></button>
                                                    <input type="hidden" name="hiddenimage" id="hiddenimage">
                                                </div>


                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Firstname</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="firstname" id="firstname">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Middle Name</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="midinit" id="midinit">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Lastname</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="lastname" id="lastname">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Suffix (Jr./Sr.)</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="ext_name" id="ext_name">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Birthdate</label>
                                                            <div class="form-group">
                                                                <input type="date" class="form-control" name="bday" id="bday">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label>Age</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="age" id="age" value="0" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Gender</label>
                                                            <select class="form-control" name="gender" id="gender">
                                                                <option value="MALE">MALE</option>
                                                                <option value="FEMALE">FEMALE</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label>Civil Status</label>
                                                            <select class="form-control" name="civstats" id="civstats">
                                                                <option value="SINGLE">SINGLE</option>
                                                                <option value="MARRIED">MARRIED</option>
                                                                <option value="WIDOWED">WIDOWED</option>
                                                                <option value="SEPARATED">SEPARATED</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Address (House #, Lot #, Blk #)</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="hse" id="hse">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Street</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="st" id="st">
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <label>Subdivision</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="subd" id="subd">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Region</label>
                                                    <div class="form-group">
                                                        <!-- <input type="text" class="form-control" value="Cavite"  name="prov" id="prov"> -->
                                                        <select id="region" name="region" class="form-control">
                                                            <option class="region-opt">....</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Province</label>
                                                    <div class="form-group">
                                                        <!-- <input type="text" class="form-control" value="Cavite"  name="prov" id="prov"> -->
                                                        <select id="prov" name="prov" class="form-control">
                                                            <option class="prov-opt">....</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Municipal</label>
                                                    <div class="form-group">
                                                        <!-- <input type="text" class="form-control" value="Carmona"  name="mun" id="mun"> -->
                                                        <select id="mun" name="mun" class="form-control">
                                                            <option class="mun-opt">....</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Brgy.</label>
                                                    <div class="form-group">
                                                        <!-- <input type="text" class="form-control"  name="brgy" id="brgy"> -->
                                                        <select id="brgy" name="brgy" class="form-control">
                                                            <option class="brgy-opt">....</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Driver's Licence</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="drivlic" id="drivlic">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>License Expiration</label>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" name="drivissue" id="drivissue">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Place Issued</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="drivplace" id="drivplace">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Contact No</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="contact" id="contact">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Res. Cert. No</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="ctc" id="ctc">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Issued On</label>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" name="ctcissue" id="ctcissue">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Issued At</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="ctcplace" id="ctcplace">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>CIN (Citizen Identification Number)</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"  name="cin" id="cin" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Occupation</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"  name="occupation" id="occupation">
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 style="padding-left: 10px">Person to contact incase of emergency</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Name</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="emername" id="emername">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Contact No</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="emercontact" id="emercontact">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Address</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="emeraddr" id="emeraddr">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Remarks</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="remarks" id="remarks">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="float-right">
                                            <button class="btn btn-danger float" id="btn-operator-back">Back</button>
                                            <button class="btn btn-success" id="btn-operator-save">Save</button>
                                            <button class="btn btn-success" id="btn-operator-edit">Save Changes</button>
                                        </div>
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

    <?php include "modal/photo-modal.php"; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>


    </div>

    <?php include "../config/scripts.php"; ?>
    <script type="text/javascript" src="js/settings-operator.js"></script>

</body>

</html>