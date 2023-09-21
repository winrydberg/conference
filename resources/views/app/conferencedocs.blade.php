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
                    <h2>Download <br/> Congress Documents</h2>
                    
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

                    <div class="col-md-12" style="margin-top: 10rem;">
                        <div style="display:flex; align-items:center; justify-content: center;">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Registration Code<span style="color:red">*</span></label>
                                        <input type="text" name="firstname" class="form-control required" placeholder="Enter Registration Code">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn_1 btn-block">Submit</button>
                                </div>
                        </div>
                        </form>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 100px; display:none;" >
                        @foreach($documents as $d)
                        <div class="d-flex text-center">
                            
                                <img style="height: 30px; width: 30px; " src="{{asset('assets/img/download.png')}}" />
                           
                                <p style="color: brown; font-size: 18px; margin-left: 10px;">{{$d->type_name}} (<strong>{{$d->file}}</strong>)  <a target="_blank" href="{{asset('storage/documents/'.$d->file)}}" class="btn_1 rounded" style="color:white;">Download</a></p>
                                
                        </div>
                        @endforeach
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