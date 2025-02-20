<div id="div-settings-signatories-table">
  <div class="row col-md-12">
    <h4>Signatories List <button class="btn btn-primary float-right" id="btn-settings-signatories-add">Add Signatories</button></h4><br>
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
  <br>
  <button type="button" class="btn btn-success" id="btn-signatories-edit">Save Changes</button>
  <button type="button" class="btn btn-success" id="btn-signatories-save">Save</button>
  <button type="button" class="btn btn-danger" id="btn-signatories-back">Back</button>
</div>