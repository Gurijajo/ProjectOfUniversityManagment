@extends('layouts.app')
@section('content')

<div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contact Support</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
            @include('_messages')
          <div class="col-md-12">
            <div class="card card-primary">
                <form action="https://api.web3forms.com/submit" method="POST" class="contact-left">
                <div class="card-body">
                    <div class="form-group">
                        <label>Full name</label>
                        <input type="hidden" name="access_key" value="b2f3ee29-2ac4-49cd-bc62-74922476d31a">
	                    <input type="text" class="form-control" name="name" placeholder="Your name" class="contact-inputs" required>
                    </div>  
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email"  placeholder="Your email" class="contact-inputs" required>
                        </div> 
                        <div class="form-group">
                            <label for="">Message</label>
                            <textarea name="messages" class="form-control" placeholder="Your message" class="contact-inputs"></textarea>
                        </div>                    
                </div>
                

                <div class="card-footer">
                <div class="h-captcha" data-captcha="true"></div>
                <p></p>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <input type="hidden" name="redirect" value="http://localhost/Project-School/teacher/contact_support">
                </div>
              </form>
            </div>
        </div>
       
      </div>
    </section>
    
  </div>

@endsection