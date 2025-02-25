@extends('adminlte::page')

@section('title', 'Edit Unit')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Unit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Unit</li>
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
                  Unit Details
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
              
                

                  <div class="" id="settings">
                    <form class="form-horizontal" id="form_create" method="PUT" data-url="/admin/units/{{ $unit->id }}" >
                      @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label required-field">Name</label>
                        <div class="col-sm-9">
                          <input type="text" id="name" class="form-control" required="required" value="{{$unit->name }}" name="name"  id="inputName" placeholder="Name">
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
<link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet' type="text/css">

<link href='{{ url('/vendor/adminlte/dist/css/custom.css') }}' rel='stylesheet' type="text/css">
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
                    type: "PUT",
                    url: url,
                    data: formData,
                    beforeSend: function() {
                        // setting a timeout
                        $('.error-text').text('');
                    },
                    success: function(data){
                      toastr.success('Unnit updated successfully',"Sucesss");
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