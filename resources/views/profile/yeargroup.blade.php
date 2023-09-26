@extends('profile.includes.master')

@section('pagestyles')
    
@stop

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <div class="row">
    <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">MY YEAR GROUP</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                 <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>House</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group as $g)
                        <tr>
                           <td>{{$g->firstname}} {{$g->lastname}}</td>
                           <td>{{$g->email}}</td>
                           <td>{{$g->phone}}</td>
                           <td>{{$g->house}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                 </table>
              
              </div>
          </div>
        </div>
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

 
    

</script>


@stop