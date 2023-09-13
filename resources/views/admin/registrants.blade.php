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
              <h3 class="box-title">Registrants - <strong>{{$conference?->title}}</strong></h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                    <a class="btn btn-success" style="margin-bottom: 10px;" href="{{url('/export-registrants?conferenceid='.$conference?->id)}}"><i class="fa fa-download"></i>Export To Excel</a>
                    @if (isset($registrants))

                    <div class="table-responsive">
                        <table id="group" class="table table-bordered table-striped text-nowrap">
                            <thead>
                            <tr>
                              <th>ID#</th>
                              {{-- <th>TITLE</th> --}}
                              <th>NAME</th>
                              <th>EMAIL</th>
                              <th>PHONE NO#</th>
                              <th>INSTITUTION</th>
                              <th>OCCUPATION / STUDENT TYPE</th>
                              <th>REG. AMOUNT</th>
                              {{-- <th>ACTION</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrants as $key =>  $c )
                                  <tr>
                                    <td>#{{$key + 1}}</td>
                                    {{-- <td>{{$c->title}}</td> --}}
                                    <td>{{$c->firstname.' '.$c->lastname}}</td>
                                    <td>{{$c->email}}</td>
                                    <td>{{$c->phone}}</td>
                                    <td>{{$c->institution}}</td>
                                    <td>{{$c->occupation == 'Other' ? $c->occupation. ' - '.$c->specify : $c->occupation }}</td>
                                    <td>{{$c->reg_currency.' '.$c->reg_amount}}</td>

                                    {{-- <td>
                                      <a href="{{url('/download-abstract?conferenceid='.$c->id)}}" class="btn btn-sm bg-purple"> <i class="fa fa-donwload"></i> Download Abstract</a>
                                      <a href="{{url('/registrants?conferenceid='.$c->id)}}" class="btn btn-sm bg-navy"> <i class="fa fa-users"></i> Registrants</a>
                                    </td> --}}
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


</script>


@stop