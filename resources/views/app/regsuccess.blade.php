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
                    <h2> Registration <br/> Successful</h2>
                    
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
                   <div class="col-md-8" style="margin: 0 auto; padding-top: 50px; margin; display:flex; align-items:center; justify_content:center; flex-direction:column;">
                    
                    <h3 class="main_question">{{$message}}</h3>
                    
                    <div style="margin: 20px;">
                        <img src="{{asset('assets/img/check.png')}}" style="height: 6rem; width: 6rem; align-self:center;" alt="" class="img-fluid">
                    </div>
                    <h4 class="main_question">Your Registration No / Code : <strong>{{$application?->reg_no}}</strong></h4>
                    <p>Click on the below button to download your proof of registration.</p>
                    <a target="_blank" href="{{url('/download-proof?regno='.$application->reg_no.'&email='.$application->email)}}" class="btn_1 rounded">Download Proof</a>
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


