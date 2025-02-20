<div class="modal fade modal-central" id="waitlist-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-md">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Waiting Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <h3>Applicant Information</h3>
                <form id="waitinglist-submit" action="#">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Full Name</label>
                            <input type="text" class="form-control" id="wait-fullname" name="wait-fullname" required>
                        </div>
                        <div class="col-md-12">
                            <label>Contact #</label>
                            <input type="text" class="form-control" id="wait-contact" name="wait-contact" required>
                        </div>
                        <div class="col-md-12">
                            <label>TODA</label>
                            <div class="form-group">
                                <select class="form-control" id="wait-toda" name="wait-toda" required>
                                  <option selected disabled>Select TODA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-wait-save">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

