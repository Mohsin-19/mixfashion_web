jQuery(document).ready(function($) {
    "use strict";
    //return 0-9 digit only

    $(document).on('keydown', '.integerchk1', function(e){
        return (
            keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105));
    });
    //return 0-9 digit only
    $(document).on('keyup', '.integerchk1', function(e){

        var input = $(this).val();
        var ponto = input.split('.').length;
        var slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });

    //check amount for disable the payment method
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