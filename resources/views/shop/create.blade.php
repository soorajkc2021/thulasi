<div class="card">
  <div class="card-header p-2">
   Create Orders
  </div><!-- /.card-header -->
  <div class="card-body">
   
     
      <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label required-field">Product</label>
        <div class="col-sm-10">
          <select class="form-control" id="product" name="product" style="width: 100%;">
          </select>
          <span id="error_product" class="error-text text-danger pull-right" style=""></span>

        </div>
      </div>
     

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label for="inputName" class="col-sm-4 col-form-label required-field">Inventory</label>
            <div class="col-sm-8">
              <select class="form-control" id="inventory" name="inventory" style="width: 100%;">
              </select>
              <span id="error_inventory" class="error-text text-danger pull-right" style=""></span>

            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label for="cost_price" class="col-sm-4 col-form-label required-field">Cost Price</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" readonly name="cost_price"  id="cost_price" placeholder="Cost Price">
              <span id="error_cost_price" class="error-text text-danger pull-right" style=""></span>

            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label for="quantity" class="col-sm-4 col-form-label required-field">Quantity</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" name="quantity"  id="quantity" placeholder="Unit Quantity">
              <span id="error_quantity" class="error-text text-danger pull-right" style=""></span>

            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label for="sell_price" class="col-sm-4 col-form-label required-field">Sell Price</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="sell_price"  id="sell_price" placeholder="Sell Price">
              <span id="error_sell_price" class="error-text text-danger pull-right" style=""></span>

            </div>
          </div>
        </div>
        <input type="hidden" class="form-control" name="shop_id" value="{{ $shop->id }}"  id="shop_id">

      </div>
      

     
   
    
    <div class="form-group row">
      <div class="offset-sm-11 col-sm-1 ">
        <button type="button" id="addProduct" class="btn btn-primary">Add</button>
      </div>
    </div>
  </div><!-- /.card-body -->
</div>