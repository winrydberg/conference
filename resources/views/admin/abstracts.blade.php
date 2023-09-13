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
        <li class="active">Abstracts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Abstracts - <strong>{{$conference?->title}}</strong></h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                    <a class="btn bg-navy" style="margin-bottom: 10px;" href="{{url('/download-all-abstracts?conferenceid='.$conference?->id)}}"><i class="fa fa-download"></i> Download All Abstracts</a>
                    <a class="btn btn-success" style="margin-bottom: 10px;" href="{{url('/export-abstracts?conferenceid='.$conference?->id)}}"><i class="fa fa-download"></i> Export To Excel</a>

                    @if(Session::has('error'))
                      <p class="alert alert-danger">{{Session::get('error')}}</p>
                    @endif
                    @if (isset($abstracts))

                    <div class="table-responsive">
                        <table id="group" class="table table-bordered table-striped text-nowrap">
                            <thead>
                            <tr>
                              <th>ID#</th>
                              <th>TITLE</th>
                              <th>SUBMITTED BY</th>
                              <th>EMAIL</th>
                              <th>CORRESPONDING AUTHOR</th>
                              <th>CORRESPONDING EMAIL</th>
                              <th>CO-AUTHORS</th>
                              <th>THEMATIC</th>
                              <th>PRESENTATION TYPE</th>
                              <th>PUBLISH PAPER</th>
                              <th>COMMENTS</th>
                              <th>STATUS</th>
                              <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($abstracts as $key =>  $c )
                                  <tr>
                                    <td>#{{$key + 1}}</td>
                                    <td>{{$c->title}}</td>
                                    <td>{{$c->firstname.' '.$c->lastname}}</td>
                                    <td>{{$c->email}}</td>
                                    <td>{{$c->corresponding_authorname}}</td>
                                    <td>{{$c->corresponding_authoremail}}</td>  
                                    <td>{{$c->coauthors}}</td>
                                    <td>{{$c->thematic}}</td>
                                    <td>{{$c->presentationtype}}</td>
                                    <td>{{$c->journal_publication}}</td>
                                    <td>{{$c->comments}}</td>
                                    <td>
                                      @if($c->approved =="Approved")
                                        <span class="badge badge-success">Approved</span>
                                      @elseif($c->approved == 'Not Approved / Rejected')
                                        <span class="badge badge-danger">Rejected/Not Approved</span>
                                      @else
                                       <span class="badge badge-danger">Not Approved</span>
                                      @endif
                                    </td>
                                    <td>
                                      <a href="{{url('/download-abstract?abstractid='.$c->id)}}" class="btn btn-sm bg-purple"> <i class="fa fa-donwload"></i> Download Abstract</a>
                                      {{-- <a href="{{url('/registrants?conferenceid='.$c->id)}}" class="btn btn-sm bg-navy"> <i class="fa fa-users"></i> Registrants</a> --}}
                                      @if($c->approved == 'Approved')
                                          <button class="btn btn-sm btn-danger" onclick="updateAbstractState('{{$c->id}}','0')">Cancel Approval</button>
                                      @else
                                          <button class="btn btn-sm btn-success" onclick="updateAbstractState('{{$c->id}}','1')">Approve Abstract</button>
                                      @endif
                                      
                                      
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
function updateAbstractState(absid, state){
  var title = "Disapprove Abstract";
  if(state == '1'){
    title = "Approving Abstract";
  }else{
    title = "Disapprove Abstract";
  }
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
                    url: "{{url('/update-abstract-state')}}",
                    method: "POST",
                    data: {abs_id: absid, state: state, _token: "{{Session::token()}}"},
                  
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