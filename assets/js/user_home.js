(function($) {
    "use strict";
    //check valid email address
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    $('body').on('click', '.delete', function (e) {
        e.preventDefault();
        var linkURL = this.href;
        warnBeforeRedirect(linkURL);
    });

    $('body').on('click', '.delete_dummy_data', function (e) {
        e.preventDefault();
        var linkURL = this.href;
        warnBeforeRedirect1(linkURL);
    });
    function warnBeforeRedirect(linkURL) {
        swal({
            title: hidden_alert+"!",
            text: are_you_sure,
            cancelButtonText:hidden_cancel,
            confirmButtonText:hidden_ok,
            confirmButtonColor: '#3c8dbc',
            showCancelButton: true
        }, function() {
            window.location.href = linkURL;
        });
    }

    function warnBeforeRedirect1(linkURL) {
        swal({
            title: hidden_alert+"!",
            text: delete_msg_dummy_data,
            cancelButtonText:hidden_cancel,
            confirmButtonText:hidden_ok,
            confirmButtonColor: '#3c8dbc',
            showCancelButton: true
        }, function() {
            window.location.href = linkURL;
        });
    }

    $(document).on('keydown', '.integerchk', function(e){
        let keys = e.keyCode;
        // console.log(keys)
        return (
           keys === 8 ||
           keys === 9 ||
           keys === 13 ||
           keys === 46 ||
           keys === 110 ||
           keys === 86 ||
           keys === 190 ||
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
        var val = input.replace(/[]/g, "");
        $(this).val(val);
        var format = /[]/;
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
    $('table').addClass('table-responsive').removeClass('table-bordered');
    var window_height = $(window).height();
    var main_header_height = $('.main-header').height();
    var user_panel_height = $('.user-panel').height();
    var left_menu_height_should_be = (parseFloat(window_height)-(parseFloat(main_header_height)+parseFloat(user_panel_height))).toFixed(2);
    left_menu_height_should_be = (parseFloat(left_menu_height_should_be)-parseFloat(60)).toFixed(2);
    $(document).on('click', '.notif_class', function(e){
        var value = $(this).attr('data-value');
        if(value==1){
            $(".width_notification").show();
            $(this).attr('data-value',2);
        }else{
            $(".width_notification").hide();
            $(this).attr('data-value',1);
        }

    });
    function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
    //change notification status
    $(document).on('click', '.changeStatus', function(e){
        var id = $(this).attr("data-id");
        var value = $(this).attr("data-value");
        $.ajax({
            url     : base_url+'Ajax/change_status_notification',
            method  : 'get',
            dataType: 'json',
            data    : {
                'id' : id,
                'value' : value
            },
            success : function(data) {
                if(Number(value) == 3){
                    $(".delete_background").css("border-left", "unset");
                }
                $('#id_'+id).css("background-color", "transparent");
                $('#id_'+id).css("border-left", "unset");
                $('#totalNotifications').html(data.total_unread);
                window.location.href = base_url + "orderManagement/orders";
            },
            error   : function() {
                alert('somethingiswrong');
            }
        });
    });
    //delete notification row

    $(document).on('click', '.delete_notification', function(e){
        var id = $(this).attr("data-id");
        $.ajax({
            url     : base_url+'Ajax/delete_row_notification',
            method  : 'get',
            dataType: 'json',
            data    : {
                'id' : id
            },
            success : function(data) {
                $('#id_'+id).remove();
                $('#totalNotifications').html(data.total_unread);
            },
            error   : function() {
                alert('somethingiswrong');
            }
        });
    });

    setInterval(function(){
        //get notification unread data every 20 seconds
        $.ajax({
            url     : base_url+'Ajax/getNotifications',
            method  : 'get',
            dataType: 'json',
            data    : {

        },
        success : function(data) {
            $(".append_notification").html(data.html);
            $('#totalNotifications').html(data.total_unread);
            //if total new availabe then system will throw a bell
            if(Number(data.total_new)){
                let placeOrderSound = new Howl({
                    src:[base_url+'assets/media/bip.mp3']
                });
                placeOrderSound.play();
            }
        },
        error   : function() {

        }
    });

    }, 20000);

})(jQuery);






