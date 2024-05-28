@extends('layouts.app')
@section('content')
    

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin List (Total: {{ $getRecord->Total()}})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{url('admin/admin/add')}}" class="btn btn-primary">Add New Admin</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            <div class="card-header">
              <h3 class="card-title">Search Admin</h3>
            </div>
            <form action="" method="get">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control" value="{{Request::get('name')}}" name="name" placeholder="Name">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" value="{{Request::get('email')}}" placeholder="Email">
                  </div>
                  {{-- <div class="form-group col-md-3">
                    <label for="">Date</label>
                    <input type="date" name="date" class="form-control" value="{{Request::get('date')}}" placeholder="Date">
                  </div> --}}

                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                    <a href="{{url('admin/admin/list')}}" class="btn btn-success" style="margin-top: 30px;">Reset </a>
                  </div>
                </div>
              </div>
            </form>

            @include('_messages')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admin List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getRecord as $value)
                      <tr>
                        <td>{{$value->id}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->created_at}}</td>
                        <td>
                          <a href="{{url('admin/admin/edit', $value->id)}}" class="btn btn-primary">Edit</a>
                          @if($value->id!=1)
                          <a href="{{url('admin/admin/delete', $value->id)}}" class="btn btn-danger">Delete</a>
                          @endif
                        </td>
                      </tr>
                         
                    @endforeach 
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
              </div>              
              </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection