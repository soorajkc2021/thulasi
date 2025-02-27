@extends('layouts.admin')

@section('title', 'Show Order')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Show Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Show Order</li>
            </ol>
          </div>
        </div>
     @stop

     @section('content')

        <div class="row">
         
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <div class="text-right">
                  @if($order->status == "Paid")
                    <a id="cancelOrder" href="/cancel_order/{{ $order->id }}" class="btn btn-danger">Cancel Order</a>
                  @else
                    <span class="text-danger">Order Cancelled</span>
                  @endif
                </div>
      
              </div>
              <div class="card-body">
              
                  <h4>Order Details</h4>
                  <br>

                  <div class="row mt-20">
                    <div class="col-sm-4 col-md-2">
                      <h6 class="text-center">Order Code</h6>
      
                      <div class="color-palette-set text-center">
                        {{ $order->code }}
                      </div>
                    </div>
                   
                    <!-- /.col -->
                    <div class="col-sm-4 col-md-2">
                      <h6 class="text-center">User</h6>
      
                      <div class="color-palette-set text-center">
                        {{ @$order->user->name }}
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-md-2">
                      <h6 class="text-center">Status</h6>
      
                      <div class="color-palette-set text-center">
                        {{ $order->status }}
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-md-2">
                      <h6 class="text-center ">Total</h6>
      
                      <div class="color-palette-set text-center">
                        {{ $order->total_sell_price }}
                      </div>
                    </div>
                     <!-- /.col -->
                    <div class="col-sm-4 col-md-2">
                      <h6 class="text-center">Shop</h6>
      
                      <div class="color-palette-set text-center">
                        {{ @$order->shop->name }}
                      </div>
                    </div>
                   
                    <!-- /.col -->
                  </div>
                
                  <br>
                  <h4>Products</h4>
                  <div class="" id="settings">
                    <form class="form-horizontal" id="form_create" method="PUT" data-url="/orders/{{ $order->id }}" >
                     
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Product</th>
                          <th>Unit</th>
                          <th>Unit Price</th>
                          <th>Quantity</th>
                          <th>Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($order->products  as $key => $product)
                            <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>{{ $product->product->name }}</td>
                              <td>{{@$product->inventory->unit->name }} - {{ @$product->inventory->unit_quantity }}</td>
                              <td>{{ $product->unit_price }}</td>
                              <td>{{ $product->quantity }}</td>
                              <td>{{ $product->total_price }}</td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
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
            
        });
    </script>
@stop