@extends('app.includes.master')

@section('pagestyles')
<style>
    #start {
        margin-top: 20px;
    }
</style>
@stop

@section('content')


<div class="">
    <div class="row-height">
        <div class="col-lg-12 content-left" >
            <div class="content-left-wrapper">
                <div>
                    <figure><img src="{{asset('assets/img/logo2.png')}}" style="height: 6rem; " alt="" class="img-fluid"></figure>
                    <h2 style="text-transform:capitalize;">{{$conference->title}}</h2>
                    <p>Find more information on above conference, including how to register to attend the confernce.</p>
                    <a href="{{url('/')}}" class="btn_1 rounded">Go Home</a>
                </div>
                <div class="copy">© {{date('Y')}} UGCS</div>
            </div>
        </div>
        <!-- /content-left -->

        <div class="col-lg-12 " id="start" style="padding-bottom: 50px;">
                <div class="container">


                    {{-- <div class="col-md-12">
                        <a style="margin: 10px;" href="{{url('download-attachment?cid='.$conference->token)}}" class="btn btn-success">Download Abstract Template</button>
                        <a style="margin: 10px;" href="{{url('/verify-abstract?cid='.$conference->token)}}" class="btn btn-primary">Submit Abstract</a>
                        <a style="margin: 10px;" href="{{url('/verify-reg?cid='.$conference->token)}}" class="btn btn-outline-warning">Register For Event</a>
                    </div> --}}
                </div>

                <div class="container">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card">
                          <div class="card-header" role="tab" id="headingOne">
                            <div class="mb-0">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                <h3>Theme:</h3>
                                  <p>Click to expand</p>
                              </a>
                              <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </div>
                          </div>
                      
                          <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="">
                            <div class="card-block">
                                {{$conference->theme}}
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" role="tab" id="headingTwo">
                            <div class="mb-0">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                  <h3>More About Conference: </h3>
                                  <p>Click to expand</p>
                              </a>
                              <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </div>
                          </div>
                          <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false">
                            <div class="card-block">
                                {{-- {{$conference->theme}} --}}
                                {!!$conference->description!!}

                                <br />
                                <br />
                                @if($conference->payment_categories != null && count($conference->payment_categories) > 0)
                                    <h4>REGISTRATION FEE</h4>
                                    <ul>
                                        @foreach($conference->payment_categories as $p)
                                            
                                                <li style="padding-top: 20px;">{{$p->name}} : <strong>{{$p->amount}}</strong></li>
                                            
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" role="tab" id="headingThree">
                            <div class="mb-0">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                  <h3>Venue & Date</h3>
                                  <p>Click to expand</p>
                              </a>
                              <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </div>
                          </div>
                          <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                            <div class="card-block">
                              <p><strong>Venue: </strong>{{$conference->venue}}</p>
                              <p><strong>Start Date#: </strong>{{$conference->startdate}}</p>
                              <p><strong>End Date#: </strong>{{$conference->startdate}}</p>
                              <p><strong>Time Each Day#: </strong>{{$conference->starttime}}</p>
                              
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" role="tab" id="headingOne">
                            <div class="mb-0">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                  <h3>Confernece Participation Benefits</h3>
                                  <p>Click to expand</p>
                              </a>
                              <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </div>
                          </div>
                      
                          <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="">
                            <div class="card-block">
                              {!!$conference?->benefits!!}
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" role="tab" id="headingTwo">
                            <div class="mb-0">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                  <h3>Industrial Partners & Sponsors</h3>
                                  <p>Click to expand</p>
                              </a>
                              <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </div>
                          </div>
                          <div id="collapseFive" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false">
                            <div class="card-block">
                                <div class="row">
                                    @if(count($conference->sponsors) > 0)
                                        @foreach($conference->sponsors as $sponsor)
                                            <div class="col-md-3" style="display:flex;flex-direction:column; align-items:center; justify-content:center;">
                                                <img  src="{{asset('storage/logos/'.$sponsor->logo)}}" style="height: 200px; width: 200px; border-radius: 100px; object-position:center; object-fit:cover;" class="img-fluid" alt="{{$sponsor->name}}"/>
                                                <h4>{{$sponsor->name}}</h4>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" role="tab" id="headingThree">
                            <div class="mb-0">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                  <h3>Conference organizers</h3>
                                  <p>Click to expand</p>
                              </a>
                              <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </div>
                          </div>
                          <div id="collapseSix" class="collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                            <div class="card-block">
                                {!!$conference?->organizers!!}
                            </div>
                          </div>
                        </div>

                       
                      </div>
                </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<style>
    @import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
@import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700');
@import url('https://fonts.googleapis.com/css?family=Slabo+27px');
@import url('https://fonts.googleapis.com/css?family=Libre+Baskerville:400,700');

a, a:hover, a:focus{outline:none; text-decoration:none;}

body{
    font-family: 'Open Sans', sans-serif;
}

h2{float:left; width:100%; color:#fff; margin-bottom:30px; font-size: 14px;}
h2 span{font-family: 'Libre Baskerville', serif; display:block; font-size:45px; text-transform:none; margin-bottom:20px; margin-top:30px; font-weight:700}
h2 a{color:#fff; font-weight:bold;}


section{
    
    float:left;
    width:100%;
    background: #43cea2;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #185a9d, #43cea2);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #185a9d, #43cea2); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
padding:30px 0;
}

.card {
    -moz-box-direction: normal;
    -moz-box-orient: vertical;
    background-color: #fff;
    border-radius: 0.25rem;
    display: flex;
    flex-direction: column;
    position: relative;
    margin-bottom:1px;
    border:none;
}
.card-header:first-child {
    border-radius: 0;
}
.card-header {
    background-color: #f7f7f9;
    margin-bottom: 0;
    padding: 20px 1.25rem;
    border:none;
    
}
.card-header a i{
    float:left;
    font-size:25px;
    padding:5px 0;
    margin:0 25px 0 0px;
    color:#195C9D;
}
.card-header i{
    float:right;        
    font-size:30px;
    width:1%;
    margin-top:8px;
    margin-right:10px;
}
.card-header a{
    width:97%;
    float:left;
    color:#565656;
}
.card-header p{
    margin:0;
}

.card-header h3{
    margin:0 0 0px;
    font-size:20px;
    font-family: 'Slabo 27px', serif;
    font-weight:bold;
    color:#3fc199;
}
.card-block {
    -moz-box-flex: 1;
    flex: 1 1 auto;
    padding: 20px;
    color:#232323;
    box-shadow:inset 0px 1px 1px rgba(0,0,0,0.1);
    border-top:1px soild #000;
    border-radius:0;
}
</style>
@stop