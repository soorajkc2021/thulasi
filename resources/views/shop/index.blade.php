@extends('layouts.user')

@section('title', 'Shops')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Shops</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Shops</li>
            </ol>
          </div>
        </div>
     @stop

     @section('content')

        <div class="card">
          <div class="card-header">
 
          </div>
          <!-- /.card-header -->
          @if($shops ->count())
          <div class="card-body ">
            <div class="table-responsive">
            <table id="example1" class="table  table-bordered table-striped">
              <thead>
              <tr>
                <th>Shop Name</th>
                <th>Shop Address</th>
                <th>Shop Location</th>
                <th>Contact Name</th>
                <th>Contact Number</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($shops  as $shop)
                  <tr>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->address }}</td>
                    <td>{{ $shop->city }}</td>
                    <td>{{ $shop->contact_name }}</td>
                    <td>{{ $shop->contact_phone }}</td>
                    <td>
                      
                        <a href="/shops/{{ $shop->id }}" class="btn btn-primary"><i class="fa fa-plus"></i>Order</a>
                      
                      </td>
                  </tr>
                @endforeach

              </tbody>
              
            </table>
          </div>
        </div>

          <!-- /.card-body -->
          @endif
        </div>
        @stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
<link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet' type="text/css">

@stop

@section('js')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script> 
      $(document).ready(function(){
        $("#example1").DataTable();

        
      
      });

     
   </script>
@stop