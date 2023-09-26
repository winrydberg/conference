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
<header  style='background-color: #234f1e;border:none'>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <a href="{{url('/')}}"><img src="{{asset('assets/img/mawuli.png')}}" alt="" width="50" height="50"></a>
            </div>
           
        </div>
    </div>
    <!-- /container -->
</header>
<!-- /Header -->

<section class="parallax_window_in"  data-parallax="scroll" data-image-src="{{asset('assets/img/mawuli_1.jpg')}}" data-natural-width="1400" data-natural-height="400">
    <div id="sub_content_in">
        <h1>OMSU CONGRESS - 2023</h1>
        <a href="{{url('/')}}" class="btn_1 rounded">Go Home</a>
    </div>
</section>
<!-- /section -->

<main id="general_page">

    <div class="container margin_60">
        <div class="main_title">
            <h3><em></em>Complete the below form to register for OMSU Congress</h3>
            <h3><em></em></h3>
            <p>
                {{-- Complete the below form to register and attend Congress. --}}
            </p>
        </div>	
        <!--Team Carousel -->
        <div class="row">
            <div class="col-md-8" style="margin: 0 auto;">
                <form id="wrapped" class="cmxform" method="POST">
                    {{csrf_field()}}
                    <input id="website" name="website" type="text" value="">
                    <input style="display: none;" name="cid" type="text" value="{{request()->get('cid')}}">
                 
                            {{-- <h3 class="main_question">Register to Attend Conference</h3> --}}
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label>Title <span style="color:red">*</span></label>
                                <div class="styled-select clearfix ">
                                    <select class="wide required form-control" name="title">
                                        <option value="" disabled selected>Title</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Miss">Miss</option><option value="Mrs.">Mrs.</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Rev.">Rev.</option>
                                        <option value="Rev. Sr.">Rev. Sr.</option>
                                        <option value="Imam">Imam</option>
                                        <option value="Prof">Prof</option>                          
                                    </select>
                                </div>
                            </div>
                           <div class="row"  style="margin-bottom: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name <span style="color:red">*</span></label>
                                        <input type="text" name="firstname" class="form-control required" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name <span style="color:red">*</span></label>
                                        <input type="text" name="lastname" class="form-control required" placeholder="Last Name">
                                    </div>
                                </div>
                           </div>
                           
                           <div class="row"  style="margin-bottom: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender <span style="color:red">*</span></label>
                                        <select name="gender" class="form-control required" id='gender'>
                                            <option value=''>Please Select</option>
                                            <option value='Male'>Male</option>
                                            <option value='Female'>Female</option>
                                            </select>
                                    </div>
                                </div>
                           </div>
                            
                           <div class="row"  style="margin-bottom: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Email Address <span style="color:red">*</span></label>
                                        <input id="email" type="email" {{request()->get('email') != null ? 'readonly' : ''}} value="{{request()->get('email')}}" name="email" class="form-control required" placeholder="Your Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Phone No <span style="color:red">*</span></label>
                                        <input type="text" name="phone" class="form-control required" placeholder="Your Phone No.">
                                    </div>
                                </div>
                           </div>
            
                        
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Year Of Completion <span style="color:red">*</span></label>
                                        <select class="wide required form-control" id="yearcompleted" name="yeargroup">
                                            <option value="" disabled selected>Select an option</option>             
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>House Of Residence <span style="color:red">*</span></label>
                                        <select class="wide required form-control" id="house" name="house" >
                                            <option value="" disabled selected>Select an option</option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>WhatsApp No (Optional)</label>
                                        <input type="text" name="whatsapp" class="form-control" placeholder="Your Whatsapp No.">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Current Status</label>
                                        <select name="status" class="form-control" id='status' required>
                                            <option value=''>Please select</option>
                                               <option value='Tertiary'>Tertiary Student</option>
                                                <option value='Pre-Tertiary'>Pre-Tertiary Student</option>
                                                 <option value='Worker'>Worker</option>
                                            </select>
                                    </div>
                                </div>
                            </div>

                              

                                <div class="form-group" id="othercontainer"  style="margin-bottom: 10px;" hidden >
                                    <label>Specify <span style="color:red">*</span></label>
                                    <input type="text" name="specify" class="form-control" placeholder="Specify">
                                </div>
               
                            
                       
                    <div id="bottom-wizard">
                        <button type="submit" name="process" class="btn_1 submit">Register Now</button>
                    </div>
                    <!-- /bottom-wizard -->
                </form>
            </div>
        </div>
        <!--End Team Carousel-->
    </div>
    <!-- End container -->
</main>

@include('app.includes.copyright')

<!-- end footer-->
<div class="modal " id="regModal" data-bs-backdrop='static'>
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Registration Fee Payment</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style="display:flex; flex-direction:column;">
          <img src="{{asset('assets/img/mawuli.png')}}" style="height: 80px; width: 80px; align-self:center;" class="img-fluid"/>
       
          <p id="resmessage" style="align-self: center; font-size: 20px;"></p>
          {{-- <a href="#" id="submiturl" class="btn_1 btn-block rounded">Submit Abstract (Paper)</a> --}}
          {{-- <a href="#" id="downloadurl" type="button" style="margin-top: 30px;" class="btn btn-danger btn-block rounded">Close & Download Proof</a> --}}
          <button onclick="makePayment()" style="margin-top: 30px;" class="btn btn-danger btn-block rounded" id="paybtn">Pay GHC 150 Registration Fee</button>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-" data-dismiss="modal">Close</button> --}}
        </div>
  
      </div>
    </div>
</div>

<div class="modal " id="passwordModal" data-bs-backdrop='static'>
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">OMSU Global Account</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style="display:flex; flex-direction:column;">
          <img src="{{asset('assets/img/mawuli.png')}}" style="height: 80px; width: 80px; align-self:center;" class="img-fluid"/>
       
          <h4>Kindly set your OMSU Global Account Password.</h4>
          <form id="setAccountForm">
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" type="email" id="omsuemail"/>
            </div>

            <div class="form-group">
                <label> Password</label>
                <input class="form-control" name="cpassword" id="cpassword" type="password"/>
            </div>
            
            <div class="form-group">
                <label> Confirm Password</label>
                <input class="form-control" name="ccpassword" id="ccpassword" type="password"/>
            </div>

            <button type="submit" style="margin-top: 30px;" class="btn btn-danger btn-block rounded">Set Password</button>
          </form>
          {{-- <a href="#" id="submiturl" class="btn_1 btn-block rounded">Submit Abstract (Paper)</a> --}}
          {{-- <a href="#" id="downloadurl" type="button" style="margin-top: 30px;" class="btn btn-danger btn-block rounded">Close & Download Proof</a> --}}
          
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-" data-dismiss="modal">Close</button> --}}
        </div>
  
      </div>
    </div>
</div>

@stop


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


{{-- <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/common_scripts.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/velocity.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/functions.js')}}"></script> --}}
<script src="{{asset('assets/js/parallax.min.js')}}"></script>
<script src="{{asset('assets/js/owl-carousel.js')}}"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="{{asset('assets/js/app.js')}}"></script>

<script>
    $(function(){

        var startyear = 1990;

        for(i=startyear; i< parseInt(new Date().getFullYear()); i++){
            $('#yearcompleted').append(` <option value="${i}">${i}</option>`);
        } 
    })
    
    
    
    $('#gender').change(function(){
         $('#house').html(` <option value="">Please select</option>`)
        if($(this).val()=='Male'){
            var halls = ['Aggrey','Lincoln','Wilberforce','Trost','Aku']
            for(i=0; i< halls.length; i++){
            $('#house').append(` <option value="${ halls[i] }">${ halls[i] }</option>`);
           } 
          
        }
        if($(this).val()=='Female'){
             var halls = ['Nightingale','Slessor','Priscilla','Snitker','Solace']
              for(i=0; i< halls.length; i++){
            $('#house').append(` <option value="${ halls[i] }">${ halls[i] }</option>`);
           } 
            
        }
    })
   
    var regemail = $('#email').val();
    var regno = "";
    var amount = 150;

    $('#wrapped').submit(function(event){
        event.preventDefault();
        var form = $("form#wrapped");
        form.validate();
        if (form.valid()) {
            Swal.fire({
                title: "Registering For Congress",
                text: "Are you sure?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Register'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#loader_form").fadeIn();
                        $.ajax({
                            url: "{{url('/apply-now')}}",
                            method: "POST",
                            data: $('#wrapped').serialize(),
                            success: function(response){
                                if(response.status == 'success'){
                                    $("#loader_form").fadeOut();
                                    $('#resmessage').text(response.message);
                                    // $("#submiturl").attr("href", "{{url('/submit-new-abstract?cid=')}}"+response.token+'&email='+response.email+'&regcode='+response.regno)
                                    // console.log(response);
                                    regemail = response.email;
                                    regno = response.regno;
                                    amount = response.amount;
                                    $('#paybtn').text(`Pay GHC ${amount} Registration Fee`)
                                    $('#downloadurl').attr("href", response.url)
                                    $('#regModal').modal({backdrop: 'static', keyboard: false},'show');

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
            
        }
    })


  $('#setAccountForm').validate({
                  rules: {
                   cpassword: {
                   required:true
                   },
                    ccpassword: {
                
                    equalTo : "#cpassword"
                }
            }
        });



    $('#setAccountForm').submit(function(event) {
        event.preventDefault();
        var form = $("form#setAccountForm");
        form.validate();
           if (form.valid()) {
        var password = $('#cpassword').val();
        $.post("{{url('/set-acc-password')}}", {password: password, email: $('#omsuemail').val(), _token: "{{Session::token()}}"}, function(response){
            if(response.status == 'success'){
                Swal.fire(
                    'Account Successfully Created',
                    response.message,
                    'success'
                ).then(() => {
                    window.location.href="{{url('/profile')}}";
                });
            }else{
                Swal.fire(
                    'Error',
                    response.message,
                    'error'
                );
            }
        })
           }
    })


    function makePayment(){
        // alert( regno);
        $('#omsuemail').val(regemail).prop('disabled', true);
        payWithPaystack(regno, regemail, "{{Session::token()}}",amount);
    }


    





 </script>
@stop


