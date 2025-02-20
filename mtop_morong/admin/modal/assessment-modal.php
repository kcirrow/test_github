<div class="modal fade modal-central" id="assessment-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-md">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Assessment Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <h3>Applicant Information</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label>Transaction Code</label>
                        <input type="text" class="form-control" id="assess-trcode" disabled="true">
                    </div>
                    <div class="col-md-6">
                        <label>Transaction</label>
                        <input type="text" class="form-control" id="assess-trans" disabled="true">
                    </div>

                    <div class="col-md-12">
                        <label>Full Name</label>
                        <input type="text" class="form-control" id="assess-fullname" disabled="true">
                    </div>
                </div>
                <br>
                <h4>Assessment Fees:</h4>
                   <table class="table text-nowrap" id="assessment-datatable" width="100%">
                      <thead>
                          <tr>
                              <th></th>
                              <th>Fees</th>
                              <th>Amount</th>
                          </tr>
                      </thead>
                      <tbody>
                          
                      </tbody>
                   </table>

                   <br>
                <div class="row">
               <!--  <div class="col-md-5" id="tdpyears">
                  <label>TDP years:</label>
                  <input type="number" id="tdpyr" min="1" value="1" class="form-control-sm">
                </div> -->
                <div class="col-md-12">
                  <h4>Total Assessment: <u id="total-assess">0.00</u></h4>
                </div>
              </div>
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-assessment-save">Save</button>
                <button type="button" class="btn btn-info" id="btn-assessment-print">Print</button>
                <button type="button" class="btn btn-success" id="btn-assessment-saveprint">Save & Print</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

