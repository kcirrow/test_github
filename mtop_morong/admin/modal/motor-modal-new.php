<div class="modal fade modal-central" id="motor-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Motor Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div id="div-motor-table">
                    <h3>Motor Table</h3>
                    <button type="button" class="btn btn-primary float-right" id="btn-create-motor">Create Motor</button>
                    <table class="table table-responsive table-striped table-bordered nowrap table-hover" id="motortable" width="100%">
                        <thead>
                            <tr>
                                <th>Motor ID</th>
                                <th>Operator's Name</th>
                                <th>TODA</th>
                                <th>Engine #</th>
                                <th>Plate #</th>
                                <th>Opercode</th>
                                <th>Driver's Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div id="div-motor-form" style="display: none;">
                  <form action="#" method="POST" id="motor-form-submit">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="../dist/img/operator.png" id="moper-img-alt" name="moper-img-alt" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Operator Code</label>
                                    <div class="form-group">
                                        <input type="text" id="mopcode" name="mopcode" class="form-control" readonly>
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
                            <input type="text" class="form-control" name="mbody" id="mbody" readonly>
                            <label>TODA</label>
                            <select class="form-control" id="mtoda" name="mtoda">
                              <option selected disabled>Select TODA</option>
                            </select>
                            <label>Franchise #</label>
                            <input type="text" class="form-control" name="mmtop" id="mmtop" disabled>
                            <label>Make</label>
                            <input type="text" class="form-control" name="mmake" id="mmake">
                            <label>Plate Color</label>
                            <select class="form-control" name="mplatecolor" id="mplatecolor">
                                <option selected disabled>Please select</option>
                                <option value="YELLOW">YELLOW</option>
                                <option value="GREEN">GREEN</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <h5>Availablity: </h5>
                            <h5 id="mavailability">xxxx</h5>
                            <label>Engine #</label>
                            <input type="text" class="form-control" name="mengine" id="mengine">
                            <label>Chassis #</label>
                            <input type="text" class="form-control" name="mchassis" id="mchassis">
                            <label>Year Model</label>
                            <input type="text" class="form-control" name="myrmodel" id="myrmodel">
                            <label>Motor Color</label>
                            <input type="text" class="form-control" name="mcolor" id="mcolor">
                        </div>
                        <div class="col-md-4">
                            <h5>MTP Year: </h5>
                            <h5 id="mmtpyr">xxxx</h5>
                            <label>Cert. of Reg.</label>
                            <input type="text" class="form-control" name="mcert" id="mcert">
                            <label>Date Issued</label>
                            <input type="date" class="form-control" name="mdtissue" id="mdtissue">
                            <label>LTO Plate #</label>
                            <input type="text" class="form-control" name="mplate" id="mplate">
                            <label>LTO Agency</label>
                            <input type="text" class="form-control" name="magency" id="magency">
                            <label>MV #</label>
                            <input type="text" class="form-control" name="mmvno" id="mmvno">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Remarks</label>
                            <input type="text" class="form-control" name="mremarks" id="mremarks">
                        </div>
                    </div>
                    <br>
                  </form>
                  <div class="float-right">
                    <button class="btn btn-danger float" id="btn-motor-back">Back</button>
                    <button class="btn btn-success" id="btn-motor-save">Save</button>
                    <button class="btn btn-success" id="btn-motor-edit">Save Changes</button>
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

