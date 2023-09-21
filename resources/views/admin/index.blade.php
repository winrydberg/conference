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
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">TOTAL CONGRESS</span>
                    <span class="info-box-number"> {{$concount}} </span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                        {{-- <span class="progress-description">
                            70% Increase in 30 Days
                        </span> --}}
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-file-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">UPCOMING CONGRESS</span>
                    <span class="info-box-number"> {{$upcomingcount}} </span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                        {{-- <span class="progress-description">
                            70% Increase in 30 Days
                        </span> --}}
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- /.col -->
            </div>



            <div class="row">
                <div class="col-md-12">
                   
  
                  <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title">Upcoming Congress</h3>
  
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div>
                    <div class="box-body">
                      @if (isset($upcoming) && count($upcoming) > 0) 
                        <div class="table-responsive">
                            <table id="group" class="table table-bordered table-striped text-nowrap">
                                <thead>
                                <tr>
                                  <th>ID#</th>
                                  <th>TITLE</th>
                                  <th>START DATE</th>
                                  <th>END DATE</th>
                                  <th>TIME</th>
                                  <th>TOTAL REGISTRATIONS</th>
                                  <th>TOTAL ABSTRACTS</th>
                                  <th>ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                        @foreach($upcoming as $key =>  $c)
                                          <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$c->title}}</td>
                                            <td>{{date('d-m-Y', strtotime($c->startdate))}}</td>
                                            <td>{{date('d-m-Y', strtotime($c->enddate))}}</td>
                                            <td>{{date('H:iA', strtotime($c->starttime))}}</td>
                                            <td>{{$c->registrants_count}}</td>
                                            <td>{{$c->abstracts_count}}</td>
                                            <td>
                                              <a href="{{url('/edit-conference?conferenceid='.$c->id)}}" class="btn btn-sm btn-info"> <i class="fa fa-edit"></i> Edit</a>
                                              {{-- <button class="btn btn-primary"> <i class="fa fa-eye"></i> Details</button> --}}
                                         
                                              <a href="{{url('/registrants?conferenceid='.$c->id)}}" class="btn btn-sm bg-navy"> <i class="fa fa-users"></i> Registrants</a>
                                              <a href="{{url('/add-documents?conferenceid='.$c->id)}}" class="btn btn-sm btn-warning"> <i class="fa fa-upload"></i> Add Documents</a>
                                            </td>
                                          </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                      @else
                         <p class="alert alert-info"> No Upcoming Conferences</p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

      
      <!-- Main row -->
    </section>
    <!-- /.content -->
</div>
@stop