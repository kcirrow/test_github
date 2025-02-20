<div class="modal fade modal-central" id="fees-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Fees Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                <form action="#" method="POST" id="fees-form-submit" width="100%">
                    <label>Category</label>
                    <select id="fees-category" class="form-control" name="fees-category">
                        <option value="NEW">NEW</option>
                        <option value="RENEW">RENEW</option>
                        <option value="DROPPING">DROPPING</option>
                    </select>
                </div>
                <br>
                <div class="row">
                  <div id="div-settings-fees-table">
                    <div class="row">
                      <h4>Fees List</h4><br>
                      <table class="table" id="settings-fees-datatable" width="100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Nature</th>
                                <th>Fees</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div id="div-settings-fees-form" style="display: none">
                      <div class="row">
                          <div class="col-md-12">
                              <label>Collnature</label>
                              <select id="fees-option" class=form-control name="fees-option">
                                  <option class="fees-option"></option>
                              </select>
                              <label>Amount</label>
                              <input type="text" class="form-control" name="fees-amount" id="fees-amount">
                          </div>
                      </div>
                    </form>
                    <br>
                    <button type="button" class="btn btn-warning" id="btn-fees-edit">Save Changes</button>
                    <button type="button" class="btn btn-success" id="btn-fees-save">Save</button>
                  </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-fees-add">Add</button> <button type="button" class="btn btn-danger" id="btn-fees-back">Back</button> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



