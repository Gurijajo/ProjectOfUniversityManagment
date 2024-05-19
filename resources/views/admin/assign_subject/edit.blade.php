@extends('layouts.app')
@section('content')


<div class="content-wrapper" style="min-height: 730.4px;">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Assign Subject</h1>
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
                 <input type="hidden" name="_token" value="z9LLrOHe4F1woH3skjkhzxWotwIFVVDjEJR6VFst">
                <div class="card-body">
                  <div class="form-group">
                    <label>Class Name</label>
                     <select class="form-control" name="class_id" required="">
                        <option value="">Select Class</option>
                                                  <option value="3">PART TIME</option>
                                                  <option selected="" value="1">SS1</option>
                                                  <option value="2">SS2</option>
                                                  <option value="4">SS2 (ARTS and SCIENCE)</option>
                                                  <option value="5">SS3</option>
                                            </select>

                  </div>


                   <div class="form-group">
                    <label>Subject Name</label>
                                                                                                           
                                                                                                                                                     
                                                                                     
                                                                                     
                                                                                     
                                                                                  <div>
                          <label style="font-weight: normal;">
                            <input checked="" type="checkbox" value="7" name="subject_id[]"> AGRIC SCIENCE
                          </label>
                          </div>
                                                                                                           
                                                                                     
                                                                                                                                                     
                                                                                     
                                                                                     
                                                                                  <div>
                          <label style="font-weight: normal;">
                            <input checked="" type="checkbox" value="4" name="subject_id[]"> BASIC SCIENCE AND TECHNOLOGY
                          </label>
                          </div>
                                                                                                           
                                                                                     
                                                                                     
                                                                                                                                                     
                                                                                     
                                                                                  <div>
                          <label style="font-weight: normal;">
                            <input checked="" type="checkbox" value="6" name="subject_id[]"> BASIC TECHNOLOGY
                          </label>
                          </div>
                                                                                                           
                                                                                     
                                                                                     
                                                                                     
                                                                                                                                                     
                                                                                  <div>
                          <label style="font-weight: normal;">
                            <input checked="" type="checkbox" value="2" name="subject_id[]"> ENGLISH LANGUAGE
                          </label>
                          </div>
                                                                                                           
                                                                                     
                                                                                     
                                                                                     
                                                                                     
                                                                                                                                                  <div>
                          <label style="font-weight: normal;">
                            <input checked="" type="checkbox" value="5" name="subject_id[]"> HOME ECONOMICS
                          </label>
                          </div>
                                                                                                           
                                                                                     
                                                                                     
                                                                                     
                                                                                     
                                                                                  <div>
                          <label style="font-weight: normal;">
                            <input type="checkbox" value="1" name="subject_id[]"> MATHEMATICS
                          </label>
                          </div>
                                                                                                           
                                                                                     
                                                                                     
                                                                                     
                                                                                     
                                                                                  <div>
                          <label style="font-weight: normal;">
                            <input type="checkbox" value="3" name="subject_id[]"> SOCIAL STUDIES
                          </label>
                          </div>
                                          </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option selected="" value="0">Active</option>
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
      </div>
    </section>
  </div>


  @endsection