@extends('admin.includes.master')


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
        <li class="active">Conferences</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Conferences</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                    <a class="btn btn-success" style="margin-bottom: 10px;" href="{{url('/new-conference')}}"><i class="fa fa-plus-circle"></i>New Conference</a>
                    @if (isset($conferences))

                    <div class="table-responsive">
                        <table id="group" class="table table-bordered table-striped text-nowrap">
                            <thead>
                            <tr>
                              <th>ID#</th>
                              <th>TITLE</th>
                              <th>THEME</th>
                              
                              <th>START DATE</th>
                              <th>END DATE</th>
                              <th>TIME</th>
                              <th>TOTAL REGISTRATIONS</th>
                              <th>TOTAL ABSTRACTS</th>
                              <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($conferences as $key =>  $c )
                                  <tr>
                                    <td>#{{$key + 1}}</td>
                                    <td>{{$c->title}}</td>
                                    <td>{{$c->theme}}</td>
                                    
                                    <td>{{date('d-m-Y', strtotime($c->startdate))}}</td>
                                    <td>{{date('d-m-Y', strtotime($c->enddate))}}</td>
                                    <td>{{date('H:iA', strtotime($c->starttime))}}</td>
                                    <td>{{$c->registrants_count}}</td>
                                    <td>{{$c->abstracts_count}}</td>
                                    <td>
                                      <a href="{{url('/edit-conference?conferenceid='.$c->id)}}" class="btn btn-sm btn-info"> <i class="fa fa-edit"></i> Edit</a>
                                      <a href="{{url('/view-abstract?conferenceid='.$c->id)}}" class="btn btn-sm bg-purple"> <i class="fa fa-file"></i> View Abstracts</a>
                                      <a href="{{url('/registrants?conferenceid='.$c->id)}}" class="btn btn-sm bg-navy"> <i class="fa fa-users"></i> Registrants</a>
                                      <a href="{{url('/add-documents?conferenceid='.$c->id)}}" class="btn btn-sm btn-warning"> <i class="fa fa-upload"></i> Add Documents</a>
                                      <button onclick="deleteConference('{{$c->id}}')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Delete</a>
                                    </td>
                                  </tr>
                                @endforeach                        
                            </tbody>
                        </table>
                    </div>
                    @endif
              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@stop


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function deleteConference(id){
  Swal.fire({
            title: "Deleting Conference",
            text: "Are you sure? Action cannot be undone",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
                    url: "{{url('/delete-conference')}}",
                    method: "POST",
                    data: {id: id, _token:"{{Session::token()}}"},

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