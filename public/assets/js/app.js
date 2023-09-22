
function payWithPaystack(regno, email, csrf_token) {

    var handler = PaystackPop.setup({ 
        key: 'pk_test_f02ee58fdf8d7cf81bcce6ac5f5c46bdb5a39f93', //put your public key here
        email: email, //put your customer's email here
        amount: 15000, //amount the customer is supposed to pay
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