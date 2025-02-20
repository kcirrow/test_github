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
                            <th>Action</th>
                            <th>Motor ID</th>
                            <th>Operator's Name</th>
                            <th>TODA</th>
                            <th>Last Renew</th>
                            <th>Expiration Date</th>
                            <th>Franchise #</th>
                            <th>Engine #</th>
                            <th>Plate #</th>
                            <th>Operator ID</th>
                            <th>Driver's Name</th>
                            <th>Operator's Name</th>
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
                        <input type="text" class="form-control" name="mbody" id="mbody" name="mbody">
                        <label>Franchise #</label>
                        <input type="text" class="form-control" name="mmtop" id="mmtop" name="mmtop">
                        <span style="color:red; font-size:15px;">* </span>
                        <label>TODA</label>
                        <div class="form-group">
                            <select class="form-control" id="mtoda" name="mtoda" required>
                              <option selected disabled>Select TODA</option>
                            </select>
                        </div>
                        <span style="color:red; font-size:15px;">* </span>
                        <label>Make</label>
                        <div class="form-group">
                            <select class="form-control" id="mmake" name="mmake" required>
                                
                                <?php
                                    $make = $class->motorMakeOption();
                                        echo "<option selected disabled value=''>Select Make</option>";
                                    foreach ($make as $item) {
                                        echo "<option value='".$item['decription']."'>".$item['decription']."</option>";    
                                    }
                                ?>
                            </select>
                        </div>
                    </div>


                     <div class="col-md-4">
                        <h5>MTP Year: </h5>
                        <h5 id="mid">xxxx</h5>
                        <label>Municipal Plate #</label>
                        <input type="text" class="form-control" name="mmunplateno" id="mmunplateno" required>
                        <label>LTO Plate #</label>
                        <input type="text" class="form-control" name="mplate" id="mplate">
                        <label>LTO Agency</label>
                        <!-- <input type="text" class="form-control" name="magency" id="magency"> -->
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
                        <label style="margin-top: 16px;">MV #</label>
                        <input type="text" class="form-control numonly" name="mmvno" id="mmvno">
                        <label>Date Expired</label>
                        <input type="date" class="form-control" name="mexpired" id="mexpired">
                        
                    </div>


                    <div class="col-md-4">
                        <h5>Availablity: </h5>
                        <h5 id="mavailability">xxxx</h5>
                        <span style="color:red; font-size:15px;">* </span>
                        <label>Engine #</label>
                        <input type="text" class="form-control" name="mengine" id="mengine">
                        <span style="color:red; font-size:15px;">* </span>
                        <label>Chassis #</label>
                        <input type="text" class="form-control" name="mchassis" id="mchassis">
                        <label>Year Model</label>
                        <div class="form-group">
                        <input type="text" class="form-control numonly" name="myrmodel" id="myrmodel">
                        </div>
                        <label>Motor Color</label>
                        <input type="text" class="form-control txtonly" name="mcolor" id="mcolor">
                        <label>Plate Color</label>
                        <div class="form-group">
                            <select class="form-control" name="mplatecolor" id="mplatecolor">
                            <?php
                                $pkulay = $class->platekulayOption();
                                    echo "<option selected disabled value=''>Select Plate Color</option>";
                                foreach ($pkulay as $item) {
                                    if ($item['platekulay'] == "YELLOW") {
                                        echo "<option selected value='".$item['platekulay']."'>".$item['platekulay']."</option>";
                                    } else {
                                        echo "<option value='".$item['platekulay']."'>".$item['platekulay']."</option>";
                                    }
                                        
                                }
                            ?>
                        </select>
                        </div>
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
                        <div class="form-group">
                            <input type="text" class="form-control" name="mcert" id="mcert">
                        </div>
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
                        <input type="text" class="form-control" name="morcrname" id="morcrname">
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

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

