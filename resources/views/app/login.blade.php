@extends('app.includes.master')

@section('pagestyles')
<style>
    #wizard_container {
        width: 100%;
    }
	.error {
		color: red;
	}
</style>
@stop

@section('content')
<div class="container-fluid full-height">
    <div class="row row-height">
        <div class="col-lg-7 content-left" style="background-image: url('{{asset('/assets/img/mawuli-population.jpg')}}'); background-repeat: no-repeat; background-size: cover;">
            <div class="content-left-wrapper" style="width: 100%; align-self:center;">
                <div class="col-md-12" style="display:flex; align-items:center; justify-content:center; flex-direction:column;">
                   
                    
                    {{-- <p>Login to Proceed</p> --}}

                    <br />
                </div>
            
                <div class="copy">© {{date('Y')}} DIGICODE SYSTEMS</div>
            </div>
            <!-- /content-left-wrapper -->
        </div>
        <!-- /content-left -->

        <div class="col-md-5">
           
            <div id="wizard_container" style="margin-bottom: 50px; display:flex: align-items:center; justify-content:center;">

                  
                    <div class="col-md-12" style="margin-top: 100px;">
                        <div style="display:flex; align-items:center; justify-content: center; flex-direction: column;">
                            <img src="{{asset('assets/img/mawuli.png')}}" style="height: 6rem; width: 5rem; align-self:center;" alt="" class="img-fluid">
                            {{-- <div style=" padding: 20px; background-color:white; width: 10rem; border-radius: 10px;">
                                <img src="{{asset('assets/img/mawuli.png')}}" style="height: 6rem; width: 5rem; align-self:center;" alt="" class="img-fluid">
                            </div> --}}
                            <h2>OMSU GLOBAL PORTAL</h2>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 2rem;">
                        <div style="display:flex; align-items:center; justify-content: center;">
                        <form id="wrapped" action="#" method="POST">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email Address<span style="color:red">*</span></label>
                                        <input type="text" name="email" class="form-control required" placeholder="Enter Email">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password<span style="color:red">*</span></label>
                                        <input type="text" name="password" class="form-control required" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn_1">Submit</button>
                                </div>
                        </div>
                        </form>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 100px; display:none;" >
                       
                    </div>

             
                </div>
                <!-- /Wizard container -->
        </div>
        <!-- /content-right-->
    </div>
    <!-- /row-->
</div>

<style>
    .content-left {
        background-color: white;
        padding: 0;
    }

/* style="background-image: url('{{asset('assets/img/bg.jpg')}}'); background-repeat: no-repeat; background-position: top; background-size:cover;" */
</style>
@stop


@section('scripts')
     <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
        $(function(){
            $('#occupation').on('change', function(){
                var selected = $(this).val();
                console.log(selected);
                if(selected == "Other"){
                    $('#othercontainer').removeAttr('hidden');
                }else{
                    $('#othercontainer').attr('hidden', 'hidden');
                }
            })
        })
       
        $('#wrapped').submit(function(event){
            event.preventDefault();
            var form = $("form#wrapped");
            form.validate();
            if (form.valid()) {
                $("#loader_form").fadeIn();
                            $.ajax({
                                url: "{{url('/login')}}",
                                method: "POST",
                                data: $('#wrapped').serialize(),
                                success: function(response){
                                    if(response.status == 'success'){
                                        $("#loader_form").fadeOut();
                                        window.location.href = response.url;
                                    }else{
                                        $("#loader_form").fadeOut();
                                        Swal.fire(
                                            'Error',
                                            response.message,
                                            'error'
                                        );
                                    }
                                },
                                error: function(){
                                    $("#loader_form").fadeOut();
                                    Swal.fire(
                                            'Error',
                                            'Oops, something went wrong. Please try again',
                                            'error'
                                    )
                                }
                            })
                
            }
        })

     </script>
@stop