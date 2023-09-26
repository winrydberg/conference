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
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <a href="{{url('/')}}"><img src="{{asset('assets/img/uglogo.svg')}}" alt="" width="159" height="35"></a>
            </div>
            <div class="col-9">
                {{-- <div id="social">
                    <ul>
                        <li><a href="#0"><i class="icon-facebook"></i></a></li>
                        <li><a href="#0"><i class="icon-twitter"></i></a></li>
                        <li><a href="#0"><i class="icon-google"></i></a></li>
                        <li><a href="#0"><i class="icon-linkedin"></i></a></li>
                    </ul>
                </div> --}}
                <!-- /social -->
                <a href="#0" class="cd-nav-trigger">Menu<span class="cd-icon"></span></a>
                <!-- /menu button -->
                {{-- <nav>
                    <ul class="cd-primary-nav">
                        <li><a href="index.html" class="animated_link">Home</a></li>
                        <li><a href="quotation-wizard-version.html" class="animated_link">Quote Version</a></li>
                        <li><a href="review-wizard-version.html" class="animated_link">Review Version</a></li>
                        <li><a href="registration-wizard-version.html" class="animated_link">Registration Version</a></li>
                        <li><a href="about.html" class="animated_link">About Us</a></li>
                        <li><a href="contacts.html" class="animated_link">Contact Us</a></li>
                    </ul>
                </nav> --}}
                <!-- /menu -->
            </div>
        </div>
    </div>
    <!-- /container -->
</header>
<!-- /Header -->

<section class="parallax_window_in"  data-parallax="scroll" data-image-src="{{asset('assets/img/cardbg.jpeg')}}" data-natural-width="1400" data-natural-height="800">
    <div id="sub_content_in">
        <h1>ABOUT CONFERENCE</h1>
        {{-- <p style="font-size: 40px;">{{$conference->title}}</p> --}}
        <a href="{{url('/')}}" class="btn_1 rounded">Go Home</a>
    </div>
</section>
<!-- /section -->

<main id="general_page">
    <div class="container_styled_1">
        <div class="container margin_60_35">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="nomargin_top"><br>About - {{$conference->title}}</h2>
                    <h3><em></em></h3>
                    {{-- <p  class="lead">Ex graeco nostrud theophrastus nam, cum tibique reprimique ad. Mea omittam electram te, eu cum fastidii sapientem delicatissimi.</p> --}}
                    {!! $conference->description !!}

                    <h4>Venue</h4>
                    <div class="container" style="margin-bottom: 2rem">
                    {{$conference->venue}}
                    </div>

                    <h4>Date & Time</h4>
                    <div class="container" style="margin-bottom: 2rem">
                    <p><strong>Start Date#: </strong>{{date('F jS, Y', strtotime($conference->startdate))}}</p>
                    <p><strong>End Date#: </strong>{{date('F jS, Y', strtotime($conference->startdate))}}</p>
                    <p><strong>Time Each Day#: </strong>{{date('H:iA', strtotime($conference->starttime))}}</p>
                    </div>

                    <h4>Participation Benefits</h4>
                    <div class="container" style="margin-bottom: 2rem">
                    {!! $conference->benefits !!}
                    </div>


                    <h4>Conference Organizers</h4>
                    <div class="container" style="margin-bottom: 2rem">
                     {!! $conference->organizers !!}
                    </div>

                    <a href="{{url('/apply-now?cid='.$conference?->token)}}" class="btn_1 rounded"> Register Now</a>
                    <a href="{{url('/submit-abstract?cid='.$conference?->token)}}" class="btn_1 rounded"> Submit An Abstract</a>
                </div>
                <div class="col-lg-4" style="display:flex; align-items:center; flex-direction:column; padding-top: 5rem;">
                    <img style="height: 300px; width: 300px; " class="img-responsive" src="{{asset('storage/qrcodes/main/'.$conference?->token.'/main_qrcode.svg')}}" />

                    <p style="margin-top: 2rem; font-size: 1rem; align-self:center;">Scan to download conference schedule & other documents</p>
                </div>
            </div>
            <!-- End row -->
        </div>
    </div>
    <div class="container margin_60">
        <div class="main_title">
            <h2><em></em>SPONSORS</h2>
            <p>
                Find below our sponsors
            </p>
        </div>	
        <!--Team Carousel -->
        <div class="row">
            <div class="owl-carousel owl-theme team-carousel">
                {{-- {{dd($conference->sponsors)}} --}}
                @foreach($conference?->sponsors as $s)
                <div class="team-item">
                    <div class="team-item-img">
                        <img src="{{asset('storage/logos/'.$s->logo)}}" alt="" style="height: 12rem; object-fit:cover;">
                        <div class="team-item-detail">
                            <div class="team-item-detail-inner">
                                <h4>{{$s->name}}</h4>
                                {{-- <p>Similique sunt culpa qui officia deserunt mollitia animi dolorum fuga.</p> --}}
                                <a href="#0" class="btn_1 white">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="team-item-info">
                        <h5>{{$s->name}}</h5>
                        {{-- <p>CEO</p> --}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!--End Team Carousel-->
    </div>

    <div class="container_styled_1">
        <div class="container margin_60_35">
            <div class="main_title">
                <h2><em></em>OUR PARTNERS</h2>
                <p>
                    Find below our industrial partners
                </p>
            </div>	
            <!-- End row -->
        </div>
    </div>
    <!-- End container -->
</main>

<footer class="clearfix">
    <div class="container">
        <p>© {{date('Y')}} UGCS</p>
        <ul>
            <li><a href="#" class="animated_link">Developed By UGCS</a></li>
            <li><a href="#" class="animated_link">Terms and conditions</a></li>
            <li><a href="#" class="animated_link">UGCS</a></li>
        </ul>
    </div>
</footer>

<!-- end footer-->

@stop


@section('scripts')
<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/js/common_scripts.min.js')}}"></script>
<script src="{{asset('assets/js/velocity.min.js')}}"></script>
<script src="{{asset('assets/js/functions.js')}}"></script>
<script src="{{asset('assets/js/parallax.min.js')}}"></script>
<script src="{{asset('assets/js/owl-carousel.js')}}"></script>
<script>
"use strict";
$(".team-carousel").owlCarousel({
        items: 1,
        loop: false,
        margin: 10,
        autoplay: false,
        smartSpeed: 300,
        responsiveClass: false,
        responsive: {
            320: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1000: {
                items: 3,
            }
        }
    });
</script>
@stop
