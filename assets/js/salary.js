$(document).ready(function() {
    "use strict";
    //check all
    checkAll();
    //check all function
    function checkAll() {
        if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $(".checkbox_userAll").prop("checked", true);
        } else {
            $(".checkbox_userAll").prop("checked", false);
        }
    }

    // Check or Uncheck All checkboxes
    $(document).on('click', '.checkbox_userAll', function(e){
        var checked = $(this).is(':checked');
        if (checked) {
            $(".checkbox_user").each(function () {
                var menu_id = $(this).attr('data-menu_id');
                $(this).prop("checked", true);
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            });
            $(".checkbox_userAll").prop("checked", true);
        } else {
            $(".checkbox_user").each(function () {
                var menu_id = $(this).attr('data-menu_id');
                $(this).prop("checked", false);
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            });
            $(".checkbox_userAll").prop("checked", false);
        }
    });
    $(document).on('click', '.checkbox_user', function(e){
        var menu_id = $(this).attr('data-menu_id');
        if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $(".checkbox_userAll").prop("checked", true);
            if($(this).is(':checked')){
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            }else{
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            }
        } else {
            $(".checkbox_userAll").prop("checked", false);
            if($(this).is(':checked')){
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            }else{
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            }
        }
    });
    $(document).on('keyup', '.cal_row', function(e){
        //calculate row
        cal_row();
    });

});
//call calculate row
cal_row();
function cal_row() {
    var total = 0;
    $(".row_counter").each(function () {
        var id = $(this).attr("data-id");

        var salary = $("#salary_"+id).val();
        var additional = $("#additional_"+id).val();
        var subtraction = $("#subtraction_"+id).val();

        if($.trim(salary) == "" || $.isNumeric(salary) == false){
            salary=0;
        }
        if($.trim(additional) == "" || $.isNumeric(additional) == false){
            additional=0;
        }
        if($.trim(subtraction) == "" || $.isNumeric(subtraction) == false){
            subtraction=0;
        }
        var total_row = parseFloat($.trim(salary)) + parseFloat($.trim(additional)) - parseFloat($.trim(subtraction));
        total+=total_row;
        $("#total_"+id).val(total_row.toFixed(2));
    });
    $(".total_amount").html(total.toFixed(2));
}