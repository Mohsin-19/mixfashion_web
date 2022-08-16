$(document).ready(function(){
	$("#addNewGuest").click(function(){
		var customer_name = $('input[name=customer_name]').val();
		var mobile_no = $('input[name=mobile_no]').val();
        var customerEmail = $('input[name=customerEmail]').val();
        var customer_address = $('input[name=customer_address]').val();

        //check valid email address
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
		var error = 0;
		if(customer_name == '') {
			error = 1;
            var cl1 = ".customer_err_msg";
            var cl2 = ".customer_err_msg_contnr";
            $(cl1).text("The Customer Name field is required");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=customer_name]').css('border', '1px solid #ccc');
		}
		if(mobile_no == '') {
            error = 1;
            var cl1 = ".customer_mobile_err_msg";
            var cl2 = ".customer_mobile_err_msg_contnr";
            $(cl1).text("The Phone field is required");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=mobile_no]').css('border', '1px solid #ccc');
		}
		if(customerEmail == '') {
            error = 1;
            var cl1 = ".customer_email_err_msg";
            var cl2 = ".customer_email_err_msg_contnr";
            $(cl1).text("The Email field is required");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
            if (!validateEmail(customerEmail)) {
                error = 1;
                var cl1 = ".customer_email_err_msg_contnr";
                var cl2 = ".customer_email_err_msg";
                $(cl1).text("Please enter valid email");
                $(cl2).show(200).delay(6000).hide(200,function(){
                });
            }else{
                $('input[name=customerEmail]').css('border', '1px solid #ccc');
			}

		}



		if(customer_address == '') {
            error = 1;
            var cl1 = ".customer_address_err_msg";
            var cl2 = ".customer_address_err_msg_contnr";
            $(cl1).text("The Address field is required");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=customer_address]').css('border', '1px solid #ccc');
		}

		if(error == 0) {
			$.ajax({
				url:baseURL+'Ajax/addNewCustomerByAjax',
				method:"GET",
				data: {
					customer_name:customer_name,
					mobile_no:mobile_no,
                    customerEmail:customerEmail,
                    customer_address:customer_address,
				},
				success:function(data){
					data=JSON.parse(data);
                    var customer_ids=data.customer_id;
                    $.ajax({
			                url:baseURL+'Ajax/getCustomerList',
			                method:"GET",
			                data: { },
			                success:function(data){
			                	$("#customer_id").empty();
                                $("#customer_id").append(data);
                                $('#customer_id').val(customer_ids).change();
			                }
			            });
					$('input[name=customer_name]').val('');
					$('input[name=mobile_no]').val('');
					$('.close').click();

				}
			});
		}

	});

});



/////////////////////////////////////////////////
/////////////////ADDING FIELD
///////////////////////////////////////////////



