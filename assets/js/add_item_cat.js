$('.getColor').colorpicker();
$(document).ready(function() {
    "use strict";

    $(document).on('click','.show_preview' , function(e){
        var file_path = $(this).attr('data-file_path');
        e.preventDefault();
        if(file_path){
            $("#show_id1").attr('src',base_url+"images/"+file_path);
        }else{
            $("#show_id1").removeAttr('src');
        }

        $("#show_id1").css('width',"100%");
        $("#showPreviewImage").modal("show");
    });

    var input = document.getElementById('top_banner');
    input.addEventListener("change", function() {
        var file  = this.files[0];
        var img = new Image();
        //call onload
        img.onload = function() {
            URL.revokeObjectURL(this.src);
            //calculate size of image
            var size = Math.round(Number(file.size)/1024);
            //calculate width of image
            var width = Number(this.width);
            //calculate height of image
            var height = Number(this.height);

            if(width==1170 && height==150){
                if(Number(size)>200){
                    $("#top_banner").val('');
                    swal({
                        title: hidden_alert+"!",
                        text: top_banner_image_msg_size,
                        confirmButtonText:hidden_ok
                    });
                }
            }else{
                $("#top_banner").val('');
                swal({
                    title: hidden_alert+"!",
                    text: top_banner_image_msg,
                    confirmButtonText:hidden_ok
                });
            }
        }

        var objectURL = URL.createObjectURL(file);
        img.src = objectURL;
    });

    input = document.getElementById('bottom_left_banner');
    input.addEventListener("change", function() {
        var file  = this.files[0];
        var img = new Image();
        //call on load
        img.onload = function() {
            URL.revokeObjectURL(this.src);
            //calculate size of image
            var size = Math.round(Number(file.size)/1024);
            //calculate width of image
            var width = Number(this.width);
            //calculate height of image
            var height = Number(this.height);

            if(width==300 && height==515){
                if(Number(size)>200){
                    $("#bottom_left_banner").val('');
                    swal({
                        title: hidden_alert+"!",
                        text: top_banner_image_msg_size,
                        confirmButtonText:hidden_ok
                    });
                }
            }else{
                $("#bottom_left_banner").val('');
                swal({
                    title: hidden_alert+"!",
                    // text: bottom_left_right_banner_image_msg,
                    text: "Image size should be width: 300px & height: 515px",
                    confirmButtonText:hidden_ok
                });
            }
        }

        var objectURL = URL.createObjectURL(file);
        img.src = objectURL;
    });


    input = document.getElementById('bottom_top_banner');
    input.addEventListener("change", function() {
        var file  = this.files[0];
        var img = new Image();
        //call on load
        img.onload = function() {
            URL.revokeObjectURL(this.src);
            //calculate size of image
            var size = Math.round(Number(file.size)/1024);
            //calculate width of image
            var width = Number(this.width);
            //calculate height of image
            var height = Number(this.height);

            if(width==690 && height==280){
                if(Number(size)>200){
                    $("#bottom_top_banner").val('');
                    swal({
                        title: hidden_alert+"!",
                        text: top_banner_image_msg_size,
                        confirmButtonText:hidden_ok
                    });
                }
            }else{
                $("#bottom_top_banner").val('');
                swal({
                    title: hidden_alert+"!",
                    text: bottom_left_right_banner_image_msg,
                    confirmButtonText:hidden_ok
                });
            }
        }

        var objectURL = URL.createObjectURL(file);
        img.src = objectURL;
    });

    input = document.getElementById('bottom_right_banner');
    input.addEventListener("change", function() {
        var file  = this.files[0];
        var img = new Image();
        //load image
        img.onload = function() {
            URL.revokeObjectURL(this.src);
            //calculate size of image
            var size = Math.round(Number(file.size)/1024);
            //calculate width of image
            var width = Number(this.width);
            //calculate height of image
            var height = Number(this.height);

            if(width==690 && height==280){
                if(Number(size)>200){
                    $("#bottom_right_banner").val('');
                    swal({
                       title: hidden_alert+"!",
                        text: top_banner_image_msg_size,
                        confirmButtonText:hidden_ok
                    });
                }
            }else{
                $("#bottom_right_banner").val('');
                swal({
                    title: hidden_alert+"!",
                    text: bottom_left_right_banner_image_msg,
                    confirmButtonText:hidden_ok
                });
            }
        }

        var objectURL = URL.createObjectURL(file);
        img.src = objectURL;
    });
});