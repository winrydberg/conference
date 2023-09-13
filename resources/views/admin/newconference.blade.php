@extends('admin.includes.master')

@section('pagestyles')
  <link rel="stylesheet" href="{{asset('adminassets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminassets/bower_components/select2/dist/css/select2.min.css')}}">
  <style>
	.error {
		color: red;
	}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">New  Conference</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">New Conference</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <p style="padding-top: 20px; padding-bottom: 20px; font-size: 20px;" ><strong>NB</strong> Field marked with (<span style="color:red;">*</span></label>) are required</p>
                <form method="POST" id="newConference" action="#">
                    {{csrf_field()}}
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Title <span style="color:red;">*</span></label>
                        <input class="form-control required" name="title" id="title"/>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Theme</label>
                        <input  class="form-control" name="theme" id="theme"/>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Venue Name <span style="color:red;">*</span></label></label>
                        <input  class="form-control required"  name="venue" id="venue"/>
                      </div>
                    </div>

                    {{-- <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Venue (Google Maps Location)</label>
                        <input  class="form-control" name="googlemaps" id="googlemaps"/>
                      </div>
                    </div> --}}
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="usernamecont">
                        <label for="name">About Conference <span style="color:red;">*</span></label></label>
                        <textarea class="form-control required"  rows="5" name="description" id="description"></textarea>
                      </div>
                    </div>
                  </div>


                 <br />
                 <br />
                 <br />

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Conference Start Date# <span style="color:red;">*</span></label></label>
                        <input type="date"  class="form-control required" name="startdate" id="startdate"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Conference End Date#</label>
                        <input type="date" class="form-control" name="enddate" id="enddate"/>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Conference Start Time# <span style="color:red;">*</span></label></label>
                        <input type="time" class="form-control required"  name="starttime" id="starttime"/>
                      </div>
                    </div>

                    {{-- <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">End Time#</label>
                        <input type="time" class="form-control" name="endtime" id="endtime"/>
                      </div>
                    </div> --}}
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group" >
                        <label for="name">Receive Abstract? <span style="color:red;">*</span></label></label>
                        <select class="form-control required"  name="receive_abstract" id="receie_abstract">
                          
                          <option value="1">Receive Abstract</option>
                          <option value="0">Not Receiving Abstract</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" >
                        <label for="name">Open</label>
                        <select class="form-control" name="isopen" id="isopen">
                          <option value="1">Open For Registration</option>
                          <option value="0">Not Opened For Registration</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Reg Start Date#</label>
                        <input type="date" class="form-control" name="reg_startdate" id="reg_startdate"/>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Reg End Date#</label>
                        <input type="date" class="form-control" name="reg_enddate" id="reg_enddate"/>
                      </div>
                    </div>
                  </div>

                  <hr />

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group" >
                        <label for="name">Conference Brochure</label>
                        <input type="file" class="form-control" accept="application/pdf" name="brochure" id="brochure"/>
                        <small style="color:brown;">Accepted Format - PDF</small>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="firstname">Abstract Template</label>
                        <input id="abstract_temp" class="form-control" name="abstract_temp" multiple  type="file" >   
                      </div>
                    </div>
                  </div>

                  <br/>
                  <br/>
                  <br/>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Participation Benefits <span style="color:red;">*</span></label></label>
                        <textarea class="form-control required" rows="5" name="benefits" id="benefits"></textarea>
                      </div>
                    </div>
                  </div>
                  <br/>
                  <br/>
                  <br/>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="usernamecont">
                        <label for="name">Conference Organizers & Contact Info <span style="color:red;">*</span></label></label>
                        <textarea class="form-control required" rows="5" name="organizers" id="organizers"></textarea>
                      </div>
                    </div>
                  </div>

                 <br />
                 <br />
                 <br />

                  <legend>Payment Informartion</legend>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group" >
                        <label for="name">Payment Requirement <span style="color:red;">*</span></label></label>
                        <select class="form-control required" name="require_payment" id="require_payment">
                          <option value="1">Registration Require Payment</option>
                          <option value="0">Payment Not Required</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4" id="paymentmethodcon">
                      <div class="form-group" >
                        <label for="name">Payment Method</label>
                        <select class="form-control select2" multiple="multiple" name="payment_methods[]" id="payment_methods">
                          @foreach($paymodes as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-5" id="bankaccountcon" style="display:none;">
                      <div class="form-group" >
                        <label for="name">Bank Account Info#</label>
                        <textarea class="form-control required accinfo" name="accinfo" id="accinfo"></textarea>
                        <small>Account Information# for participants to deposit money</small>
                        <p style="color:red;">NB: Please double check inputs</p>
                      </div>
                    </div>
                  </div>

                  <div id="payment">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" >
                          <label for="name">Category <span style="color:red;">*</span></label>
                          <input type="text"  class="form-control required" name="category[]"/>
                          <small>Eg. Students, Researchers, Industry Experts</small>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="firstname">Select Currency <span style="color:red;">*</span></label>
                          <select class="form-control required" name="currency[]" id="currency">
                            <option value="GHS">GHS</option>
                            <option value="USD">USD</option>
                          </select> 
                        </div>
                      </div>
  
                      <div class="col-md-3">
                        <div class="form-group" >
                          <label for="name">Amount <span style="color:red;">*</span></label>
                          <input type="number" class="form-control required" name="amount[]" />
                          <small>Eg. 100, 200, 300 etc</small>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="row col-md-12" id="paymentbtns">
                    <button class="btn btn-danger btn-sm" onclick="addNewPaymentField()" type="button">Add Payment Category</button>
                    <button id="removeFieldBtn" class="btn btn-warning btn-sm" onclick="removePaymentField()" style="display:none;"  type="button">Remove One</button>
                  </div>


                  
                {{-- 
                  <legend style="margin-bottom: 20px; margin-top: 20px;">Other Downloadable Attachment(s)</legend>
                  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="firstname">Select Files</label>
                          <input id="input-id" name="documents[]" multiple  type="file" >   
                        </div>
                      </div>
                  </div> --}}


                  <br />
                  <br />
                  <br />
                  <br />

                  <span style="margin-top: 50px;">
                  <legend>Partners or Sponsors</legend>
                  
                  <div id="sponsors" style>
                    <p>Use the below button to add sponsors</p>
                  </div>

                  <div class="row col-md-12" style="margin-bottom: 100px;">
                    <button class="btn btn-danger btn-sm" onclick="addSponsor()" type="button">Add Sponsor</button>
                    <button id="rmSponsordBtn" class="btn btn-warning btn-sm" onclick="removeSponsor()" style="display:none;"  type="button">Remove Sponsor</button>
                  </div>
                </span>

                  <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Conference</button>
                      </div>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>



    <div class="row" id="paymentcategory" hidden>
      <div class="col-md-6">
        <div class="form-group" >
          <label for="name">Category <span style="color:red;">*</span></label>
          <input type="text"  class="form-control required" name="category[]"/>
          <small>Eg. Students, Researchers, Industry Experts</small>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label for="firstname">Select Currency</label>
          <select class="form-control required" name="currency[]" id="currency">
            <option value="GHS">GHS</option>
            <option value="USD">USD</option>
          </select> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group" >
          <label for="name">Amount (GHC) <span style="color:red;">*</span></label>
          <input type="number"  class="form-control required" name="amount[]" />
          <small>Eg. 100, 200, 300 etc</small>
        </div>
      </div>
    </div>

    <div class="row" id="sponsortemp" hidden style="margin-bottom: 20px;">
      <div class="col-md-6">
        <div class="form-group" >
          <label for="name">Name</label>
          <input type="text"  class="form-control required" name="sponsorname[]"/>
          <small>Eg. UG</small>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group" >
          <label for="name">Logo</label>
          <input type="file" onchange="sponsor_logopath(this)" accept="image/png, image/jpeg" class="form-control required" name="logo[]" />
        </div>
      </div>

      <div class="col-md-3" id="previewcon">
        {{-- <img src="#"  alt="sponsor-logo"/> --}}
      </div>
    </div>
 
@stop


@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/filetype.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/fileinput.min.js"></script>
<script src="{{asset('adminassets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#input-id").fileinput({'previewFileType': 'any', 'showUpload': false, 'maxFileCount': 0});
    });
</script>
<!-- CK Editor -->
<script src="{{asset('adminassets/bower_components/ckeditor/ckeditor.js')}}"></script>
<script>
  var ckeditor_config = [
      { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
      // { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
      { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
      { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
      // '/',
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
      { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
      { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
      // { name: 'insert', items: [ 'Image', 'Flash', 'SpecialChar', 'PageBreak', ] },
    
      { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
      { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
      { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
      { name: 'others', items: [ '-' ] },
      { name: 'about', items: [ 'About' ] }
  ]
  $(function () {
    $('.select2').select2()
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('description', {toolbar : ckeditor_config}) 
    CKEDITOR.replace('benefits', {toolbar : ckeditor_config})
    CKEDITOR.replace('organizers', {toolbar : ckeditor_config})
    CKEDITOR.replace('accinfo', {toolbar : ckeditor_config})
  })
</script>
<script>

    var pcount = 1;
    var scount = 1;

    function addNewPaymentField(){
      var cloned = $('#paymentcategory').clone().removeAttr('hidden');
      $("#payment").append(cloned);
      pcount +=1
      if(pcount>=2){
        $('#removeFieldBtn').show()
      }else{
        $('#removeFieldBtn').hide()
      }
    }

    function removePaymentField(){
      $("#payment").children("div:last").remove();
      if(pcount>=2){
        pcount -= 1;
      }
      if(pcount <=1){
        $('#removeFieldBtn').hide()
      }else{
        $('#removeFieldBtn').show()
      }
    }



    function addSponsor(){
      scount +=1
      var clonedsponsor = $('#sponsortemp').clone().attr('id', 'sponsor_'+scount).removeAttr('hidden');
      clonedsponsor.find("img").attr('id','img_'+scount)
      clonedsponsor.find("#previewcon").attr('id','previewcon_'+scount)
      clonedsponsor.find("input[type=text]").prop('required',true)
      clonedsponsor.find("input[type=file]").attr('id',scount).prop('required',true);
      $("#sponsors").append(clonedsponsor);
      
      
      if(scount>=2){
        $('#rmSponsordBtn').show()
      }else{
        $('#rmSponsordBtn').hide()
      }
    }

    function removeSponsor(){
      $("#sponsors").children("div:last").remove();
      if(scount>=2){
        scount -= 1;
      }
      if(scount <=1){
        $('#rmSponsordBtn').hide()
      }else{
        $('#rmSponsordBtn').show()
      }
    }
    


    $('#newConference').submit(function(event){
        event.preventDefault();
        
        var data = new FormData($("#newConference")[0]);
        var title = 'Registering new conference';

        var form = $("#newConference");
        form.validate();
        if (form.valid()) {
          Swal.fire({
            title: title,
            text: "Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
                    url: "{{url('/new-conference')}}",
                    method: "POST",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    success: function(res){
                        if(res.status =='success'){
                            Swal.fire(
                                'Success',
                                res.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire(
                                'Error',
                                res.message,
                                'error'
                            );
                        }
                    },
                    error: function(error){
                        console.log(error),
                        Swal.fire(
                                'Error',
                                "Oops something went wrong.",
                                'error'
                            );
                    }
                   })
                }
            })
        }
        
    })



    //monitor payment requirement
    $('#require_payment').on('change', function(){
        var pselected = $('#require_payment').val();
        if(pselected == '1'){
          $('#payment').show();
          $('#paymentbtns').show();
          $('#paymentmethodcon').show();
          $('#bankaccountcon').show();
        }else{
          $('#payment').hide();
          $('#paymentbtns').hide();
          $('#paymentmethodcon').hide();
          $('#bankaccountcon').hide();
        }
    })

    //payment methods on change handler
    $('#payment_methods').on('change', function(){
      var msselected = $('#payment_methods').val();
      console.log(msselected)
      if(msselected.includes('1')){
        $('#bankaccountcon').show();
        $("accinfo").prop('required',true);
      }else{
        $('#bankaccountcon').hide();
      }
    })

    function sponsor_logopath(input){
          var elementid = input.id
          const fileSize = input.files[0].size / 1024 / 1024; // in MiB
          if(fileSize > 2){
            $('#img_'.elementid).val('');
            Swal.fire('Error', "File size bigger than 2MB. Please reduce file size and upload again.",'error').then(() => {
              $('#img_'.elementid).css('border-color', 'red');
            });
          }else{
            var img = $('<img />', { 
              id: 'img_'+elementid,
              src: (window.URL ? URL : webkitURL).createObjectURL(input.files[0]),
              class: 'img-responsive',
              height: '100px',
              width: '100px',
              alt: 'Sponsor-Logo'
            });
            img.appendTo($('#previewcon_'+elementid).empty());
          }
    }

</script>


@stop