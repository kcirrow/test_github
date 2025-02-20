<div class="row">
  <form action="#" method="POST" id="fees-form-submit" width="100%">
    <label>Category</label>
    <select id="fees-category" class="form-control" name="fees-category">
      <option value="NEW">NEW</option>
      <option value="RENEW">RENEW</option>
      <option value="CHANGE MOTOR">CHANGE MOTOR</option>
      <option value="CHANGE OWNERSHIP">CHANGE OWNERSHIP</option>
      <option value="CHANGE DRIVER">CHANGE DRIVER</option>
      <option value="DROPPING">DROPPING</option>
    </select>
</div>
<br>
<div id="div-settings-fees-table">
  <div class="row">
     <div class='col-md-12'>
         <h4>Fees List <button id="btn-fees-add" class="btn btn-primary float-right">Add Fees</button></h4>
         <br>
         
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
  <button type="button" class="btn btn-danger" id="btn-fees-back">Back</button>
</div>