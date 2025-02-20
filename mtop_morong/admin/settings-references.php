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
              <h1 class="m-0">References</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">References</li>
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
                  <h3 class="card-title">Reference Tables</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-5 col-sm-3">
                      <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <?php 
                            $ff = true;
                            $active = " active";
                            $show = " show active";
                            $coke = $class->getJunjiito();
                
                            if ($coke['ref_requirements'] == 1) {
                                echo '<a class="nav-link'.$active.'" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-req" role="tab" aria-controls="vert-tabs-req" aria-selected="'.$ff.'">Requirements</a>';
                                $ff = false;
                                $active = "";
                            }
                            
                            if ($coke['ref_assfees'] == 1) {
                                echo '<a class="nav-link'.$active.'" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-assfees" role="tab" aria-controls="vert-tabs-assfees" aria-selected="'.$ff.'">Assessment Fees</a>';
                                $ff = false;
                                $active = "";
                            }
                            
                            if ($coke['ref_signa'] == 1) {
                                echo '<a class="nav-link'.$active.'" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-signa" role="tab" aria-controls="vert-tabs-signa" aria-selected="'.$ff.'">Signatories</a>';
                                $ff = false;
                                $active = "";
                            }
                            
                            if ($coke['ref_make'] == 1) {
                                echo '<a class="nav-link'.$active.'" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-make" role="tab" aria-controls="vert-tabs-make" aria-selected="'.$ff.'">Make</a>';
                                $ff = false;
                                $active = "";
                            }
                            
                            if ($coke['ref_lto'] == 1) {
                                echo '<a class="nav-link'.$active.'" id="vert-tabs-lto-tab" data-toggle="pill" href="#vert-tabs-lto" role="tab" aria-controls="vert-tabs-lto" aria-selected="'.$ff.'">LTO Branches</a>';
                                $ff = false;
                                $active = "";
                            }
                            
                            
                            echo '<a class="nav-link'.$active.'" id="vert-tabs-franexp-tab" data-toggle="pill" href="#vert-tabs-franexp" role="tab" aria-controls="vert-tabs-franexp" aria-selected="'.$ff.'">Franchise Year Duration</a>';
                        ?>  
                        
                       
                      </div>
                    </div>
                    <div class="col-7 col-sm-9">
                      <div class="tab-content" id="vert-tabs-tabContent">
                        <?php   
                            if ($coke['ref_requirements'] == 1) {
                                echo '<div class="tab-pane fade'.$show.'" id="vert-tabs-req" role="tabpanel" aria-labelledby="vert-tabs-home-req">';
                                    include_once "settings-requirements.php";
                                echo '</div>';
                                $show = "";
                            }
                            
                            if ($coke['ref_assfees'] == 1) {
                                echo '<div class="tab-pane fade'.$show.'" id="vert-tabs-assfees" role="tabpanel" aria-labelledby="vert-tabs-messages-assfees">';
                                    include_once "settings-assessment.php";                         
                                echo '</div>';
                                $show = "";
                            }
                            
                            if ($coke['ref_signa'] == 1) {
                                echo '<div class="tab-pane fade'.$show.'" id="vert-tabs-signa" role="tabpanel" aria-labelledby="vert-tabs-profile-signa">';
                                  include_once "settings-signatories.php";
                                echo '</div>';
                                $show = "";
                            }
                            
                            if ($coke['ref_make'] == 1) {
                                echo '<div class="tab-pane fade'.$show.'" id="vert-tabs-make" role="tabpanel" aria-labelledby="vert-tabs-settings-make">';
                                  include_once "settings-make.php";
                                echo '</div>';
                                $show = "";
                            }
                            
                            if ($coke['ref_lto'] == 1) {
                                echo '<div class="tab-pane fade'.$show.'" id="vert-tabs-lto" role="tabpanel" aria-labelledby="vert-tabs-settings-lto">';
                                  include_once "settings-lto.php";
                                echo '</div>';
                                $show = "";
                            }
                        
                            echo '<div class="tab-pane fade'.$show.'" id="vert-tabs-franexp" role="tabpanel" aria-labelledby="vert-tabs-settings-franexp">';
                              include_once "settings-franexp.php";
                            echo '</div>';
                        
                        ?>
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include "../config/footer.php"; ?>

  </div>

  <?php include "../config/scripts.php"; ?>
   <script type="text/javascript" src="js/settings-requirements.js"></script> 
   <script type="text/javascript" src="js/settings-franexp.js"></script> 
</body>

</html>