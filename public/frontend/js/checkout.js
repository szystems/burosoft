$(document).ready(function () {

    $('.razorpay-btn').click(function (e) {
        e.preventDefault();

        var firstname = $('.firstname').val();
        var lastname = $('.lastname').val();
        var email = $('.email').val();
        var phone = $('.phone').val();
        var address1 = $('.address1').val();
        var address2 = $('address2').val();
        var city = $('.city').val();
        var state = $('.state').val();
        var country = $('.country').val();
        var zipcode = $('.zipcode').val();
        var note = $('.note').val();

        if(!firstname)
        {
            fname_error = "First Name is required";
            $('#fname_error').html('');
            $('#fname_error').html('<font color="red"><strong>'+fname_error+'</strong></font>');
        }else
        {
            fname_error = "";
            $('#fname_error').html('');
        }

        if(!lastname)
        {
            lname_error = "Last Name is required";
            $('#lname_error').html('');
            $('#lname_error').html('<font color="red"><strong>'+lname_error+'</strong></font>');
        }else
        {
            lname_error = "";
            $('#lname_error').html('');
        }

        if(!email)
        {
            email_error = "Email is required";
            $('#email_error').html('');
            $('#email_error').html('<font color="red"><strong>'+email_error+'</strong></font>');
        }else
        {
            email_error = "";
            $('#email_error').html('');
        }

        if(!phone)
        {
            phone_error = "Phone is required";
            $('#phone_error').html('');
            $('#phone_error').html('<font color="red"><strong>'+phone_error+'</strong></font>');
        }else
        {
            phone_error = "";
            $('#phone_error').html('');
        }

        if(!address1)
        {
            address1_error = "Address 1 is required";
            $('#address1_error').html('');
            $('#address1_error').html('<font color="red"><strong>'+address1_error+'</strong></font>');
        }else
        {
            address1_error = "";
            $('#address1_error').html('');
        }

        if(!city)
        {
            city_error = "City is required";
            $('#city_error').html('');
            $('#city_error').html('<font color="red"><strong>'+city_error+'</strong></font>');
        }else
        {
            city_error = "";
            $('#city_error').html('');
        }

        if(!state)
        {
            state_error = "State is required";
            $('#state_error').html('');
            $('#state_error').html('<font color="red"><strong>'+state_error+'</strong></font>');
        }else
        {
            state_error = "";
            $('#state_error').html('');
        }

        if(!country)
        {
            country_error = "Country is required";
            $('#country_error').html('');
            $('#country_error').html('<font color="red"><strong>'+country_error+'</strong></font>');
        }else
        {
            country_error = "";
            $('#country_error').html('');
        }

        if(!zipcode)
        {
            zipcode_error = "Zipcode is required";
            $('#zipcode_error').html('');
            $('#zipcode_error').html('<font color="red"><strong>'+zipcode_error+'</strong></font>');
        }else
        {
            zipcode_error = "";
            $('#zipcode_error').html('');
        }

        if(fname_error != '' || lname_error != '' || email_error != '' || phone_error != '' || address1_error != '' || city_error != '' || state_error != '' || country_error != '' || zipcode_error != '')
        {
            return false;
        }else
        {
            var data = {
                'firstname' :firstname,
                'lastname' :lastname,
                'email' :email,
                'phone' :phone,
                'address1' :address1,
                'address2' :address2,
                'city' :city,
                'state' :state,
                'country' :country,
                'zipcode' :zipcode,
                'note' :note
            }

            $.ajax({
                method: "POST",
                url: "/proceed-to-pay",
                data: data,
                success: function (response) {
                    //alert(response.total_price)
                    var options = {
                        "key": "rzp_test_oRfSzsSGPgUAwU", // Enter the Key ID generated from the Dashboard
                        "amount": response.total_price*100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                        "currency": "INR",
                        "name": response.firstname+' '+response.lastname,
                        "description": "Test Transaction",
                        "image": "https://example.com/your_logo",
                        // "order_id": "order_9A33XWu170gUtm", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                        "handler": function (responsea){
                            //alert(response.razorpay_payment_id);
                            $.ajax({
                                method: "POST",
                                url: "/place-order",
                                data: {
                                    'fname' :response.firstname,
                                    'lname' :response.lastname,
                                    'email' :response.email,
                                    'phone' :response.phone,
                                    'address1' :response.address1,
                                    'address2' :response.address2,
                                    'city' :response.city,
                                    'state' :response.state,
                                    'country' :response.country,
                                    'zipcode' :response.zipcode,
                                    'payment_mode' :"Paid by Razorpay",
                                    'payment_id' : responsea.razorpay_payment_id,
                                },
                                success: function (responseb) {
                                    //alert(responseb.status);
                                    swal(responseb.status);
                                    window.location.href = "/my-orders";
                                }
                            });
                        },
                        "prefill": {
                            "name": response.firstname+' '+response.lastname,
                            "email": response.email,
                            "contact": response.phone
                        },
                        "theme": {
                            "color": "#3399cc"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                        rzp1.open();
                }
            });
        }

    });
});
