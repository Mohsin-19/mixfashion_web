//get value form hidden input file
var hidden_alert = $(".hidden_alert").val();
var hidden_ok = $(".hidden_ok").val();
var hidden_cancel = $(".hidden_cancel").val();
var thischaracterisnotallowed = $(".thischaracterisnotallowed").val();

jQuery(document).ready(function($) {
    "use strict";
    $(document).on('keydown', '.integerchk', function(e){
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
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
    $(document).on('keyup', '.integerchk', function(e){
        var input = $(this).val();
        var ponto = input.split('.').length;
        var slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+3)));
        if(input == '.')
            $(this).val("");

    });
    $(document).on('keyup', '.form-control', function(e){
        var input = $(this).val();
        var val = input.replace(/[!"#$%'*+\/;<=>?[\\\]^`{|}~]/g, "");
        $(this).val(val);
        var format = /[!"#$%'*+\/;<=>?[\\\]^`{|}~]/;
        if (format.test(input))
        {
            swal({
                title: hidden_alert+"!",
                text: thischaracterisnotallowed,
                cancelButtonText:hidden_cancel,
                confirmButtonText:hidden_ok,
                confirmButtonColor: '#3c8dbc',
            });
        }

    });
});