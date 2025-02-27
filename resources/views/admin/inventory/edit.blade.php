@extends('layouts.admin')

@section('title', 'Edit Inventory')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Inventory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Edit Inventory</li>
            </ol>
          </div>
        </div>
     @stop

     @section('content')

        <div class="row">
         
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <div class="ml-10">
                  Inventory Details
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
              
                

                  <div class="" id="settings">
                    <form class="form-horizontal" id="form_create" method="PUT" data-url="/admin/inventories/{{ $inventory->id }}" >
                      @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label required-field">Product Name</label>
                        <div class="col-sm-10">
                          <select class="form-control" id="product" name="product" style="width: 100%;">
                            @if($inventory->product)
                              <option value="{{ $inventory->product->id }}" selected>{{ $inventory->product->name }}</option>
                            @endif
                          </select>
                          <span id="error_product" class="error-text text-danger pull-right" style=""></span>

                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label required-field">Unit</label>
                        <div class="col-sm-10">
                          <select class="form-control" id="unit" name="unit" style="width: 100%;">
                            @if($inventory->unit)
                              <option value="{{ $inventory->unit->id }}" selected>{{ $inventory->unit->name }}</option>
                            @endif
                          </select>
                          <span id="error_unit" class="error-text text-danger pull-right" style=""></span>

                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Unit Quantity</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control"  value="{{$inventory->unit_quantity }}" name="unit_quantity"  id="inputName" placeholder="Unit Quantity">
                              <span id="error_unit_quantity" class="error-text text-danger pull-right" style=""></span>

                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Stock</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control"  value="{{$inventory->stock }}" name="stock"  id="inputName" placeholder="Stock">
                              <span id="error_stock" class="error-text text-danger pull-right" style=""></span>

                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Cost Price</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control"  value="{{$inventory->cost_price }}" name="cost_price"  id="inputName" placeholder="Cost Price">
                              <span id="error_cost_price" class="error-text text-danger pull-right" style=""></span>
    
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Sell Price</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" value="{{$inventory->sell_price }}"  name="sell_price"  id="inputName" placeholder="Sell Price">
                              <span id="error_sell_price" class="error-text text-danger pull-right" style=""></span>
    
                            </div>
                          </div>
                        </div>
                      </div>
                      
                     
                    
                     
                      <div class="form-group row">
                        <div class="offset-sm-3 col-sm-9 ">
                          <button type="button" id="editSubmit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
              
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        @stop

@section('css')
<link href='{{ url('/adminlte/dist/css/custom.css') }}' rel='stylesheet' type="text/css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet' type="text/css">

@stop
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>

@section('js')
    <script>
        
        $(document).ready(function(){
            $("#editSubmit").click(function(){
              var formData  =  $('#form_create').serialize(); 
              var url  =  $('#form_create').data('url'); 
              $.ajax({
                    type: "PUT",
                    url: url,
                    data: formData,
                    beforeSend: function() {
                        // setting a timeout
                        $('.error-text').text('');
                    },
                    success: function(data){
                      toastr.success('Inventory updated successfully',"Sucesss");
                     // console.log(data); //  Fail messages appear here for some reason.
                    },
                   
                    error: function(data) {
                        var errors = data.responseJSON.errors;
                        if(errors){
                          $.each( errors, function( key, value ) {
                            $("#error_"+key ).text(value[0]);
                          });
                         
                        
                        }
                       
                    },
                });
            });
        });
    </script>
@stop