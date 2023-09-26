@extends('profile.includes.master')

@section('pagestyles')
    
@stop

@section('content')
<div class="content-wrapper">
 <?php   
  $user = Auth::user();
 ?>
    <!-- Main content -->
    <section class="content">
    <div class="row">
       
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{asset('assets/img/profile.png')}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{$user->firstname}} {{$user->lastname}}</h3>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i>Email</strong>

              <p class="text-muted">
               {{$user->email}}
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Phone</strong>

              <p class="text-muted">{{$user->phone}}</p>

              <hr>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
        @if(Session::has('success'))
         <div class='alert alert-success'>{{Session::get('success')}}</div>
        @endif
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Profile</a></li>
              <li><a href="#timeline" data-toggle="tab">Payment</a></li>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
             <div class='row'>
                <div class='col-sm-12'>
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>Date/Time</th>
                                <th>Amount</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $p)
                            <tr>
                                <td>{{$p->created_at}}</td>
                                <td>{{$p->reg_amount}}</td>
                                <td>{{$p->reg_no}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
             </div>
            
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane active" id="settings">
                <form class="form-horizontal" method='POST' action='{{url("/save-profile")}}'>
                    @csrf
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Title</label>

                    <div class="col-sm-10">
                      <select class="form-control" id="title" name='title'>
                        <option value="" disabled selected>Title</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option>   
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">First Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="firstname" placeholder="Firstname" value="{{$user->firstname}}" name='firstname'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="lastname" placeholder="Lastname" value="{{$user->lastname}}" name='lastname'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="email" placeholder="Email" value='{{$user->email}}' name='email'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="house" class="col-sm-2 control-label">House</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="house" placeholder="House" value='{{$user->house}}' name='house'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="year-group" class="col-sm-2 control-label">Year Group</label>

                    <div class="col-sm-10">
                    <select class="wide required form-control" id="yearcompleted" name="yeargroup">
                                    <option value="" disabled selected>Select an option</option>             
                    </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Current Status</label>

                    <div class="col-sm-10">
                    <select class="wide required form-control" id="status" name="status">
                        <option value="">Select an option</option>
                        <option value="Student">Student</option>
                        <option value="Working Class">Working Class</option> 
                        <option value="Student/Working Class">Student/Working Class</option>                
                    </select>
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
    </section>
    <!-- /.content -->
  </div>

  <div class="row" id="clone" hidden>
    <div class="col-md-4">
      <div class="form-group" id="usernamecont">
        <label for="name">Person Name</label>
        <input type="text" class="form-control"  name="contactname[]" id="contactname"/>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group" id="usernamecont">
        <label for="name">Phone No#</label>
        <input type="text" class="form-control"  name="contactphone[]" id="contactphone"/>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group" id="usernamecont">
        <label for="name">Email Address</label>
        <input type="text" class="form-control"   name="contactemail[]" id="contactemail"/>
      </div>
    </div>
  </div>
@stop


@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/filetype.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/fileinput.min.js"></script>
<script>
    $(document).ready(function() {
      // with plugin options
        $("#input-id").fileinput({'previewFileType': 'any', 'showUpload': false, 'maxFileCount': 0});
    });
</script>
<script>
   $(function(){

var startyear = 1950;

for(i=startyear; i< parseInt(new Date().getFullYear()); i++){
     
    $('#yearcompleted').append(` <option value="${i}">${i}</option>`);
}
$('#yearcompleted').val('{{$user->yeargroup}}')

})
 
    

</script>


@stop