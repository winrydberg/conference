@extends('app.includes.master')

@section('content')

<style>
    #overlay {
        height: 30px;
        position: absolute;
        border-top-left-radius: 5px;
        /* position: fixed; Sit on top of the page content */
        width: 100%; /* Full width (cover the whole page) */
        /* height: 100%; Full height (cover the whole page) */
        top: 0;
        background-color: rgba(0,0,0,0.6); /* Black background with opacity */
}
</style>

<div class="container-fluid full-height">
    <div class="row row-height">
        <div class="col-md-3 content-left">
            <div class="content-left-wrapper">
                {{-- <a href="index.html" id="logo"><img src="img/logo.png" alt="" width="49" height="35"></a> --}}
                <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
                    <div style="padding: 20px; background-color:white; width: 10rem; border-radius: 10px;"><img src="{{asset('assets/img/logo.png')}}" style="height: 6rem; width: 5rem" alt="" class="img-fluid"></div>
                    <h2>UG Conferences</h2>
                    <p>Welcome to UG Conference Portal. Select a conference to proceed.</p>
                </div>
                <div class="copy">© {{date('Y')}} UGCS</div>
            </div>
        </div>
        <!-- /content-left -->
       
        <div class="col-md-9 content-right" id="start" style="display:flex; flex-direction:column; justify-content:flex-start;">
    
                    @if(isset($conferences) && count($conferences) > 0)
                        
                        <h3 class="main_question">UPCOMING CONFERENCES</h3>
                          <br/>
                            @foreach ($conferences as $item)
                                <div class="card" style="width: 100%; margin-bottom: 2rem; padding-bottom: 20px;">
                                    {{-- <div style="position: relative">
                                        <img src="{{asset('assets/img/cardbg.jpeg')}}" style="height: 30px; width: 100%; object-fit:cover; position: top; top: 0; opacity: rbga(0, 0,0, 0.5)"  />
                                        <div id="overlay">
                                            
                                        </div>
                                    </div> --}}
                                    
                                    <div class="card-body" >
                                        
                                        <div class="row">
                                            <div class="col-md-2" style="display:flex; align-items:center; justify-content:center;">
                                                <img src="{{asset('assets/img/great-hall-artwork.png')}}" style="height: 10rem; width: 10rem; object-fit:scale-down; " alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-9">
                                                <!--20c997   verify-abstract-->
                                                <h5 class="card-title"  style="text-transform:capitalize!important;">{{$item->title}}</h5>
                                                <p class="card-text">{{date("F jS, Y", strtotime($item->startdate))}} | {{date('H:iA', strtotime($item->starttime))}}</p>

                                                <br />
                                                <a href="{{url('/apply-now?cid='.$item->token)}}" class="btn_1 small">Register Now</a>

                                                <a href="{{url('/about?cid='.$item->token)}}" class="btn_1 small " style="background-color: #6c757d">More Info</a>
                    
                                                @if($item->receive_abstract =='1' || $item->receive_abstract==true)
                                                <a href="{{url('/submit-abstract?cid='.$item->token)}}" class="btn_1 small" style="background-color: #28a745" >Submit Abstract</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    @else
                            <div class="row" style="display:flex; flex-direction: column; align-items:center; justify-content:center;">
                                <img src="{{asset('assets/img/file.png')}}" class="img-fluid" style="width: 150px; padding: 20px; " />
                                <p class="alert alert-info">Oops, No Active / Upcoming Conferences. Check again later</p>
                            </div>
                    @endif
                    
        </div>
    </div>
</div>


@stop