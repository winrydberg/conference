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
        <li class="active">Conference Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Conference Details</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                    <a class="btn btn-success" style="margin-bottom: 10px;" href="{{url('/new-conference')}}"><i class="fa fa-plus-circle"></i>New Conference</a>
                    @if (isset($conference))

                    <div class="table-responsive">
                        <table id="group" class="table table-bordered table-striped text-nowrap">
                            
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