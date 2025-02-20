<div class="modal fade modal-central" id="release-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Releasing Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <h3>Applicant Information</h3>
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="../dist/img/operator.png" id="roper-img-alt" name="roper-img-alt" style="width: 128px !important; height: 128px !important;" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Transaction Code</label>
                                <input type="text" class="form-control" id="reltrcode" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <label>Full Name</label>
                                <input type="text" class="form-control" id="relfullname" disabled="true">
                            </div>
                            <div class="col-md-4">
                                <label>TODA - Body #</label>
                                <input type="text" class="form-control" id="reltbody" disabled="true">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label>Address</label>
                                <input type="text" class="form-control" id="reladdress" disabled="true">
                            </div>
                            <div class="col-md-2">
                                <label>Make</label>
                                <input type="text" class="form-control" id="relmake" disabled="true">
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <h3>Assessment</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover table-striped nowrap" id="releasing-datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>OR #</th>
                                    <th>OR Date</th>
                                </tr>
                            </thead>
                            <tbody class="asstable">
                            </tbody>
                        </table>
                        <br>

                        <!-- <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="relorno" placeholder="O.R. #">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="relordate" value=<?php echo date('Y-m-d'); ?>>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-info" id="relsaveorno">Save Orno</button>
                            </div>
                        </div> -->
                    </div>
                </div>
                <br>
                <div id="div-operator-release-bar">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Franchise #</label>
                            <div id="relmtp-div">
                              <select class="form-control select2" id="relmtp" style="width: 100%;">
                                
                              </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Date Issue</label>
                            <input type="date" class="form-control" id="reldtissue" value=<?php echo date('Y-m-d'); ?>>
                        </div>
                        <div class="col-md-4" id="relfranexp-col">
                            <label>Franchise Expired</label>
                            <input type="date" class="form-control" id="relfranexp">
                        </div>
                        <!--<div class="col-md-3">-->
                        <!--    <label>School Name</label>-->
                        <!--    <input type="text" class="form-control" id="relschoolname">-->
                        <!--</div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Remarks</label>
                            <input type="text" class="form-control" id="relremakrs">
                        </div>
                        <div class="col-md-6">
                            <label>Approved</label>
                            <select id="relapprove" class="form-control">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" id="div-driverpermit-release-bar">
                    <div class="col-md-3">
                        <label>Date Issue</label>
                        <input type="date" class="form-control" id="reldtissue" value=<?php echo date('Y-m-d'); ?>>
                    </div>

                </div>
                <!-- <div class="row">
                    <div class="col-md-3">
                        <label>Sticker #</label>
                        <input type="text" class="form-control" id="relsticker">
                    </div>
                    <div class="col-md-3">
                        <label>Date Issue (Sticker)</label>
                        <input type="date" class="form-control" id="reldtissuesticker" value=<?php echo date('Y-m-d'); ?>>
                    </div>
                    <div class="col-md-3">
                        <label>Sticker Expired</label>
                        <input type="date" class="form-control" id="relstickerexp" >
                    </div>
                    <div class="col-md-3">
                        <label>Have Sticker?</label>
                        <select id="relissticker" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div> -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-operator-save-release">Save Release</button>
                <button type="button" class="btn btn-info" id="btn-operator-print">Print Permit</button>
                <button type="button" class="btn btn-info" id="btn-operator-printidd">Print ID</button>
                <button type="button" class="btn btn-success" id="btn-operator-save-print-release">Save & Print</button>
                <button type="button" class="btn btn-success" id="btn-driver-save-release">Save Release</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>