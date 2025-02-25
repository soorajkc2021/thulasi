@extends('adminlte::page')

@section('title', 'Shop Details')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-12 col-md-6 col-lg-6">
            <h1>Shop Details</h1>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Shop Details</li>
            </ol>
          </div>
        </div>
     @stop

     @section('content')
     <form class="form-horizontal" id="form_create"  data-create_url="/orders/create" method="POST" data-url="/orders" >
        
      <div class="row">
          <div class="col-md-12">
              @csrf
            <div class="card">
              
              <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                      

                      <div class="card card-primary">
                        <div class="card-header p-2">
                          Most Orders
                        </div>
                        <div class="card-body scroll">

                          @if($mostproducts->count())
                          @foreach ($mostproducts as $product)
                            
                            <p class="text-muted"> <strong>{{ $product->name }} -  ({{ $product->qty }})</strong></p>
                            <hr>
                          @endforeach
                          @endif
                        </div>
                        <!-- /.card-body -->
                      </div>
                    </div>

                    
                    <div class="col-md-9">

                      @include('shop.create')
                      
                      <!-- /.card -->
                    </div>
                  </div>
                  <!-- /.tab-pane -->
              
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
          </div>
        
      </div>

      <div class="row">
        <div class="col-md-12">
                      
          
              <div class="card">
                          
                <div class="card-body">
                  <div class="table-responsive">

                    <table class="table table-bordered  order-table">
                      <thead>
                        <tr>
                          <th >#</th>
                              <th>Product</th>
                              <th>Inventory</th>
                              <th >Quantity</th>
                              <th>Sell Price</th>
                              <th>Total Price</th>
                              <th >Action</th>
                        </tr>
                      </thead>
                      <tbody id="productTable">
                      </tbody>
                      <tfoot id="productTableFoot">
                      
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="form-group row" id="orderDiv" style="display:none">
                    <div class="offset-sm-10 col-sm-2 ">
                      <button type="button" id="createOrder" class="btn btn-danger"><i class="fa fa-shopping-bag"> Create Order</i></button>
                    </div>
                  </div>
                </div>
              </div>

        </div>
      </div>

    </form>
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
          
          
          $('#product').select2({
            ajax: {
              url: '/product_dropdown',
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
            $("#addProduct").click(function(){
              var formData = new FormData();
              var fd  =  $('#form_create').serializeArray(); 
              var index = $('#productTable tr').length +1; 
              $.each(fd,function(key,input){
                formData.append(input.name,input.value);
              });
              formData.append('key',index);
              var url  =  $('#form_create').data('create_url'); 
              $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    dataType: "json",
                    processData: false, // Important for FormData
                    contentType: false, 
                    beforeSend: function() {
                        // setting a timeout
                        $('.error-text').text('');
                    },
                    success: function(data){
                      if(data.html){
                        toastr.success('Success messages',"Sucesss");
                        $('#productTable').append(data.html);
                        order_summary();
                      }
                       
                      if(data.status == "failed"){
                        toastr.error(data.message,"Eoorr");
                      }
                      
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
            $('#product').on('change', function() {
              var product = $(this).val();
              $('#inventory').empty();
              $('#inventory').select2({
                ajax: {
                  url: '/inventory_dropdown',
                  data: function(params) {
                    var query = {
                            search: params.term,
                            page: params.page || 1,
                            product :product
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
            });

            $('#inventory').on('change', function() {
              var inventory = $(this).val();

              $.ajax({
                    type: "GET",
                    url: '/inventory_dropdown_change',
                    data: {inventory:inventory},
                    dataType: "json", 
                    beforeSend: function() {
                    },
                    success: function(data){
                    
                      if(data.inventory){
                        $('#cost_price').val(data.inventory.cost_price);
                        $('#sell_price').val(data.inventory.sell_price);
                        $('#quantity').val(1);
                      }
                    },
                   
                    error: function(data) {
                      
                       
                    },
                });
            });


            $(document).on('click','.remove_product',function(){
              
              $(this).closest('tr').remove();
              order_summary();
            });

            $("#createOrder").click(function(){
              var formData = $('#form_create').serialize(); 
             
              var url  =  $('#form_create').data('url'); 
              $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        // setting a timeout
                        $('.error-text').text('');
                    },
                    success: function(data){
                        if(data.status =="success"){
                          toastr.success('Success messages',"Success");
                          location.href ='/orders';
                        }else{
                          toastr.error('Order failed',"Error");
                        }
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

        function order_summary(){
         
          var formData  =  $('#form_create').serialize(); 
         
          $.ajax({
                    type: "POST",
                    url: '/order_summary',
                    data: formData,
                    dataType: "html", 
                    success: function(data){
                        if(data == ''){
                          $('#orderDiv').hide();
                        }else{
                          $('#orderDiv').show();
                        }
                        $('#productTableFoot').html(data);
                         
                      
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
            
            
        }
    </script>
@stop