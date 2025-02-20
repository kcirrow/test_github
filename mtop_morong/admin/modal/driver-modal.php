<div class="modal fade modal-central" id="driver-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Driver Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div id="div-driver-table">
                    <h3>Driver's Table</h3>
                    <button type="button" class="btn btn-primary float-right" id="btn-create-driver">Create Driver</button>
                    <table class="table table-striped table-bordered nowrap table-hover" id="drivertable" width="100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Code</th>
                                <th>Full Name</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div id="div-driver-form" style="display: none">
                    <h3>Driver's Information</h3>
                    <form action="#" id="driver-form-submit" autocomplete="off">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="../dist/img/driver.png" id="driver-img-alt" name="driver-img-alt" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid">
                                <input type="file" name="driver-img" id="driver-img">
                                <button class="btn btn-success btn-sm" id="open-photo-dr"><i class="fa fa-camera"></i></button>
                                <input type="hidden" name="drhiddenimage" id="dhiddenimage">
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                   <div class="col-md-3">
                                        <label>Firstname</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="dfirstname" id="dfirstname">
                                        </div>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Middle Initial</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="dmidinit" id="dmidinit">
                                        </div>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Lastname</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="dlastname" id="dlastname">
                                        </div>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Suffix (Jr./Sr.)</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="dextname" id="dextname">
                                        </div>
                                   </div>
                                </div>

                                <div class="row">
                                   <div class="col-md-4">
                                        <label>Birthdate</label>
                                        <div class="form-group">
                                            <input type="date" class="form-control"  name="dbday" id="dbday">
                                        </div>
                                   </div>
                                   <div class="col-md-1">
                                        <label>Age</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="dage" id="dage" value="0" readonly>
                                        </div>
                                   </div>

                                   <div class="col-md-3">
                                        <label>Gender</label>
                                        <select class="form-control"  name="dgender" id="dgender">
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                   </div>

                                   <div class="col-md-4">
                                        <label>Civil Status</label>
                                        <select class="form-control"  name="dcivstats" id="dcivstats">
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
                                    <input type="text" class="form-control"  name="dhse" id="dhse">
                                </div>
                           </div>

                           <div class="col-md-4">
                                <label>Street</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="dst" id="dst">
                                </div>
                           </div>

                            <div class="col-md-5">
                                <label>Subdivision</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="dsubd" id="dsubd">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label>Region</label>
                                <div class="form-group">
                                    <!-- <input type="text" class="form-control" value="Cavite"  name="prov" id="prov"> -->
                                    <select id="dregion" name="dregion" class="form-control">
                                        <option class="dregion-opt">....</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Province</label>
                                <div class="form-group">
                                    <!-- <input type="text" class="form-control" value="Cavite"  name="prov" id="prov"> -->
                                    <select id="dprov" name="dprov" class="form-control">
                                        <option class="dprov-opt">....</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>City/Municipal</label>
                                <div class="form-group">
                                    <!-- <input type="text" class="form-control" value="Carmona"  name="mun" id="mun"> -->
                                    <select id="dmun" name="dmun" class="form-control">
                                        <option class="dmun-opt">....</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Brgy.</label>
                                <div class="form-group">
                                    <!-- <input type="text" class="form-control"  name="brgy" id="brgy"> -->
                                    <select id="dbrgy" name="dbrgy" class="form-control">
                                        <option class="dbrgy-opt">....</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label>Driver's Licence</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="ddrivlic" id="ddrivlic">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>License Expiration</label>
                                <div class="form-group">
                                    <input type="date" class="form-control"  name="ddrivissue" id="ddrivissue">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Place Issued</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="ddrivplace" id="ddrivplace">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Contact No</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" data-inputmask="'mask': '09999999999'" data-mask="" inputmode="text" name="dcontact" id="dcontact">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <label>Res. Cert. No</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="dctc" id="dctc">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Issued On</label>
                                <div class="form-group">
                                    <input type="date" class="form-control"  name="dctcissue" id="dctcissue">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Issued At</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="dctcplace" id="dctcplace">
                                </div>
                            </div>
                        </div>

                        <h4 style="padding-left: 10px">Person to contact incase of emergency</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Name</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="demername" id="demername">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Contact No</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="demercontact" id="demercontact">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label>Address</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="demeraddr" id="demeraddr">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label>Remarks</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="dremarks" id="dremarks">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label>CIN (Citizen Identification Number)</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="dcin" id="dcin">
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

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

