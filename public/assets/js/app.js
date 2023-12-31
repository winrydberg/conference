
function payWithPaystack(regno, email, csrf_token,amount) {

    var handler = PaystackPop.setup({ 
        key: 'pk_test_3ce2d98aa1858b9aea0ec527a239b8ad602b0908', //put your public key here
        email: email, //put your customer's email here
        amount: amount * 100, //amount the customer is supposed to pay
        currency: "GHS",
        // metadata: {
        //     custom_fields: [
        //         {
        //             display_name: "Mobile Number",
        //             variable_name: "mobile_number",
        //             value: "+2348012345678" //customer's mobile number
        //         }
        //     ]
        // },
        callback: function (response) {
            //after the transaction have been completed
            //make post call  to the server with to verify payment 
            //using transaction reference as post data
            $.post("complete-registration", {reference:response.reference, regno: regno, email: email, _token: csrf_token}, function(response){
                if(response.status == "success"){
                    $('#regModal').modal('hide');
                    Swal.fire(
                        'Registration Successful',
                        response.message,
                        'success'
                    ).then(() => {
                        $('#passwordModal').modal({backdrop: 'static', keyboard: false},'show');
                    });
                }else{
                      //transaction failed
                      alert(response);
                }
                  
            });
        },
        onClose: function () {

            //when the user close the payment modal
            alert('Transaction cancelled');
        }
    });
    handler.openIframe(); //open the paystack's payment modal
}