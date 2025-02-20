<div id="div-settings-make-table">
  <div class="row">
    <div class="col-md-12">
        <h4>Make List</h4><br>
        <button id="btn-settings-make-add" class="btn btn-primary float-right">Add Make</button>
        <table class="table" id="settings-make-datatable" width="100%">
          <thead>
            <tr>
              <th width="20%">Action</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
    
          </tbody>
        </table>
    </div>
  </div>
</div>

<div id="div-settings-make-form" style="display: none">
  <form action="#" method="POST" id="make-form-submit">
    <h4>Make Form</h4>
    <div class="row">
      <div class="col-md-12">
        <label>Description</label>
        <input type="text" class="form-control" name="make-description" id="make-description">
      </div>
    </div>
  </form>
  <br>
  <button type="button" class="btn btn-success" id="btn-make-edit">Save Changes</button>
    <button type="button" class="btn btn-success" id="btn-make-save">Save</button>
  <button type="button" class="btn btn-danger" id="btn-make-back">Back</button>
</div>