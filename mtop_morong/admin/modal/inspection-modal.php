<div class="modal fade modal-central" id="inspection-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Inspection Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="inspection-form-submit">                    
                <h3>Applicant Information</h3>
                <div class="row">
                    <div class="col-md-2">
                        <label>Transaction Code</label>
                        <input type="text" class="form-control" id="inspect-trcode" name="inspect-trcode" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Full Name</label>
                        <input type="text" class="form-control" id="inspect-fullname" name="inspect-fullname" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>TODA (Membership)</label>
                        <input type="text" class="form-control" id="inspect-toda" name="inspect-toda" readonly>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <label>Address</label>
                        <input type="text" class="form-control" id="inspect-address" name="inspect-address" readonly>
                    </div>
                </div>

                <br>
                <h3>Description of Motorcycle</h3>
                <div class="row">
                   <div class="col-md-6">
                        <div class="form-group row">
                            <label for="inspect-make" class="col-sm-3 col-form-label">Make/Type:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-make" id="inspect-make" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-engine" class="col-sm-3 col-form-label">Engine #:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-engine" id="inspect-engine" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-chassis" class="col-sm-3 col-form-label">Chassis #:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-chassis" id="inspect-chassis" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-bodyno" class="col-sm-3 col-form-label">Body #:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-bodyno" id="inspect-bodyno" readonly></div>
                        </div>
                   </div>
                   <div class="col-md-6">
                        <div class="form-group row">
                            <label for="inspect-plateno" class="col-sm-3 col-form-label">Plate #:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-plateno" id="inspect-plateno" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-fuel" class="col-sm-3 col-form-label">Fuel:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-fuel" id="inspect-fuel" ></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-model" class="col-sm-3 col-form-label">Model:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-model" id="inspect-model"></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-yearacquired" class="col-sm-3 col-form-label">Year Acquired:</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="inspect-yearacquired" id="inspect-yearacquired"></div>
                        </div>
                   </div>
                </div>
                
                <br>
                <h3>Other Accessories <button class='btn btn-success btn-sm' id='btn-inspection-checkall'><i class='fa fa-check'></i></button> <button class='btn btn-danger btn-sm' id='btn-inspection-uncheckall'><i class='fa fa-times'></i></button></h3>
                <div class="row">
                   <div class="col-md-6">
                        <div class="form-group row">
                            <label for="inspect-headlight" class="col-sm-4 col-form-label">Plate #:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-headlight-switch" id="inspect-headlight-switch">
                                <label class="custom-control-label" for="inspect-headlight-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-headlight" id="inspect-headlight" ></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-signallight" class="col-sm-4 col-form-label">Signal Light:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-signallight-switch" id="inspect-signallight-switch">
                                <label class="custom-control-label" for="inspect-signallight-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-signallight" id="inspect-signallight" ></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-stoplight" class="col-sm-4 col-form-label">Stop Light:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-stoplight-switch" id="inspect-stoplight-switch">
                                <label class="custom-control-label" for="inspect-stoplight-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-stoplight" id="inspect-stoplight" ></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-handfootbrake" class="col-sm-4 col-form-label">Hand & Foot Brake:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-handfootbrake-switch" id="inspect-handfootbrake-switch">
                                <label class="custom-control-label" for="inspect-handfootbrake-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-handfootbrake" id="inspect-handfootbrake" ></div>
                        </div>
                   </div>
                   <div class="col-md-6">
                        <div class="form-group row">
                            <label for="inspect-lightinsidecar" class="col-sm-4 col-form-label">Light inside:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-lightinsidecar-switch" id="inspect-lightinsidecar-switch">
                                <label class="custom-control-label" for="inspect-lightinsidecar-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-lightinsidecar" id="inspect-lightinsidecar" ></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-trashcan" class="col-sm-4 col-form-label">Trash Can inside:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-trashcan-switch" id="inspect-trashcan-switch">
                                <label class="custom-control-label" for="inspect-trashcan-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-trashcan" id="inspect-trashcan" ></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-plate" class="col-sm-4 col-form-label">Plate #:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-plate-switch" id="inspect-plate-switch">
                                <label class="custom-control-label" for="inspect-plate-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-plate" id="inspect-plate" ></div>
                        </div>
                        <div class="form-group row">
                            <label for="inspect-drivlis" class="col-sm-4 col-form-label">Driver's License:</label>
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                <input type="checkbox" class="custom-control-input inspect-switch" name="inspect-drivlis-switch" id="inspect-drivlis-switch">
                                <label class="custom-control-label" for="inspect-drivlis-switch"></label>
                            </div>
                            <div class="col-sm-7"><input type="text" class="form-control" name="inspect-drivlis" id="inspect-drivlis" ></div>
                        </div>
                   </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label>Stencil(Motor #)</label>
                        <input type="text" class="form-control" id="inspect-stencil1" name="inspect-stencil1">
                    </div>
                    <div class="col-md-6">
                        <label>Stencil(Chassis #)</label>
                        <input type="text" class="form-control" id="inspect-stencil2" name="inspect-stencil2">
                    </div>
                </div>
                <br>
 <!--                <div class="row">
                    <div class="col-md-12">
                        <label>Inspection Result</label>
                        <select class="form-control" id="inspect-result" name="inspect-result">
                            <option selected disabled>...</option>
                            <option>PASSED</option>
                            <option>FAILED</option>
                        </select>
                    </div>
                </div> -->
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="btn-inspect-print">Print</button>
                <button type="button" class="btn btn-success" id="btn-inspect-save">Submit Inspection</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

