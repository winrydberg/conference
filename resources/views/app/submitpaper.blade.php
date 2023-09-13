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

<section class="parallax_window_in"  data-parallax="scroll" data-image-src="{{asset('assets/img/cardbg.jpeg')}}" data-natural-width="1400" data-natural-height="800">
    <div id="sub_content_in">
        <h1>Submit An Abstract / Paper</h1>
        <a href="{{url('/')}}" class="btn_1 rounded">Go Home</a>
    </div>
</section>
<!-- /section -->

<main id="general_page">

    <div class="container margin_60">
        <div class="main_title">
            <h3><em></em>{{$conference->title}}</h3>
            <p>
                Complete the below form to register and submit an abstract.
            </p>
        </div>	
        <!--Team Carousel -->
        <div class="row">
            <div class="col-md-10" style="margin: 0 auto;">
                <form id="wrapped" class="cmxform" method="POST">
                    {{csrf_field()}}
                    
                    <input id="website" name="website" type="text" value="">
                    <input id="conferenceid" class="form-control" style="display:none;" name="conferenceid" type="text" value="{{$conference->id}}">
                    

                    <div class="row"  style="margin-bottom: 10px;">
                        <div class="col-md-2">
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
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>First Name <span style="color:red">*</span></label>
                                <input type="text" name="firstname" id="firstname" class="form-control required" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Last Name <span style="color:red">*</span></label>
                                <input type="text" name="lastname" id="lastname" class="form-control required" placeholder="Last Name">
                            </div>
                        </div>
                    </div>

                    <div class="row"  style="margin-bottom: 1rem;;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address <span style="color:red">*</span></label>
                                <input type="email" id="email" {{request()->get('email') != null ? 'readonly': ''}} value="{{request()->get('email')}}" name="email" class="form-control required" placeholder="Your Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"  >
                                <label>Phone No <span style="color:red">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control required" placeholder="Your Phone No.">
                            </div>
                        </div>
                   </div>

                   <div class="form-group"  style="margin-bottom: 1rem;;">
                        <label>Institution <span style="color:red">*</span></label>
                        <input type="text" id="institution" name="institution" class="form-control required" placeholder="Institution">
                    </div>

                    @if($conference->payment_categories != null && count($conference->payment_categories) > 0)
                        <div class="row"  style="margin-bottom: 1rem;">
                            <div class="col-md-6">
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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
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
                            </div>
                        </div>
                   
                     @else
                         <div class="form-group"  style="margin-bottom: 1rem;">
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



                    <div class="form-group"  style="margin-bottom: 1rem;">
                        <label>Abstract Title <span style="color:red">*</span></label>
                        <textarea name="title" rows="5" class="form-control required" placeholder="Abstract Title"></textarea>
                    </div>

                    <div class="row" id="coauthor" style="margin-bottom: 10px; margin-top: 10px;">
                        <p class="col-md-12" style="color:brown;"><i class="fa fa-info"></i> Add up to five(5) co-authors</p>
                        
                    </div>

                    <div class="pull-right" style="margin-bottom: 1rem;">
                         <button type="button" id="btnadd" onclick="addCoAuthor()" class=" btn-xs btn-success pull-right" >Add Co-Author</button>
                         <button type="button" style="display:none;" id="btnremove" onclick="removeCoAuthor()" class=" btn-xs btn-warning pull-right" >Remove Co-Author</button>
                    </div>

                    <div class="row"  style="margin-bottom: 1rem;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Corresponding Author Name <span style="color:red">*</span></label>
                                <input type="text" name="corresponding_author_name" class="form-control required" placeholder="Corresponding Author Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Corresponding Author Active Email  <span style="color:red">*</span></label>
                                <input type="email" name="corresponding_author_email" class="form-control required" placeholder="Corresponding Author EMail">
                            </div>
                        </div>
                    </div>

                    <div class="row"  style="margin-bottom: 1rem;">
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label>Abstract Thematic <span style="color:red">*</span></label>
                                <div class="styled-select clearfix">
                                    <select class="wide required form-control" id="thematicarea" name="thematicarea">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="Basic exploratory research">Basic Scientific Research</option>
                                        <option value="Sustainable Solutions">Sustainable Solutions (Applied Research)</option>                          
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" >
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
                        </div>
                    </div>

                    

                    

                    <div class="form-group"  style="margin-bottom: 1rem;">
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

                    <div class="form-group"  style="margin-bottom: 1rem;">
                        <label>Abstract File <span style="color:red">*</span></label>
                        <input type="file" accept=".doc,.docx,.xml,application/msword, application/pdf" name="abstractfile" class="form-control required" placeholder="Abstract File">
                        <small>Supported Formats - PDF or Word(.docx, .docs)</small>
                    </div>

                    <div class="form-group"  style="margin-bottom: 1rem;">
                        <label>Your Comments </label>
                        <textarea name="comments" rows="5" class="form-control" placeholder="Your Comments"></textarea>
                    </div>

                    <div id="bottom-wizard">
                        <button type="submit" name="process" class="btn_1 submit">Submit Abstract</button>
                    </div>

                    
                {{-- </div>   --}}
                </form>
            </div>
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
    </div>
</span>

@stop


@section('scripts')
{{-- <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

{{-- <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/common_scripts.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/velocity.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/functions.js')}}"></script> --}}
<script src="{{asset('assets/js/parallax.min.js')}}"></script>
<script src="{{asset('assets/js/owl-carousel.js')}}"></script>
<script>
   var totalcount = 0;
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