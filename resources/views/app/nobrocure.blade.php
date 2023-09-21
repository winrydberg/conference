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
                    <h2>Error</h2>
                    
                    <p>{{$conference?->title}}</p>

                    <br />
                    {{-- <div> --}}
                        <a href="{{url('/')}}" class="btn_1 rounded">Go Home</a>
                    {{-- </div> --}}
                </div>
            
                <div class="copy">© {{date('Y')}}</div>
            </div>
            <!-- /content-left-wrapper -->
        </div>
        <!-- /content-left -->

        <div class="col-md-8">
           
            <div id="wizard_container" style="margin-bottom: 50px; display:flex: align-items:center; justify-content:center;">

                  
                    <div class="col-md-12" style="margin-top: 100px;">
                        <div style="display:flex; align-items:center; justify-content: center; flex-direction:column;">
                            <h5>{{$conference?->title}}</h5>
                            <img src="{{asset('assets/img/cancel.png')}}" style="height: 6rem; width: 6rem; align-self:center;" alt="" class="img-fluid">
                            <h3 class="main_question" style="margin-top: 30px;">Oops, No Brochure Available. Congress Brochure not uploaded yet.</h3>
                        </div>
                    </div>
                    <!-- /top-wizard -->
            
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

