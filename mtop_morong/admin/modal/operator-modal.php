<div class="modal fade modal-central" id="operator-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Operator Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div id="div-operator-table">
                    <h3>Operator's Table<button type="button" class="btn btn-primary float-right" id="btn-create-operator">Create Operator</button></h3>
                    <br>
                    <div class="table-responsive">
                        <table class="table  table-striped table-bordered nowrap table-hover" id="operatortable" width="100%">
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
                    <br>
                </div>

                <div id="div-operator-form" style="display: none">
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
                                        <div class="form-group">
                                            <span style="color:red; font-size:15px;">* </span>
                                            <label>Firstname</label>
                                            <input type="text" class="form-control"  name="firstname" id="firstname">
                                        </div>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Middle Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="midinit" id="midinit">
                                        </div>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Lastname</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="lastname" id="lastname">
                                        </div>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Suffix (Jr./Sr.)</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="ext_name" id="ext_name">
                                        </div>
                                   </div>
                                </div>

                                <div class="row">
                                   <div class="col-md-4">
                                        <label>Birthdate</label>
                                        <div class="form-group">
                                            <input type="date" class="form-control"  name="bday" id="bday">
                                        </div>
                                   </div>
                                   <div class="col-md-1">
                                        <label>Age</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="0"  name="age" id="age" readonly>
                                        </div>
                                   </div>

                                   <div class="col-md-3">
                                        <label>Gender</label>
                                        <select class="form-control"  name="gender" id="gender">
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                   </div>

                                   <div class="col-md-4">
                                        <label>Civil Status</label>
                                        <select class="form-control"  name="civstats" id="civstats">
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
                                    <input type="text" class="form-control"  name="hse" id="hse">
                                </div>
                           </div>

                           <div class="col-md-4">
                                <label>Street</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="st" id="st">
                                </div>
                           </div>

                            <div class="col-md-5">
                                <label>Subdivision</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="subd" id="subd">
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
                                <label>City/Municipal</label>
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
                                    <input type="text" class="form-control"  name="drivlic" id="drivlic">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>License Expiration</label>
                                <div class="form-group">
                                    <input type="date" class="form-control"  name="drivissue" id="drivissue">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Place Issued</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="drivplace" id="drivplace">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Contact No</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" data-inputmask="'mask': '09999999999'" data-mask="" inputmode="text" name="contact" id="contact">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <label>Res. Cert. No</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="ctc" id="ctc">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Issued On</label>
                                <div class="form-group">
                                    <input type="date" class="form-control"  name="ctcissue" id="ctcissue">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Issued At</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="ctcplace" id="ctcplace">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>CIN (Citizen Identification Number)</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="cin" id="cin">
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
                                    <input type="text" class="form-control"  name="emername" id="emername">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Contact No</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="emercontact" id="emercontact">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label>Address</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="emeraddr" id="emeraddr">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label>Remarks</label>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="remarks" id="remarks">
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

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

