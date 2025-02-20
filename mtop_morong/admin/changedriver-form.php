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
              <h1 class="m-0">Change Driver <p style="display: inline-block;" id="displayStatus"></p>
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Change Driver</li>
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
                  <div class='position-relative' height='110px'>
                      <div class='ribbon-wrapper ribbon-lg'>
                          <div class='ribbon bg-secondary'>
                              OLD
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
                            <!-- <div class="text-right">
                                <button class="btn btn-sm bg-teal" id="btn-modal-operator">
                                  <i class="fas fa-plus"></i>
                                </button>
                                <button id="btn-modal-operator-view" class="btn btn-sm btn-primary">
                                  <i class="fas fa-user"></i> View Profile
                                </button>
                              </div> -->
                          </div>
                        </div>
                    </div>
                  </div>
                  
                  <!--<div class="d-flex align-items-stretch flex-column">-->
                  <!--  <div class="card d-flex flex-fill">-->
                  <!--    <div class="card-header text-muted border-bottom-0">-->
                  <!--      Driver Information-->
                  <!--      <div class="card-tools text-muted border-bottom-0">-->
                  <!--         <p id="sameasoperator-inp"><input type="checkbox" id="sameasoperator"> Same as Operator</p> -->
                  <!--      </div>-->
                  <!--    </div>-->
                  <!--    <div class="card-body pt-0">-->
                  <!--      <div class="row">-->
                  <!--        <div class="col-5 text-center">-->
                  <!--          <img src="../dist/img/driver.png" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid" id="form-driverimg">-->
                  <!--        </div>-->
                  <!--        <div class="col-7">-->
                  <!--          <h2 class="lead"><b id="form-drivername">------------------------</b></h2>-->
                  <!--          <p class="text-muted text-sm" id="form-driverid"></p>-->
                  <!--          <ul class="ml-4 mb-0 fa-ul text-muted">-->
                  <!--            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>-->
                  <!--              <p id="form-driveraddress">N/A</p>-->
                  <!--            </li>-->
                  <!--            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>-->
                  <!--              <p id="form-drivercontact">N/A</p>-->
                  <!--            </li>-->
                  <!--          </ul>-->
                  <!--        </div>-->

                  <!--      </div>-->
                  <!--    </div>-->
                  <!--    <div class="card-footer">-->
                  <!--       <div class="text-right">-->
                  <!--          <button class="btn btn-sm bg-teal" id="btn-modal-driver">-->
                  <!--            <i class="fas fa-plus"></i>-->
                  <!--          </button>-->
                  <!--          <button id="btn-modal-driver-view" class="btn btn-sm btn-primary">-->
                  <!--            <i class="fas fa-user"></i> View Profile-->
                  <!--          </button>-->
                  <!--        </div>-->
                  <!--    </div>-->
                  <!--  </div>-->
                  <!--</div>-->
                  
                  <!-- <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Operator Information</h3>
                      <div class="card-tools">
                      </div>
                    </div>
                    <div class="card-body">
                      <p>Operator ID: <label id="form-operatorid"></label></p>
                      <p>Name: <label id="form-operatorname"></label></p>
                      <p>Address: <label id="form-operatoraddress"></label></p>
                      <p>Contact #: <label id="form-contactno"></label></p>
                    </div>
                    <div class="card-footer">
                      <button class="btn btn-primary float-right">Select</button>
                    </div>
                  </div> -->
                </div>
                <div class="col-md-6">
                    <div class='position-relative' height='110px'>
                      <div class='ribbon-wrapper ribbon-lg'>
                          <div class='ribbon bg-success'>
                              NEW
                          </div>
                      </div>
                      <div class="d-flex align-items-stretch flex-column">
                        <div class="card d-flex flex-fill">
                          <div class="card-header text-muted border-bottom-0">
                            New Driver Information
                          </div>
                          <div class="card-body pt-0">
                            <div class="row">
                              <div class="col-5 text-center">
                                <img src="../dist/img/operator.png" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid" id="form-operatorimg-new">
                              </div>
                              <div class="col-7">
                                <h2 class="lead"><b id="form-operatorname-new">------------------------</b></h2>
                                <p class="text-muted text-sm" id="form-operatorid-new"></p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                  <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                                    <p id="form-operatoraddress-new">N/A</p>
                                  </li>
                                  <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                    <p id="form-operatorcontact-new">N/A</p>
                                  </li>
                                </ul>
                              </div>
    
                            </div>
                          </div>
                          <div class="card-footer">
                            <div class="text-right">
                              <button class="btn btn-sm bg-teal" id="btn-modal-operator">
                                <i class="fas fa-plus"></i>
                              </button>
                              <button id="btn-modal-operator-view" class="btn btn-sm btn-primary">
                                <i class="fas fa-user"></i> View Profile
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-secondary">
                          <h3 class="card-title">Motor/Franchise Information</h3>
                          <div class="card-tools">
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6">
                              <h5>Motor Information</h5>
                              <p>Motor ID: <label id="form-motorid"></label></p>
                              <p>TODA - Body #: <label id="form-motortoda"></label></p>
                              <p>Make: <label id="form-motormake"></label></p>
                              <p>Chassis #: <label id="form-motorchassis"></label></p>
                              <p>Engine #: <label id="form-motorengine"></label></p>
                              <p>Plate #: <label id="form-motorplate"></label></p>
                              <p>Sticker Exp. Date #: <label id="form-motorstickerexpdate"></label></p>
                              <p>Franchise Exp. Date #: <label id="form-franchiseexpdate"></label></p>
                            </div>
                            <div class="col-md-6  ">
                              <h5>Franchise Information</h5>
                              <p>Franchise #: <label id="form-motormtop"></label></p>
                              <p>Last Renew: <label id="form-lastrenew"></label></p>
                              <p>Plate Color: <label id="form-motorplatecolor"></label></p>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <!--                  <div class="text-right">
                            <button class="btn btn-sm bg-teal" id="btn-modal-motor">
                              <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" id="btn-modal-motor-view">
                              <i class="fas fa-user"></i> View Motor
                            </button>
                          </div> -->
                        </div>
                      </div>
                    </div>
                   <div class="col-md-6">
                       <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Application Section</h3>
                          <div class="card-tools">
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6">
                                  <p>
                                    Application Type:
                                    <label id="form-applicationtype">CHANGE DRIVER</label>
                                  </p>
                                  </p>
                                </div>
                                <div class="col-md-6">
                                  <p>TR-CODE: <label id="form-trcode-new"></label></p>
                                </div>
                              </div>
                              <p>
                                Application Year:
                                <select class="form-control" id="form-applicationyear">
                                  <option value="2021">2021</option>
                                </select>
                              <p>
                              <div class="row">
                                <div class="col-md-12">
                                  <p>Application Remarks</p>
                                  <input type="text" class="form-control" name="form-remarks-new" id="form-remarks-new">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <!--                      <div class="text-right">
                            <button class="btn btn-sm bg-teal" id="btn-modal-motor">
                              <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" id="btn-modal-motor-view">
                              <i class="fas fa-user"></i> View Motor
                            </button>
                          </div> -->
                        </div>
                      </div>
                   </div>
                </div>
              <div class="row">
                 <div class="col-md-12">
                     <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Requirements</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <form action="#" method="POST" autocomplete="off" id="repapplication-forms">
                            <table class="table table-bordered table-hover table-striped nowrap" id="req-application-datatable" width="100%">
                              <thead>
                                <tr>
                                  <th width="15%">Action</th>
                                  <th>Thumbnail</th>
                                  <th>Requirement Description</th>
                                  <th width="10%">Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td colspan="4" class="text-center">No Data to display yet</td>
                                </tr>
                              </tbody>
                            </table>
                          </form>
                        </div>
    
                        <div class="card-footer">
                          <button class="btn btn-primary btn-block" id="btn-upload-pictures">Upload All Pics</button>
                        </div>
    
                      </div>
                 </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <!-- <button class="btn btn-warning btn-block" id="btn-operator-inspection">Inspect</button> -->
                  <button class="btn btn-primary btn-block" id="btn-submit-franchises">Submit Application</button>
                  <!--  <button class="btn btn-success btn-block" id="btn-operator-assessment">Assess</button>
                  <button class="btn btn-info btn-block" id="btn-operator-release">Release</button> -->
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
    <?php include "modal/motor-modal-new.php"; ?>
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
  <script type="text/javascript" src="js/changedriver-form.js"></script>
  <script type="text/javascript">
    // // initialize with an array of objects
    //   $('button').click(function () {

    //      new PhotoViewer([{
    //       src: 'images/86388f850ea34a12ebfb5016aa62dea4.jpg',
    //       title: 'Glendalough Upper Lake by <a href="https://www.flickr.com/photos/desomnis/">Angelika Hörschläger</a>'
    //     }, {
    //       src: 'https://c1.staticflickr.com/5/4364/35774111373_187963664b_h.jpg',
    //       title: 'A foggy summer day by <a href="https://www.flickr.com/photos/desomnis/">Angelika Hörschläger</a>'
    //     }, {
    //       src: 'https://c1.staticflickr.com/8/7737/28617607314_170a8e6752_k.jpg',
    //       title: 'My Silver Lining (explore) by <a href="https://www.flickr.com/photos/desomnis/">Angelika Hörschläger</a>'
    //     }]);
    //   });

    //   // initialize manually with a list of links
    //   $('[data-gallery=manual]').click(function (e) {

    //     e.preventDefault();

    //     var items = [],
    //       options = {
    //         index: $(this).index(),
    //       };

    //     $('[data-gallery=manual]').each(function () {
    //       items.push({
    //         src: $(this).attr('href'),
    //         title: $(this).attr('data-title')
    //       });
    //     });

    //     new PhotoViewer(items, options);

    //   });
  </script>

</body>

</html>