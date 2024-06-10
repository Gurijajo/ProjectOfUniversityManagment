@extends('layouts.app')
@section('content')
    
<div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Teacher</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="card card-primary">
                <form method="post" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>First Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" value="{{old('name')}}" name="name" required="" placeholder="First Name">
                        <div style="color:red">{{ $errors->first('name') }}</div>
                      </div>  
  
                      <div class="form-group col-md-6">
                        <label>Last Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" value="{{old('lastname')}}" name="lastname" required="" placeholder="Last Name">
                        <div style="color:red">{{ $errors->first('last_name') }}</div>
                      </div>  
  
  
                      <div class="form-group col-md-6">
                        <label>Class <span style="color: red;">*</span></label>
                        <select class="form-control" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach ($getClass as $value)
                            <option {{ (old('class_id') == '$value->id') ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name}}</option>
                            @endforeach
                          </select>
                          <div style="color:red">{{ $errors->first('class_id') }}</div>
                      </div>  
  
                      <div class="form-group col-md-6">
                        <label>Gender <span style="color: red;">*</span></label>
                        <select class="form-control" required="" name="gender">
                            <option value="">Select Gender</option>
                            <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                            <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                            <option {{ (old('gender') == 'Other') ? 'selected' : '' }} value="Other">Other</option>                        
                        </select>
                        <div style="color:red">{{ $errors->first('gender') }}</div>
                      </div>  
  
  
                       <div class="form-group col-md-6">
                        <label>Date of Birth <span style="color: red;">*</span></label>
                        <input type="date" class="form-control" required="" value="{{old('date_of_birth')}}" name="date_of_birth">
                        <div style="color:red">{{ $errors->first('date_of_birth') }}</div>
                      </div>   
  
                      <div class="form-group col-md-6">
                        <label>Mobile Number <span style="color: red;"></span></label>
                        <input type="text" class="form-control" value="{{old('mobile_number')}}" name="mobile_number" placeholder="Mobile Number">
                        <div style="color:red">{{ $errors->first('mobile_number') }}</div>
                      </div> 
  
                      <div class="form-group col-md-6">
                        <label>Profile Pic <span style="color: red;"></span></label>
                        <input type="file" class="form-control" name="profile_pic">
                        <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                      </div> 
                       <div class="form-group col-md-6">
                        <label>Status <span style="color: red;">*</span></label>
                        <select class="form-control" required="" name="status">
                            <option value="">Select Status</option>
                            <option {{ (old('status') == 0) ? 'selected' : '' }} value="0">Active</option>
                            <option {{ (old('status') == 1) ? 'selected' : '' }} value="1">Inactive</option>
                        </select>
                        <div style="color:red">{{ $errors->first('status') }}</div>

                      </div>  
  
                    </div>
  
                    <hr>
  
  
                    
                    <div class="form-group">
                      <label>Email <span style="color: red;">*</span></label>
                      <input type="email" class="form-control" name="email" value="" required="" placeholder="Email">
                      <div style="color:red"></div>
                    </div>
                    <div class="form-group">
                      <label>Password <span style="color: red;">*</span></label>
                      <input type="password" class="form-control" name="password" required="" placeholder="Password">
                    </div>
                 
                  
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
           
  
            </div>
            <!--/.col (left) -->
            <!-- right column -->
         
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    
  </div>
@endsection