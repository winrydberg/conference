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
        <li class="active">Alumni</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">ALUMNI</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                    <a class="btn btn-success" style="margin-bottom: 10px;" href="{{url('/alumni-export')}}"><i class="fa fa-plus-circle"></i>Export Alumi Data</a>
                    @if (isset($users))

                    <div class="table-responsive">
                        <table id="group" class="table table-bordered table-striped text-nowrap">
                            <thead>
                            <tr>
                              <th>ID#</th>
                              <th>TITLE</th>
                              <th>NAME</th>
                              <th>EMAIL</th>
                              <th>PHONE NO</th>
                              <th>YEAR GROUP</th>
                              <th>HOUSE</th>
                              {{-- <th>ACTION</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key =>  $c )
                                  <tr>
                                    <td>#{{$key + 1}}</td>
                                    <td>{{$c->title}}</td>
                                    <td>{{$c->firstname." ".$c->lastname}}</td>
                                    
                                    <td>{{$c->email}}</td>
                                    <td>{{$c->phone}}</td>
                                    <td>{{$c->yeargroup}}</td>
                                    <td>{{$c->house}}</td>

                                   
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