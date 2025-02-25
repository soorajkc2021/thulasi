@extends('adminlte::page')

@section('title', 'Edit SubCategory')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit SubCategory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit SubCategory</li>
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
                    <form class="form-horizontal" id="form_create" method="PUT" data-url="/admin/subcategories/{{ $category->id }}" >
                      @csrf

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label required-field">Category</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" id="category" name="category" style="width: 100%;">
                            @if($category->parent)
                              <option value="{{ $category->parent->id }}" selected>{{ $category->parent->name }}</option>
                            @endif
                          </select>
                          <span id="error_category" class="error-text text-danger pull-right" style=""></span>
                 
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label required-field">SubCategory Name</label>
                        <div class="col-sm-9">
                          <input type="text" id="name" class="form-control" required="required" value="{{$category->name }}" name="name"  id="inputName" placeholder="Name">
                          <span id="error_name" class="error-text text-danger pull-right" style=""></span>
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
                      toastr.success('Category updated successfully',"Sucesss");
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