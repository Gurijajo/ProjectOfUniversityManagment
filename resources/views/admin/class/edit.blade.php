@extends('layouts.app')
@section('content')
    
<div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Class</h1>
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
                        <label>Class Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name', $getRecord->name)}}" required placeholder="Class Name">
                      </div>  
                      <div class="form-group">
                        <select class="form-control" name="status" value="{{old('status', $getRecord->status)}}">
                            <label>Status</label>
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
        </div>
       
      </div>
    </section>
    
  </div>
@endsection