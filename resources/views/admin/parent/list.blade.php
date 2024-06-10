@extends('layouts.app')
@section('content')
    

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parent List (Total: {{ $getRecord->Total()}})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{url('admin/parent/add')}}" class="btn btn-primary">Add New Parent</a>
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
              <h3 class="card-title">Search Parent</h3>
            </div>
            <form action="" method="get">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="">First Name</label>
                    <input type="text" class="form-control" value="{{Request::get('name')}}" name="name" placeholder="Name">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Last Name</label>
                    <input type="text" class="form-control" value="{{ Request::get('lastname') }}" name="lastname" placeholder="Last Name">
                    </div>
                  <div class="form-group col-md-3">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" value="{{Request::get('email')}}" placeholder="Email">
                  </div>
                  {{-- <div class="form-group col-md-2">
                    <label>Class</label> 
                    <input type="text" class="form-control" name="class" value="{{ Request::get('class') }}" placeholder="Class">
                    </div> --}}
                  {{-- <div class="form-group col-md-2">
                    <label>Gender</label>
                    <select class="form-control" name="gender">
                    <option value="">Select Gender</option>
                    <option {{ (Request::get('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                    <option {{ (Request::get('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                    <option {{ (Request::get('gender') == 'Other') ? 'selected' : '' }} value="Other">Other</option>
                    </select>
                    </div> --}}
                    {{-- <div class="form-group col-md-2">
                        <label>Status</label>
                        <select class="form-control" name="status">
                        <option value="">Select Status</option>
                        <option {{ (Request::get('status') == 0) ? 'selected' : '' }} value="0">Active</option>
                        <option {{ (Request::get('status') == 1) ? 'selected' : '' }} value="1">Inactive</option>
                        </select>     
                    </div>                  --}}
                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                    <a href="{{url('admin/parent/list')}}" class="btn btn-success" style="margin-top: 30px;">Reset </a>
                  </div>
                </div>
              </div>
            </form>

            @include('_messages')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Parent List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto; text-wrap: nowrap;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile Pic</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Occupation</th>
                      <th>Mobile Number</th>
                      <th>Address</th>
                      <th>Status</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getRecord as $value)
                      <tr>
                        <td>{{$value->id}}</td>
                        <td>
                            @if(!empty($value->getProfile()))
                              <img src="{{ $value->getProfile() }}" style="height: 50px; width: 50px; border-radius: 50px;">
                            @endif
                        </td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->lastname }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->gender }}</td>
                        <td>{{ $value->occupation }}</td>
                        <td>{{ $value->mobile_number }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ ($value->status == 0) ? 'Active': 'Inactive' }}</td>
                        <td>{{$value->created_at}}</td>
                        <td style="min-width: 150px">
                          <a href="{{url('admin/parent/edit', $value->id)}}" class="btn btn-primary btn-sm">Edit</a>
                          <a href="{{url('admin/parent/delete', $value->id)}}" class="btn btn-danger btn-sm">Delete</a>
                          {{-- <a href="{{url('admin/parent/my-student', $value->id)}}" class="btn btn-primary btn-sm">My Student</a> --}}
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