@extends('app.includes.master')

@section('pagestyles')
<link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
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
<div class="container-fluid">
    <div class="row row-height">
        <div class="col-lg-4 content-left" >
            <div class="content-left-wrapper" style="width: 100%; align-self:center;">
                <div class="col-md-12" style="display:flex; align-items:center; justify-content:center; flex-direction:column;">
                    <div style=" padding: 20px; background-color:white; width: 10rem; border-radius: 10px;">
                        <img src="{{asset('assets/img/logo.png')}}" style="height: 6rem; width: 5rem; align-self:center;" alt="" class="img-fluid">
                    </div>
                    <h2>Submit <br> An <br/> Abstract</h2>
                   
                    <p>{{$conference->title}}</p>
                    <a href="{{url('/')}}" class="btn_1 rounded">Go Home</a>
                </div>
                <div class="copy">© {{date('Y')}} UGCS</div>
            </div>
            <!-- /content-left-wrapper -->
        </div>
        <!-- /content-left -->

        <div class="col-md-8">
           
            <div id="wizard_container">
                    <div class="col-md-12">
                        <div style="display:flex; align-items:center; justify-content: center; margin-top: 10px;">
                            <p style="font-size: 16px;"> Use the form below to submit an abstract for <strong> {{$conference->title}} </strong></p>
                        </div>
                    </div>
                    <!-- /top-wizard -->
                   <div class="col-md-12">
                    <form id="wrapped" class="cmxform" method="POST">
                        {{csrf_field()}}
                        
                        <input id="website" name="website" type="text" value="">
                        <input id="conferenceid" class="form-control" style="display:none;" name="conferenceid" type="text" value="{{$conference->id}}">
                    <div id="smartwizard" style="height:auto;">
                        <ul class="nav">
                            <li class="nav-item">
                              <a class="nav-link" href="#step-1">
                                <div class="num">1</div>
                                Personal Information
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#step-2">
                                <span class="num">2</span>
                                Abstract Information
                              </a>
                            </li>
                        </ul>
                     
                        <div class="tab-content">
                            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" >
                                <div style="overflow-y:auto;padding: 20px; height: 80vh">
                                <h3 class="main_question">Personal Information</h3>
                                <p class="main_question" style="color:red; font-size: 18px;">Please note that you cannot edit after submission. Double check before submission!!!</p>

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
                                                <input type="text" name="firstname" id="firstname" class="form-control required" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name <span style="color:red">*</span></label>
                                                <input type="text" name="lastname" id="lastname" class="form-control required" placeholder="Last Name">
                                            </div>
                                        </div>
                                </div>
                                <div class="row"  style="margin-bottom: 10px;">
                                    <div class="col-md-6">
                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Email Address <span style="color:red">*</span></label>
                                            <input type="email" id="email" {{request()->get('email') != null ? 'readonly': ''}} value="{{request()->get('email')}}" name="email" class="form-control required" placeholder="Your Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"  style="margin-bottom: 10px;">
                                            <label>Phone No <span style="color:red">*</span></label>
                                            <input type="text" id="phone" name="phone" class="form-control required" placeholder="Your Phone No.">
                                        </div>
                                    </div>
                               </div>

                               <div class="form-group"  style="margin-bottom: 10px;">
                                    <label>Institution <span style="color:red">*</span></label>
                                    <input type="text" id="institution" name="institution" class="form-control required" placeholder="Institution">
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
                            </div>
                            <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2" style="height:auto; overflow-y:auto;" id="steppp2" >
                                    <div class="" style="overflow-y:auto;padding: 20px; height: 83vh">
                                    <h3 class="main_question">Abstract Information</h3>

                                    <p class="main_question" style="color:red; font-size: 18px;">Please note that you cannot edit after submission. Double check before submission!!!</p>
                                   
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Abstract Title <span style="color:red">*</span></label>
                                        <textarea name="title" class="form-control required" placeholder="Abstract Title"></textarea>
                                    </div>

                                    <div class="row" id="coauthor" style="margin-bottom: 10px; margin-top: 10px;">
                                        <p class="col-md-12" style="color:brown;"><i class="fa fa-info"></i> Add up to five(5) co-authors</p>
                                        
                                    </div>
 
                                    <div class="pull-right" style="margin-bottom: 20px;">
                                         <button type="button" id="btnadd" onclick="addCoAuthor()" class=" btn-xs btn-success pull-right" >Add Co-Author</button>
                                         <button type="button" style="display:none;" id="btnremove" onclick="removeCoAuthor()" class=" btn-xs btn-warning pull-right" >Remove Co-Author</button>
                                    </div>

                                    <div class="row"  style="margin-bottom: 10px;">
                                        <div class="col-md-6">
                                            <div class="form-group"  style="margin-bottom: 10px;">
                                                <label>Corresponding Author Name <span style="color:red">*</span></label>
                                                <input type="text" name="corresponding_author_name" class="form-control required" placeholder="Corresponding Author Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"  style="margin-bottom: 10px;">
                                                <label>Corresponding Author Active Email  <span style="color:red">*</span></label>
                                                <input type="email" name="corresponding_author_email" class="form-control required" placeholder="Corresponding Author EMail">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Abstract Thematic <span style="color:red">*</span></label>
                                        <div class="styled-select clearfix">
                                            <select class="wide required form-control" id="thematicarea" name="thematicarea">
                                                <option value="" disabled selected>Select an option</option>
                                                <option value="Basic exploratory research">Basic exploratory research</option>
                                                <option value="Sustainable Solutions">Sustainable Solutions</option>                          
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Presentation Type <span style="color:red">*</span></label>
                                        <div class="styled-select clearfix">
                                            <select class="wide required form-control" id="presentationtype" name="presentationtype">
                                                <option value="" disabled selected>Select an option</option>
                                                <option value="Oral Presentation">Oral Presentation</option>
                                                <option value="Poster Presentation">Poster Presentation</option>                          
                                                <option value="Virtual Presentation">Virtual Presentation</option>                          
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Journal Publication <span style="color:red">*</span></label>
                                        <div class="styled-select clearfix">
                                            <select class="wide required form-control" id="journal_publication" name="journal_publication">
                                                <option value="" disabled selected>Select an option</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>                                                  
                                            </select>
                                            <small>Journal publication in CBAS (do you want your paper in CBAS)</small>
                                        </div>
                                    </div>

                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Abstract File <span style="color:red">*</span></label>
                                        <input type="file" accept=".doc,.docx,.xml,application/msword, application/pdf" name="abstractfile" class="form-control required" placeholder="Abstract File">
                                        <small>Supported Formats - PDF or Word(.docx, .docs)</small>
                                    </div>

                                    <div class="form-group"  style="margin-bottom: 10px;">
                                        <label>Your Coments </label>
                                        <textarea name="comments" class="form-control" placeholder="Your Comments"></textarea>
                                    </div>

                                    <div id="bottom-wizard">
                                        <button type="submit" name="process" class="submit">Submit Abstract</button>
                                    </div>
                            </div>
                            </div>
                        </div>
                     
                        <!-- Include optional progressbar HTML -->
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>  
                    </form>
                   
                   </div>
                </div>
                <!-- /Wizard container -->
        </div>
        <!-- /content-right-->
    </div>
    <!-- /row-->
</div>

<span class="col-md-12" id="coauthorcontainer" hidden>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group"  style="margin-bottom: 10px;">
                <label>Co-Author Name <span style="color:red">*</span></label>
                <input type="text" name="coauthorname[]" class="form-control required" placeholder="Co Author Name">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group"  style="margin-bottom: 10px;">
                <label>Co-Author Email <span style="color:red">*</span></label>
                <input type="email" name="coauthoremail[]" class="form-control required" placeholder="Co Author Email">
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group"  style="margin-bottom: 10px;">
                <label>Co-Author Affiliation <span style="color:red">*</span></label>
                <input type="text" name="coauthoraffilliation[]" class="form-control required" placeholder="Co Author Affiliation">
            </div>
        </div> --}}
    </div>
</span>

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
     <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
     <script>
        var totalcount = 0;
        $(function(){
            $('#smartwizard').smartWizard();


            // Leave step event is used for validating the forms
            $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIdx, nextStepIdx, stepDirection) {
                // Validate only on forward movement  
                if (stepDirection == 'forward') {
                switch(currentStepIdx){
                    case 0:
                        
                        if(!$('#firstname').valid()){
                            return false;
                        }else if(!$('#lastname').valid()){
                            return false;
                        }else if(!$('#email').valid()){
                            return false;
                        }else if(!$('#phone').valid()){
                            return false;
                        }else if(!$('#institution').valid()){
                            return false;
                        }else if(!$('#regtype').valid()){
                            return false;
                        }else if(!$('#paymode').valid()){
                            return false;
                        }
                    case 1: 
                      
                  
                }
                }
            });
            
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

        function addCoAuthor(){
            var clone = $('#coauthorcontainer').clone().removeAttr('hidden');
            totalcount += 1;
            if(totalcount >= 0 && totalcount <= 4){
                $('#btnremove').show();
            }else if(totalcount >=4){
                $('#btnadd').hide();
                $('#btnremove').show();
            }
            $('#coauthor').append(clone);

            // $("#steppp2").height($("#steppp2").height()+100+'px');
            $("#steppp2").css("height", $("#steppp2").height()+200+'px');
           
        }

        function removeCoAuthor(){
            $('div#coauthor').children().last().remove();
            totalcount -=1;

            if(totalcount <= 0 ){
                $('#btnadd').show();
                $('#btnremove').hide();
            }else if(totalcount < 5){
                $('#btnadd').show();
                $('#btnremove').show();
            }

            
        }
       
        $('#wrapped').submit(function(event){
            event.preventDefault();
            var form = $("form#wrapped");
            form.validate();
            if (form.valid()) {
                Swal.fire({
                    title: "Submitting An Abstract",
                    text: "Are you sure?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#loader_form").fadeIn();
                            var data = new FormData($("#wrapped")[0]);
                            $.ajax({
                                url: "{{url('/submit-abstract')}}",
                                method: "POST",
                                data: data,
                                processData: false,
                                contentType: false,
                                cache: false,
                                enctype: 'multipart/form-data',
                                success: function(response){
                                    $("#loader_form").fadeOut();
                                    if(response.status == 'success'){

                                        Swal.fire(
                                            'Success',
                                            response.message,
                                            'success'
                                        ).then(() => {
                                            window.location.href = response.url;
                                        });

                                        setTimeout(() => {
                                            window.location.href = response.url;
                                        }, 2000);
                                    }else{
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