$(document).ready(function(){

    //check valid email address
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $(document).on('click', '#addSupplier', function(e){
		var name = $('input[name=name]').val();
		var contact_person = $('input[name=contact_person]').val();
		var phone = $('input[name=phone]').val();
		var emailAddress = $('input[name=emailAddress]').val();
		var previous_due = $('input[name=previous_due]').val();
		var supAddress = $('textarea[name=supAddress]').val();
		var description = $('textarea[name=description]').val();
		var error = 0;
		if(name == '') {
			error = 1;
            var cl1 = ".supplier_err_msg";
            var cl2 = ".supplier_err_msg_contnr";
            $(cl1).text("The Supplier Name field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=name]').css('border', '1px solid #ccc');
		}
		if(contact_person == '') {
			error = 1;
            var cl1 = ".customer_err_msg";
            var cl2 = ".customer_err_msg_contnr";
            $(cl1).text("The Contact Person field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=contact_person]').css('border', '1px solid #ccc');
		}
		if(phone == '') {
            error = 1;
            var cl1 = ".customer_phone_err_msg";
            var cl2 = ".customer_phone_err_msg_contnr";
            $(cl1).text("The phone No field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=phone]').css('border', '1px solid #ccc');
		}
		if(emailAddress){
            if (!validateEmail(emailAddress)) {
                error = 1;
                var cl1 = ".supplier_email_err_msg";
                var cl2 = ".supplier_email_err_msg_contnr";
                $(cl1).text("Please enter valid email!");
                $(cl2).show(200).delay(6000).hide(200,function(){
                });
            }else{
                $('input[name=emailAddress]').css('border', '1px solid #ccc');
            }
		}


		if(error == 0) {
			$.ajax({
				url:base_url+'Purchase/addNewSupplierByAjax',
				method:"GET",
				data: {
                    name:name,
                    contact_person:contact_person,
					phone:phone,
                    emailAddress:emailAddress,
                    supAddress:supAddress,
                    previous_due:previous_due,
                    description:description
				},
				success:function(data){
					data=JSON.parse(data);
                    var supplier_id=data.supplier_id;
                    $.ajax({
			                url:base_url+'Purchase/getSupplierList',
			                method:"GET",
			                data: { },
			                success:function(data){
			                	$("#supplier_id").empty();
                                $("#supplier_id").append(data);
                                $('#supplier_id').val(supplier_id).change();
			                }
			            });
                    $('.close').click();
				}
			});
		}

	});

});



/////////////////////////////////////////////////
/////////////////ADDING FIELD
///////////////////////////////////////////////



