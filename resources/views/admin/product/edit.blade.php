@extends('adminlte::page')

@section('title', 'Edit Product')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
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
                  Category Details
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
              
                

                  <div class="" id="settings">
                    <form class="form-horizontal" id="form_create" method="PUT" data-url="/admin/products/{{ $product->id }}" >
                      @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label required-field"> Name</label>
                        <div class="col-sm-10">
                          <input type="text" id="name" class="form-control" required="required" value="{{$product->name }}" name="name"  id="inputName" placeholder="Name">
                          <span id="error_name" class="error-text text-danger pull-right" style=""></span>
                        </div>
                        
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Brand Name</label>
                            <div class="col-sm-8">
                              <select class="form-control select2" id="brand" name="brand" style="width: 100%;">
                                @if($product->brand)
                                  <option value="{{ $product->brand->id }}" selected>{{ $product->brand->name }}</option>
                                @endif
                              </select>
                              <span id="error_category" class="error-text text-danger pull-right" style=""></span>
                    
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Category Name</label>
                            <div class="col-sm-8">
                              <select class="form-control select2" id="category" name="category" style="width: 100%;">
                                @if($product->category)
                                  <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                                @endif
                              </select>
                              <span id="error_category" class="error-text text-danger pull-right" style=""></span>
                    
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">SubCategory Name</label>
                            <div class="col-sm-8">
                              <select class="form-control select2" id="subcategory" name="subcategory" style="width: 100%;">
                                @if($product->subcategory)
                                  <option value="{{ $product->subcategory->id }}" selected>{{ $product->subcategory->name }}</option>
                                @endif
                              </select>
                              <span id="error_category" class="error-text text-danger pull-right" style=""></span>
                    
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                              <label for="inputName" class="col-sm-4 col-form-label required-field">Status</label>
                              <div class="col-sm-8">
                                <select class="form-control select2" id="status" name="status" style="width: 100%;">
                                
                                  <option value="Active" {{ $product->status =='Active'? 'selected':'' }}>Enable</option>
                                  <option value="Inactive" {{ $product->status =='Inactive'? 'selected':'' }}>Disable</option>
                                </select>
                                <span id="error_status" class="error-text text-danger pull-right" style=""></span>
                      
                              </div>
                            </div>
                          </div>
                      </div>
                     
                      <div class="form-group row">
                        <div class="offset-sm-5 col-sm-6 ">
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
<link href='{{ url('/vendor/adminlte/dist/css/custom.css') }}' rel='stylesheet' type="text/css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet' type="text/css">

@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>

    <script>
       
        $(document).ready(function(){

         $('.select2').select2();
          $('#brand').select2({
            ajax: {
              url: '/brand_dropdown',
              data: function(params) {
                var query = {
                        search: params.term,
                        page: params.page || 1,
                    }
                    // Query parameters will be ?search=[term]&page=[page]
                return query;
            },
            processResults: function(data, params) {
                return {
                    results: data.result,
                    pagination: {
                        more: (data.page * 10) < data.count_filtered

                    }
                  };
              }
            }
          });
          $('#category').select2({
            ajax: {
              url: '/category_dropdown',
              data: function(params) {
                var query = {
                        search: params.term,
                        page: params.page || 1,
                    }
                    // Query parameters will be ?search=[term]&page=[page]
                return query;
            },
            processResults: function(data, params) {
                return {
                    results: data.result,
                    pagination: {
                        more: (data.page * 10) < data.count_filtered

                    }
                  };
              }
            }
          });
          $('#subcategory').select2({
            ajax: {
              url: '/subcategory_dropdown',
              data: function(params) {
                var query = {
                        search: params.term,
                        page: params.page || 1,
                    }
                    // Query parameters will be ?search=[term]&page=[page]
                return query;
            },
            processResults: function(data, params) {
                return {
                    results: data.result,
                    pagination: {
                        more: (data.page * 10) < data.count_filtered

                    }
                  };
              }
            }
          });

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
                      toastr.success('Product updated successfully',"Sucesss");
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