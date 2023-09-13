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
           
        </div>
    </div>
    <!-- /container -->
</header>
<!-- /Header -->

<section class="parallax_window_in"  data-parallax="scroll" data-image-src="{{asset('assets/img/ghbg.png')}}" data-natural-width="1400" data-natural-height="800">
    <div id="sub_content_in">
        <h1>UG CONFERENCES PORTAL</h1>
        {{-- <p style="font-size: 40px;">{{$conference->title}}</p> --}}
    </div>
</section>
<!-- /section -->

<main id="general_page">
    <div class="container_styled_1">
        <div class="container margin_60_35">
            <h3><em></em>UPCOMING CONFERENCES</h3>
            <p>
                Find below list of our upcoming conferences
            </p>

            <h2><em></em></h2>
          
        </div>
    </div>
    <div class="container margin_60">
        {{-- <div class="main_title">
            <h3><em></em>UPCOMING CONFERENCES</h3>
            <p>
                Find below our list of our upcoming conferences
            </p>

            <h2><em></em></h2>

            <form>
                <div class="row">
                    <div class="form-group">
                       
                        <input type="text" name="firstname" class="form-control required" placeholder="Search to filter">
                    </div>
                </div>
            </form>
        </div>	 --}}
        <div class="row">
            <form>
                <div class="row" style="width: 100%;">
                    <div class=" col-md-8">
                        <input type="text" name="term" class="form-control col-md-12" placeholder="Search conference">
                     </div> 

                     <div class="col-md-4">
                        <button class="btn btn-md btn-default">SEARCH</button>
                     </div>
                </div>
                 
            </form>

            <hr />
            <br />
            
        </div>

        <h2><em></em></h2>

        <!--Team Carousel -->
        <div class="row" style="margin-top: 1.5rem;">
            
               @if(isset($conferences) && count($conferences) > 0)
                {{-- {{dd($conference->sponsors)}} --}}
                    @foreach($conferences as $item)
                    <div class="card" style="width: 100%; margin-bottom: 2rem; padding-bottom: 20px;">
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-md-2" style="display:flex; align-items:center; justify-content:center;">
                                    <img src="{{asset('assets/img/great-hall-artwork.png')}}" style="height: 10rem; width: 10rem; object-fit:scale-down; " alt="" class="img-fluid">
                                </div>
                                <div class="col-md-9">
                                    <h5 class="card-title"  style="text-transform:capitalize!important;">{{$item->title}}</h5>
                                    <p class="card-text">{{date("F jS, Y", strtotime($item->startdate))}} | {{date('H:iA', strtotime($item->starttime))}}</p>

                                    <br />
                                    <a href="{{url('/apply-now?cid='.$item->token)}}" class="btn_1 small">Register Now</a>

                                    <a href="{{url('/about?cid='.$item->token)}}" class="btn_1 small " style="background-color: #6c757d">About Conference</a>
        
                                    @if($item->receive_abstract =='1' || $item->receive_abstract==true)
                                    <a href="{{url('/submit-abstract?cid='.$item->token)}}" class="btn_1 small" style="background-color: #28a745" >Submit Abstract</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
              @else
                    <p class="alert alert-info">No Upcoming Conferences. Check again later.</p>
              @endif
        </div>
        <!--End Team Carousel-->
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
