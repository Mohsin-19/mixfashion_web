$(function () {
    "use strict";
    $(document).on('change', '#supplier_id', function(e){
        var supplier_id = $('#supplier_id').val();
        $.ajax({
            type: "GET",
            url: base_url+'SupplierPayment/getSupplierDue',
            data: {
                supplier_id: supplier_id,
                get_csrf_token_name: get_csrf_hash
            },
            success: function(data){
                $("#remaining_due").show();
                $("#remaining_due").text(data+" "+currency);
            }
        });
    });

    //payment method disabled if amount is 0
    var amount=$('#amount').val();
    if(Number(amount)==0){
        $("#payment_method_id").prop("disabled", true);
    }else{
        $("#payment_method_id").prop("disabled", false);
    }

    $(document).on('keyup', '#amount', function(e){
        var amount=$('#amount').val();
        if(Number(amount)==0){
            $("#payment_method_id").prop("disabled", true);
        }else{
            $("#payment_method_id").prop("disabled", false);
        }
    });
});