@extends('layouts.app')
@section('content')
    
<div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Admin</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" required placeholder="Name">
                      </div>  
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control"  name="email"  required  value="{{old('email')}}" placeholder="Email">
                    <div style="color: red">{{$erorrs->first('email')}}</div>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control"  name="password" required  placeholder="Password">
                  </div>
                </div>
                

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
        </div>
       
      </div>
    </section>
    
  </div>
@endsection