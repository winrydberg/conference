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
        <div class="col-lg-4 content-left" >
            <div class="content-left-wrapper" style="width: 100%; align-self:center;">
                <div class="col-md-12" style="display:flex; align-items:center; justify-content:center; flex-direction:column;">
                    <div style=" padding: 20px; background-color:white; width: 10rem; border-radius: 10px;">
                        <img src="{{asset('assets/img/logo.png')}}" style="height: 6rem; width: 5rem; align-self:center;" alt="" class="img-fluid">
                    </div>
                    <h2>Register <br> For <br/> Conference</h2>
                    
                    <p>{{$conference->title}}</p>

                    <br />
                    {{-- <div> --}}
                        <a href="{{url('/')}}" class="btn_1 rounded">Go Home</a>
                    {{-- </div> --}}
                </div>
            
                <div class="copy">© {{date('Y')}} UGCS</div>
            </div>
            <!-- /content-left-wrapper -->
        </div>
        <!-- /content-left -->

        <div class="col-md-8">
           
            <div id="wizard_container" style="margin-bottom: 50px; display:flex: align-items:center; justify-content:center;">

                  
                    <div class="col-md-12" style="margin-top: 100px;">
                        <div style="display:flex; align-items:center; justify-content: center;">
                            <h5>{{$conference->title}}</h5>
                            
                        </div>
                    </div>
                    <!-- /top-wizard -->
                   <div class="col-md-8" style="margin: 0 auto; padding-top: 50px; margin">
                    <form id="wrapped" method="POST">
                        {{csrf_field()}}
                        <input id="website" name="website" type="text" value="">
                        <input style="display: none;" name="cid" type="text" value="{{request()->get('cid')}}">
                        <input style="display: none;" name="conferenceid" type="text" value="{{$conference?->id}}">
                        <!-- Leave for security protection, read docs for details -->
                        <div  style="align-items:center; ">
                            <div class="step">
                                <h3 class="main_question">Enter email address to proceed</h3>
                                
                               <div class="row"  style="margin-bottom: 10px;">
                                   
                                    <div class="col-md-12">
                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Email Address <span style="color:red">*</span></label>
                                            <input type="email" name="email" class="form-control required" placeholder="Your Email">
                                        </div>
                                    </div>
                                    
                               </div>
                
                            </div>
                            <!-- /step-->
                            <!-- /step-->
                        </div>
                        <!-- /middle-wizard -->
                        <div id="bottom-wizard">
                            <button type="submit" name="process" class="submit">Next </button>
                        </div>
                        <!-- /bottom-wizard -->
                    </form>

                    <hr />
                    <h3 class="main_question">Only Two(2) Steps Required to Register for Conference</h3>
                    <ul>
                        <li>1. Enter your email in the above form to receive registration link</li>
                        <br />
                        <li>2. Follow the link from your email & complete the registration form</li>
                        <br />
                        <li><strong>DONE!!!</strong></li>
                    </ul>
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
                                url: "{{url('/verify-reg')}}",
                                method: "POST",
                                data: $('#wrapped').serialize(),
                                success: function(response){
                                    if(response.status == 'success'){
                                        $("#loader_form").fadeOut();
                                        Swal.fire(
                                            'Success',
                                            response.message,
                                            'success'
                                        ).then(() => {
                                            window.location.reload();
                                        });
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