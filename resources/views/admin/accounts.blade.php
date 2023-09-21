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
        <li class="active">Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-5">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Account</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <form method="POST" id="adduserAccount" action="#">
                    {{csrf_field()}}
                  <div class="form-group">
                    <label for="name">Auth Type</label>
                    <select class="form-control" name="authtype" id="authtype" >
                        <option value="username">Username</option>
                    </select>
                  </div>
                  <div class="form-group" id="usernamecont">
                    <label for="name">Username</label>
                    <input class="form-control"  name="username" id="username"/>
                  </div>

                  <div class="form-group">
                    <label for="name">Role</label>
                    <select class="form-control" required name="role" id="role" >

                        <option value="">Select an option</option>
                        @foreach ($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                        
                    </select>
                  </div>
                 

                  <span id="staffinfo" hidden>
                      <div class="form-group" id="staffidcont">
                        <label for="name">Staff ID</label>
                        <input class="form-control"  name="staff_id" id="staff_id"/>
                      </div>
                      <div class="form-group" id="namecont">
                        <label for="name">Name</label>
                        <input class="form-control"  name="staffname" id="staffname"/>
                      </div>
    
                      <div class="form-group" id="emailcont">
                        <label for="name">Email</label>
                        <input class="form-control"  name="email" id="email"/>
                      </div>
                  </span>
                  

                  <div class="form-group" >
                    <label for="name">Password / Staff PIN</label>
                    <input type="password" class="form-control" name="password" id="password"/>
                  </div>

                  <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add User</button>
                </form>
              </div>
          </div>
        </div>

        <div class="col-md-7">
            <!-- general form elements -->
                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Accounts / Users</h3>
                </div>
                <!-- /.box-header -->
                    <div class="box-body">
                    
                        <table id="group" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>ROLES</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user )
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <?php
                                                $theroles = [];
                                                if($user->roles != null){
                                                    foreach ($user->roles as $key => $r) {
                                                        array_push($theroles, $r->name);
                                                    }
                                                }
                                            ?>
                                            {{implode(',', $theroles)}}
                                        </td>
                                        <td>
                                            {{-- <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button> --}}
                                            <button class="btn btn-danger" onclick="deleteUser('{{$user->id}}')"><i class="fa fa-trash"></i> Delete</button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $('#authtype').on('change', function(){
        var selected = $('#authtype').val();
        if(selected == 'staffid') {
            $('#staffinfo').removeAttr('hidden');
            $('#usernamecont').attr('hidden', 'hidden');
            $("#email").prop('readonly', true);
            $("#staffname").prop('readonly', true);
            $("#password").prop('readonly', true);
        }else{
            $('#usernamecont').removeAttr('hidden');
            $('#staffinfo').attr('hidden', 'hidden');
            $("#email").prop('readonly', false);
            $("#staffname").prop('readonly', false);
            $("#password").prop('readonly', false);
        }
    })


    $('#staff_id').on('blur', function(){
        var staff_id = $('#staff_id').val();
        $.ajax({
            url: "{{url('/staff-info')}}",
            method: "POST",
            data: {staff_id: staff_id, _token:"{{Session::token()}}"},
            success: function(res){
                if(res.status =='success'){
                    var staffdata = res.staff;
                    $('#staffname').val(staffdata.othernames+' '+staffdata.surname)
                    $('#email').val(staffdata.email)
                    $('#password').val(staffdata.pin)
                }else{
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function(error){
                console.log(error),
                Swal.fire(
                        'Error',
                        "Unable to get staff info",
                        'error'
                    );
            }
           })
    })

    $('#adduserAccount').submit(function(event){
        event.preventDefault();
        
        var data = $(this).serialize()
        var title = 'Add User Account';
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
                    url: "{{url('/accounts')}}",
                    method: "POST",
                    data: data,
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

    function deleteUser(id){
        var title = 'Delete User Account';
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
                    url: "{{url('deleteuser')}}",
                    method: "POST",
                    data: {id: id, _token: "{{Session::token()}}"},
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