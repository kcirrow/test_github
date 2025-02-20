<div id="div-settings-lto-table">
    <h3>LTO Branches</h3>
    <h1>CARLO</h1>
    <button id="btn-settings-lto-create" class="btn btn-primary float-right">Add LTO Branch</button>
    <table class="table table-hover table-bordered text-nowrap m-0" id="settingsltotable" width="100%">
      <thead>
        <tr>
          <th>Action</th>
          <th>Branches</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <div id="div-settings-lto-form" style="display: none">
    <form action="#" method="POST" id="lto-form-submit">
      <div class="row">
        <div class="col-md-12">
          <label>Branch Location</label>
          <input type="text" class="form-control" name="lto-loc" id="lto-loc">
        </div>
      </div>
    </form>
    <br>
    <div class="float-right">
      <button class="btn btn-danger float" id="btn-lto-back">Back</button>
      <button class="btn btn-success" id="btn-lto-save">Save</button>
      <button class="btn btn-success" id="btn-lto-edit">Save Changes</button>
    </div>
  </div>