<div id="div-settings-req-table">
    <label>Transaction Category</label>
    <select class="form-control" id="req-category">
      <option>NEW</option>
      <option>RENEW</option>
      <option>DROPPING</option>
    </select>
    <br>
    <button id="btn-settings-req-create" class="btn btn-primary float-right">Add Requirements</button>
    <table class="table table-hover table-bordered text-nowrap m-0" id="settingsreqtable" width="100%">
      <thead>
        <tr>
          <th>Action</th>
          <th>Requirements</th>
          <th>Application Type</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <!-- <td colspan="3">No Data</td> -->
        </tr>
      </tbody>
    </table>
  </div>

  <div id="div-settings-req-form" style="display: none">
    <form action="#" method="POST" id="req-form-submit">
      <div class="row">
        <div class="col-md-6">
          <label>Description</label>
          <input type="text" class="form-control" name="req-desc" id="req-desc">
        </div>
        <div class="col-md-6">
          <label>Transaction Category</label>
          <select class="form-control" name="req-cat" id="req-cat">
            <option>NEW</option>
            <option>RENEW</option>
            <option>DROPPING</option>
          </select>
        </div>
      </div>
    </form>
    <br>
    <div class="float-right">
      <button class="btn btn-danger float" id="btn-req-back">Back</button>
      <button class="btn btn-success" id="btn-req-save">Save</button>
      <button class="btn btn-success" id="btn-req-edit">Save Changes</button>
    </div>
  </div>