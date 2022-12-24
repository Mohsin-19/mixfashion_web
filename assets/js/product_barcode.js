$(function () {
    "use strict";
    $('.datatable').DataTable({
        'autoWidth'   : false,
        "paging":   false,
        'ordering' : false
    });

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
});