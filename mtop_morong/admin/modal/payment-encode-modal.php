<div class="modal fade modal-central" id="payencode-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">OR Encode Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <h3>OR Details</h3>
                <div class="row">
                    <div class="col-md-12">
                        <h4 id="payencode-payor">Payor:</h4>
                        <table class="table table-bordered table-hover table-striped nowrap" id="payencode-datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>OR #</th>
                                    <th>OR Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="4">NO DATA</td></tr>
                            </tbody> 
                        </table>
                        <br>
                        <div class="col-md-12">
                            <label>OR Search</label>
                            <input type="text" class="form-control" id="payencode-or">
                            <br>
                            <button id="payencode-search" class="btn btn-info btn-block">Search</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-save-payencode">Save OR</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>