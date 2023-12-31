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
        <div class="col-md-3 content-left" >
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

        <div class="col-md-9">
           
            <div id="wizard_container" style="margin-bottom: 50px;">

                   <div id="top-wizard">
                        <div id="progressbar"></div>
                    </div>
                    <div class="col-md-12">
                        <div style="display:flex; align-items:center; justify-content: center;">
                            <h5>{{$conference->title}}</h5>
                            
                        </div>
                    </div>
                    <!-- /top-wizard -->
                   <div class="col-md-8" style="margin: 0 auto; padding-top: 50px;">
                    <form id="wrapped" class="cmxform" method="POST">
                        {{csrf_field()}}
                        <input id="website" name="website" type="text" value="">
                        <input style="display: none;" name="cid" type="text" value="{{request()->get('cid')}}">
                        <!-- Leave for security protection, read docs for details -->
                        <div id="middle-wizard">
                            <div class="step">
                                <h3 class="main_question">Register to Attend Conference</h3>
                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label>Title <span style="color:red">*</span></label>
                                    <div class="styled-select clearfix ">
                                        <select class="wide required form-control" name="title">
                                            <option value="" disabled selected>Title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>                           
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
                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Email Address <span style="color:red">*</span></label>
                                            <input type="email" {{request()->get('email') != null ? 'readonly' : ''}} value="{{request()->get('email')}}" name="email" class="form-control required" placeholder="Your Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Phone No <span style="color:red">*</span></label>
                                            <input type="text" name="phone" class="form-control required" placeholder="Your Phone No.">
                                        </div>
                                    </div>
                               </div>
                
                            </div>
                            <!-- /step-->
                           
                            <!-- /step-->
                            <div class="submit step">
                                
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Institution <span style="color:red">*</span></label>
                                        <input type="text" name="institution" class="form-control required" placeholder="Institution">
                                    </div>

                                    @if($conference->payment_categories != null && count($conference->payment_categories) > 0)
                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Registration Type<span style="color:red">*</span></label>
                                            <div class="styled-select clearfix">
                                                <select class="wide required form-control" id="regtype" name="regtype" onchange="updateRegFee(this)">
                                                    <option value="" disabled selected>Select an option</option>
                                                    @foreach($conference->payment_categories as $m)
                                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                                    @endforeach                   
                                                </select>
                                            </div>
                                            <p style="font-size: 16px; font-weight:bold; color:red; margin-top: 15px;" id="regfeeinfo"></p>
                                        </div>

                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Payment Mode <span style="color:red">*</span></label>
                                            <div class="styled-select clearfix">
                                                <select class="wide required form-control" id="paymode" name="paymode">
                                                    <option value="" disabled selected>Select an option</option>
                                                    @foreach($paymentmodes as $p)
                                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                                    @endforeach                          
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Occupation / Student Type <span style="color:red">*</span></label>
                                            <div class="styled-select clearfix">
                                                <select class="wide required form-control" id="occupation" name="occupation">
                                                    <option value="" disabled selected>Select an option</option>
                                                    <option value="Undergraduate student">Undergraduate student</option>
                                                    <option value="Graduate student">Graduate student</option>
                                                    <option value="Researcher">Researcher</option>                           
                                                    <option value="Other">Other</option>                           
                                                </select>
                                            </div>
                                        </div>

                                    <div class="form-group" id="othercontainer"  style="margin-bottom: 10px;" hidden >
                                        <label>Specify <span style="color:red">*</span></label>
                                        <input type="text" name="specify" class="form-control" placeholder="Specify">
                                    </div>
                                    @endif
                                
                            </div>
                            <!-- /step-->
                        </div>
                        <!-- /middle-wizard -->
                        <div id="bottom-wizard">
                            <button type="submit" name="process" class="submit">Register Now</button>
                        </div>
                        <!-- /bottom-wizard -->
                    </form>
                   </div>
                </div>
                <!-- /Wizard container -->
        </div>
        <!-- /content-right-->
    </div>
    <!-- /row-->
</div>


<div class="modal " id="regModal">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Select An Option</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body" style="display:flex; flex-direction:column;">
          <img src="{{asset('assets/img/check.png')}}" style="height: 80px; width: 80px; align-self:center;" class="img-fluid"/>
          <p id="resmessage" style="align-self: center; font-size: 20px;"></p>
          <a href="#" id="submiturl" class="btn_1 btn-block rounded">Submit Abstract (Paper)</a>
          <a href="#" id="downloadurl" type="button" style="margin-top: 30px;" class="btn btn-danger btn-block rounded">Close & Download Proof</a>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-" data-dismiss="modal">Close</button> --}}
        </div>
  
      </div>
    </div>
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
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


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
                Swal.fire({
                    title: "Registering For Conference",
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
                                        $("#submiturl").attr("href", "{{url('/submit-new-abstract?cid=')}}"+response.token+'&email='+response.email+'&regcode='+response.regno)
                                        // console.log(response);
                                        $('#downloadurl').attr("href", response.url)
                                        $('#regModal').modal('show');
                                        // Swal.fire(
                                        //     'Success',
                                        //     response.message,
                                        //     'success'
                                        // ).then(() => {
                                        //     window.location.href = response.url;
                                        // });
                                        // setTimeout(() => {
                                        //     window.location.href = response.url;
                                        // }, 1000);
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


        function updateRegFee(selectObject){
            var val = selectObject.value;

            $.ajax({
                url: "{{url('/get-reg-amount')}}",
                method: "POST",
                data: {id: val, _token:"{{Session::token()}}"},
                success: function (res){
                    if(res.status == 'success'){
                        $('#regfeeinfo').text('NB: Registration requires an an amount of '+(res.pay.currency == null?"GHC":res.pay.currency)+' '+ res.amount)
                    }else{
                      console.log(res);  
                    }
                },
                error: function(error){
                    console.log(error);
                }
            })
        }

     </script>
@stop