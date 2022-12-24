$(function () {
    "use strict";

    $(".parent_class").each(function(){
        var this_parent_name=$(this).attr('data-name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });

    $(document).on('click', '.child_class', function(e){
        var this_parent_name = $(this).attr('data-parent_name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });

    $(document).on('click', '.parent_class', function(e){
        var this_name=$(this).attr('data-name');

        var checked = $(this).is(':checked');
        if(checked){
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",false);
            });
        }
    });

    if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
        $("#checkbox_userAll").prop("checked", true);
    } else {
        $("#checkbox_userAll").removeAttr("checked");
    }
    // Check or Uncheck All checkboxes
    $(document).on('change', '#checkbox_userAll', function(e){
        var checked = $(this).is(':checked');
        if(checked){
            $(".checkbox_user").each(function(){
                $(this).prop("checked",true);
            });
            $(".checkbox_user_p").prop("checked", true);
        }else{
            $(".checkbox_user").each(function(){
                $(this).prop("checked",false);
            });
            $(".checkbox_user_p").prop("checked", false);
        }
    });
    $(document).on('click', '.checkbox_user', function(e){
        if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $("#checkbox_userAll").prop("checked", true);

        } else {
            $("#checkbox_userAll").prop("checked", false);
        }
    });
    $(document).on('submit', '#add_role', function(e){
        var temp = 0 ;
        var role_name = $("#role_name").val();
        var error = false;

        if(role_name==''){
            swal({
                title: hidden_alert+"!",
                text: required_roll_name,
                confirmButtonText:hidden_ok
            });

            $(".error_alert_role_name").html(required_roll_name);
            error = true;
        }else {
            $(".error_alert_role_name").html("");
        }
        $(".child_class").each(function(){
            var checked = $(this).is(':checked');
            if(checked){
                temp++;
            }
        });
        if(temp==0){
            swal({
                title: hidden_alert+"!",
                text: at_least_one_check_access,
                confirmButtonText:hidden_ok
            });
            $(".error_alert_atleast").html(at_least_one_check_access);
            return false;
        }else {
            $(".error_alert_atleast").html("");
        }
        if(error == true){
            return false;
        }
    });
    $('#will_login_yes').on('click',function(){
        $('#will_login_section').fadeIn();
    });
    $('#will_login_no').on('click',function(){
        $('#will_login_section').fadeOut();
    });
});