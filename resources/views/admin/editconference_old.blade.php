@extends('admin.includes.master')

@section('pagestyles')
    
@stop

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit  Conference</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Conference - <strong>{{$conference?->title}}</strong></h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <form method="POST" id="newConference" action="#">
                    {{csrf_field()}}
                    <input  style="display:none;" class="form-control" value="{{$conference?->id}}" name="id" id="id"/>
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Title</label>
                        <input required class="form-control" value="{{$conference?->title}}" name="title" id="title"/>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Theme</label>
                        <input  class="form-control" value="{{$conference?->theme}}" name="theme" id="theme"/>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Description</label>
                        <textarea class="form-control" rows="5" name="description" id="description">{{$conference?->description}}</textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Start Date#</label>
                        <input type="date" required value="{{$conference?->startdate}}" class="form-control" name="startdate" id="startdate"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">End Date#</label>
                        <input type="date" class="form-control" value="{{$conference?->enddate}}" name="enddate" id="enddate"/>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Start Time#</label>
                        <input type="time" class="form-control" value="{{$conference?->starttime}}" name="starttime" id="starttime"/>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">End Time#</label>
                        <input type="time" class="form-control" value="{{$conference?->endtime}}" name="endtime" id="endtime"/>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group" >
                        <label for="name">Receive Abstract?</label>
                        <select class="form-control" name="receive_abstract" id="receive_abstract">
                          <option value="0" {{$conference?->receive_abstract == '0' ? 'selected="selected': ''}}>Not Receiving Abstract</option>
                          <option value="1" {{$conference?->receive_abstract == '1' ? 'selected="selected': ''}}>Receive Abstract</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" >
                        <label for="name">Open</label>
                        <select class="form-control" name="isopen" id="isopen">
                          <option value="1" {{$conference?->isopen == '1' ? 'selected="selected"' : ''}}>Open For Registration</option>
                          <option value="0" {{$conference?->isopen == '0' ? 'selected="selected"' : ''}}>Not Opened For Registration</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <br/>

                  <legend style="margin-bottom: 20px; margin-top: 20px;">Any Downloadable Attachment(s)</legend>
                  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="firstname">Select Files</label>
                          <input id="input-id" name="documents[]" multiple  type="file" >   
                        </div>
                      </div>
                  </div>

                  <?php $attachments = json_decode($conference->attachments); ?>

                  @foreach($attachments as $a)
                    <div style="padding-top: 10px; margin-top: 10px; color: red; padding-bottom: 10px; margin-bottom: 10px;"><i class="fa fa-file"></i> <strong>{{$a}}</strong> <button type="button" onclick="deleteAttachment('{{$a}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></div>
                  @endforeach



                  <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Save Conference</button>
                      </div>
                  </div>
                </form>
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

    var pcount = 1;

    // function addField(){
    //   var cloned = $('#clone').clone().removeAttr('hidden');
    //   $("#contactpersons").append(cloned);
    //   pcount +=1
    //   if(pcount>=2){
    //     $('#removeFieldBtn').show()
    //   }else{
    //     $('#removeFieldBtn').hide()
    //   }
    // }

    // function removeField(){
    //   // $('span#orderBody').last().remove();
    //   $("#contactpersons").children("div[id=clone]:last").remove();

    //   if(pcount>=2){
    //     pcount -= 1;
    //   }

    //   if(pcount <=1){
    //     $('#removeFieldBtn').hide()
    //   }else{
    //     $('#removeFieldBtn').show()
    //   }
    // }
    


    $('#newConference').submit(function(event){
        event.preventDefault();
        
        var data = new FormData($("#newConference")[0]);
        var title = 'Editing Conference';
        Swal.fire({
            title: title,
            text: "Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
                    url: "{{url('/edit-conference')}}",
                    method: "POST",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    success: function(res){
                        if(res.status =='success'){
                            Swal.fire(
                                'Success',
                                res.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire(
                                'Error',
                                res.message,
                                'error'
                            );
                        }
                    },
                    error: function(error){
                        console.log(error),
                        Swal.fire(
                                'Error',
                                "Oops something went wrong.",
                                'error'
                            );
                    }
                   })
                }
            })
    })



    function deleteAttachment(filename){
        var conferenceid = "{{$conference?->id}}";
        Swal.fire({
            title: "Delete Attachment => "+ filename,
            text: "Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
                    url: "{{url('/delete-attachment')}}",
                    method: "POST",
                    data: {id: conferenceid, file: filename, _token:"{{Session::token()}}"},

                    success: function(res){
                        if(res.status =='success'){
                            Swal.fire(
                                'Success',
                                res.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire(
                                'Error',
                                res.message,
                                'error'
                            );
                        }
                    },
                    error: function(error){
                        console.log(error),
                        Swal.fire(
                                'Error',
                                "Oops something went wrong.",
                                'error'
                            );
                    }
                   })
                }
            })
    }

</script>


@stop