$(document).ready(function() {
    "use strict";
    //initial color picker
    $('.getColor').colorpicker();
    //check previous check languages
    function checkSelected(language){
        var return_status = '';
        for (var i = 0; i < window.languages.length; i++) {
            var value_ = window.languages[i].value;
            if(value_==language){
                return_status = "selected"
            }
        }
        return return_status;
    }


    var input = document.getElementById('favicon');
    input.addEventListener("change", function() {
        var file  = this.files[0];
        var img = new Image();
        //call on load
        img.onload = function() {
            URL.revokeObjectURL(this.src);
            //calculate image size
            var size = Math.round(Number(file.size)/1024);
            //get width
            var width = Number(this.width);
            //get height
            var height = Number(this.height);
            if(width==16 && height==16){
                if(Number(size)>10){
                    $("#favicon").val('');
                    swal({
                        title: hidden_alert,
                        text: favicon_size_check,
                        confirmButtonText:hidden_ok,
                    });
                }
            }else{
                $("#favicon").val('');
                swal({
                     title: hidden_alert,
                    text: favicon_w_h_check,
                    confirmButtonText:hidden_ok,
                });
            }
        }

        var objectURL = URL.createObjectURL(file);
        img.src = objectURL;
    });

    input = document.getElementById('login_page_bg');
    input.addEventListener("change", function() {
        var file  = this.files[0];
        var img = new Image();
        //call on load
        img.onload = function() {
            URL.revokeObjectURL(this.src);
            //calculate image size
            var size = Math.round(Number(file.size)/1024);
            //get width
            var width = Number(this.width);
            //get height
            var height = Number(this.height);

            if(width==1571 && height==1102){
                if(Number(size)>300){
                    $("#login_page_bg").val('');
                    swal({
                         title: hidden_alert,
                        text: login_size_check,
                        confirmButtonText:hidden_ok,
                    });
                }
            }else{
                $("#login_page_bg").val('');
                swal({
                     title: hidden_alert,
                    text: login_w_h_check,
                    confirmButtonText:hidden_ok,
                });
            }
        }

        var objectURL = URL.createObjectURL(file);
        img.src = objectURL;
    });


    input = document.getElementById('site_logo');
    input.addEventListener("change", function() {
        var file  = this.files[0];
        var img = new Image();
        //call this function on change
        img.onload = function() {
            URL.revokeObjectURL(this.src);
            //calculate the image size
            var size = Math.round(Number(file.size)/1024);
            //get width
            var width = Number(this.width);
            //get height
            var height = Number(this.height);
            if(width==164 && height==40){
                if(Number(size)>50){
                    $("#site_logo").val('');
                    swal({
                         title: hidden_alert,
                        text: site_size_check,
                        confirmButtonText:hidden_ok,
                    });
                }
            }else{
                // $("#site_logo").val('');
                // swal({
                //      title: hidden_alert,
                //     text: site_w_h_check,
                //     confirmButtonText:hidden_ok,
                // });
            }
        }

        var objectURL = URL.createObjectURL(file);
        img.src = objectURL;
    });

    setTimeout(function () {
        var html = "<option value=''>'+select_+'</option>";
        $(".get_lg").each(function(){
            var this_value = $(this).attr('value');
            var text = $(this).attr('data-text');

            html += "<option "+checkSelected(this_value)+" value='"+this_value+"'>"+text+"</option>";
        });
        $("#site_languages").html(html);
    }, 1000);
    var _URL = window.URL || window.webkitURL;


    //check logo size width, height
    $(document).on('change','#login_logo' , function(){
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                var img_width = this.width;
                var height = this.height;
                if(img_width!="128" && height!="49" ){
                    $("#login_logo").val('');
                    swal({
                        title: hidden_alert,
                        text: image_msg+'!!',
                        confirmButtonText:hidden_ok,
                        confirmButtonColor: '#3c8dbc'
                    });
                }
            };
            img.src = _URL.createObjectURL(file);
        }
    });
    //before submit form all site languages set in hidden input filed checking in controller for check select at least one language select
    $(document).on('click','.submit_form' , function(){
        var site_languages = $("#site_languages").val();
        $("#site_languages_h").val(site_languages);
    });
    //check logo size width, height
    $(document).on('change','#admin_panel_logo' , function(){
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                var img_width = this.width;
                var height = this.height;
                if(img_width!="128" && height!="49" ){
                    $("#admin_panel_logo").val('');
                    swal({
                        title: hidden_alert,
                        text: image_msg+'!!',
                        confirmButtonText:hidden_ok,
                        confirmButtonColor: '#3c8dbc'
                    });
                }
            };
            img.src = _URL.createObjectURL(file);
        }
    });
    //preview the selected images
    $(document).on('click','.show_preview' , function(e){
        var file_path = $(this).attr('data-file_path');
        var id = $(this).attr("data-id");
        e.preventDefault();
        if(id==2){
            $("#show_id1").attr('src',file_path);
            $("#show_id1").css('width',"100%");
            $("#logo_preview_login_page").modal("show");
        }else{
            if(id==3){
                $("#logo_preview_icon_img").attr('src',file_path);
                $("#logo_preview_icon").modal("show");
            }else{
                $("#show_id").attr('src',file_path);
                $("#show_id").css('width',"unset");
                $("#logo_preview").modal("show");
            }
        }

    });
});