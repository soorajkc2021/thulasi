@extends('adminlte::page')

@section('title', 'Users')
    @section('content_header')

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
     @stop

     @section('content')

        <div class="card">
          <div class="card-header">
            <a href="/admin/user/add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New</a>

          </div>
          <!-- /.card-header -->
          @if($users->count())
          <div class="card-body">
            <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($users as $key => $user)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                          <a href="/admin/user/edit/{{ $user->id }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                          <a  href="/admin/user/delete/{{ $user->id }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
@stop

@section('js')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script> 
      $(document).ready(function(){
        $("#example1").DataTable();
      
      });
   </script>
@stop