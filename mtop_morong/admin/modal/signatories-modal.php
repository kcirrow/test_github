<div class="modal fade modal-central" id="signatories-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-md">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Signatories Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <div class="row">

                  <div id="div-settings-signatories-table">
                    <div class="row">
                      <h4>Signatories List</h4><br>
                      <table class="table" id="settings-signatories-datatable" width="100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Fullname</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div id="div-settings-signatories-form" style="display: none">
                    <form action="#" method="POST" id="signatories-form-submit">
                      <h4>Signatories Form</h4>
                      <div class="row">
                          <div class="col-md-12">
                                <label>Fullname</label>
                                <input type="text" class="form-control" name="signa-fullname" id="signa-fullname">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <label>Position</label>
                              <input type="text" class="form-control" name="signa-position" id="signa-position">
                          </div>
                      </div>
                    </form>
                    <button type="button" class="btn btn-success" id="btn-signatories-edit">Save Changes</button>
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



