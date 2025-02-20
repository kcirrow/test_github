<form action="#" method="POST" id="fran-exp-form-submit">
    <div class="row">
        <div class="col-md-12">
              <label>Expiration Mode</label>
              <select class="form-control" name="exp-mode" id="exp-mode">
                  <option value="0">Fiscal Year</option>
                  <option value="1">Calendar Year</option>
              </select>
        </div>
        <div class="col-md-12">
              <label>No. of years (Franchise Expiry)</label>
              <input type="number" class="form-control" name="fran-exp" id="fran-exp" min="1">
        </div>
    </div>
    <br>
    <button type="button" class="btn btn-success" id="btn-fran-exp-edit">Save Changes</button>
</form>