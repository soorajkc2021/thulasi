@extends('layouts.admin')

@section('title', 'Profile')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active"> Profile</li>
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
                    Personal Details
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
              
                 

                  <div class="" id="settings">
                    <form class="form-horizontal" id="form_create"  method="POST" data-url="/admin/profile/{{$user->id}}" >
                      @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name" value="{{ $user->name }}" id="inputName" placeholder="Name">
                          <span id="error_name" class="error-text text-danger pull-right" style=""></span>
                       
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" value="{{ $user->email }}" id="inputEmail" placeholder="Email">
                          <span id="error_email" class="error-text text-danger pull-right" style=""></span>
                        
                        </div>
                      </div>
                      <div class="form-group row ">

                        <label for="inputEmail" class="col-sm-2 col-form-label">Update Password</label>
                          <input type="hidden" name="update_password" value="0">
                          <div class="col-sm-10 switch-checkbox">
                            <label class=" switch">
                              <input type="checkbox" value="1" id="update_password" name="update_password">
                              <span class="slider round"></span>
                            </label>
                          </div>
                      </div>
                      <div class="form-group row password_updation" style="display: none">
                        <label for="inputEmail" class="col-sm-2 col-form-label required-field">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control"  name="password" id="inputPassword" placeholder="Password">
                          <span id="error_password" class="error-text text-danger pull-right" style=""></span>

                        </div>
                      </div>

                      <div class="form-group row password_updation" style="display: none">
                        <label for="inputEmail" class="col-sm-2 col-form-label required-field">Confirm Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control"  name="password_confirmation" id="inputConfirmPassword" placeholder="Password">
                          <span id="error_password_confirmation" class="error-text text-danger pull-right" style=""></span>

                        </div>
                      </div>
                    
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
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
        <link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet' type="text/css">
        <link href='{{ url('/adminlte/dist/css/custom.css') }}' rel='stylesheet' type="text/css">
        
  @stop
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        
  @section('js')
    <script> 
        $(document).ready(function(){

          $("#editSubmit").click(function(){
              var formData  =  $('#form_create').serialize(); 
              var url  =  $('#form_create').data('url'); 
              
              $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    beforeSend: function() {
                        // setting a timeout
                        $('.error-text').text('');
                    },
                    success: function(data){
                      toastr.success('user updated successfully',"Sucesss");
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
          $("#update_password").change(function(){
                    
                    if($(this).is(':checked')){
                      $('.password_updation').show();
                    }else{
                      $('.password_updation').hide();
                    }
              
              
            })
        });
    </script>
@stop