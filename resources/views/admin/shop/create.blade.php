@extends('layouts.admin')

@section('title', 'Create Shops')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Shops</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Create Shops</li>
            </ol>
          </div>
        </div>
     @stop

     @section('content')

        <div class="row">
          
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <div class="ml-10">
                  Shop Details
                </div>
              </div><!-- /.card-header -->

         
              <div class="card-body">
                  <div class="" id="settings">
                    <form class="form-horizontal" id="form_create" method="POST" data-url="/admin/shops" >
                      @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label required-field">Shop Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name"  id="inputName" placeholder="Shop Name">
                          <span id="error_name" class="error-text text-danger pull-right" style=""></span>

                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label required-field">Shop Address</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="address"  id="inputName" placeholder="Address">
                          <span id="error_address" class="error-text text-danger pull-right" style=""></span>

                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label required-field">Shop Location (City)</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="city"  id="inputName" placeholder="City">
                          <span id="error_city" class="error-text text-danger pull-right" style=""></span>

                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">

                          
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Contact Name</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="contact_name"  id="inputName" placeholder="Contact Name">
                              <span id="error_contact_name" class="error-text text-danger pull-right" style=""></span>
    
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label required-field">Contact Phone</label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">+91</span>
                                  </div>
                                  <input type="text" class="form-control"  name="contact_phone"  placeholder="Contact Number" data-mask="" inputmode="text">
                                  
                                </div>
                                <span id="error_contact_phone" class="error-text text-danger pull-right" style=""></span>
                              
                            </div>
                              
                          </div>


                         
                        </div>
                      </div>
                     
                      
                    
                     
                      <div class="form-group row">
                        <div class="offset-sm-3 col-sm-9">
                          <button type="button" id="profileSubmit" class="btn btn-danger">Submit</button>
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

<link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet' type="text/css">

@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        
        $(document).ready(function(){
            $("#profileSubmit").click(function(){
              var formData  =  $('#form_create').serialize(); 
              var url  =  $('#form_create').data('url'); 
              $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data){
                      if(data.message == 'success'){
                          toastr.success('Shop created successfully',"Sucesss");
                          window.location.href = data.url;
                      }
                    },
                    beforeSend: function() {
                        // setting a timeout
                        $('.error-text').text('');
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