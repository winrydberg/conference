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
        <li class="active">Add Conference Documents</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-5">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Add Documents- <strong>{{$conference?->title}}</strong></h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <p style="margin-top: 15px; margin-bottom: 15px;">Use the form below to upload downloadable documents for conference. <strong>{{$conference->title}}</strong></p>
                <form method="POST" id="addDocument" action="#">
                    {{csrf_field()}}
                    <input  style="display:none;" class="form-control" value="{{$conference?->id}}" name="id" id="id"/>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Document Type</label>
                        <input class="form-control"  name="doctype" id="doctype"/>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Select File</label>
                        <input type="file" class="form-control"  name="file" id="file"/>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Document</button>
                      </div>
                  </div>
                </form>
              </div>
          </div>
        </div>

        <div class="col-md-7">
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Conference Documents</h3>
              </div>
              <!-- /.box-header -->
                <div class="box-body">
                     <table class="table table-striped">
                        <thead>
                            <th>Type</th>
                            <th>File Name</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            @foreach($documents as $d)
                                <tr>
                                    <td>{{$d->type_name}}</td>
                                    <td>{{$d->file}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="deleteDoc('{{$d->id}}')"> <i class="fa fa-trash"></i> Delete</button>
                                    </td>
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


    


    $('#addDocument').submit(function(event){
        event.preventDefault();
        
        var data = new FormData($("#addDocument")[0]);
        var title = 'Adding Document';
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
                    url: "{{url('/add-documents')}}",
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



    function deleteDoc(id){
        var conferenceid = "{{$conference?->id}}";
        Swal.fire({
            title: "Deleting Document",
            text: "Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
                    url: "{{url('/delete-document')}}",
                    method: "POST",
                    data: {id: id, confid: conferenceid, _token:"{{Session::token()}}"},

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