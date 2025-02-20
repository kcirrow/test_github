<div class="modal fade modal-central" id="expfran-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
<div class="modal-dialog modal-dialog-center modal-xl">
    <div class="modal-content ">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Overview</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <div class='row'>
                <div class='col-md-6'>
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
                        </div>
                      </div>
                </div>
                <div class='col-md-6'>
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
                        </div>
                      </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-8'>
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Motor Information <p style="display: inline-block;" id="displayFranStatus"></p>
                          </h3>
                          <div class="card-tools">
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6">
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
                              <p>Franchise #: <label id="form-motormtop"></label></p>
                              <p>Last Renew: <label id="form-lastrenew"></label></p>
                              <p>Plate Color: <label id="form-motorplatecolor"></label></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class='col-md-4'>
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Application Details <p style="display: inline-block;" id="displayFranStatus"></p>
                          </h3>
                          <div class="card-tools">
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class='col-md-12'>
                                <p>Transaction Code: <label id="form-trcode"></label></p>
                                <p>Transaction Type: <label id="form-applicationtype"></label></p>
                                <p>Application Year: <label id="form-applicationyear"></label></p>
                                <p>Remarks: <label id="form-motorplatecolor"></label></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

