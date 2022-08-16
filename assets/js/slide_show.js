$(document).ready(function () {
  "use strict";
  // var input = document.getElementById('photo');
  let input = $("#photo");
  input.on("change", function () {
    var file = this.files[0];
    var img = new Image();
    //load image
    img.onload = function () {
      URL.revokeObjectURL(this.src);
      //calculate size of image
      var size = Math.round(Number(file.size) / 1024);
      //calculate width of image
      var width = Number(this.width);
      //calculate height of image
      var height = Number(this.height);

      if (width == 950 && height == 260) {
        if (Number(size) > 350) {
          $("#photo").val("");
          swal({
            title: hidden_alert + "!",
            text: file_size_check,
            confirmButtonText: hidden_ok,
          });
        }
      } else {
        // $("#photo").val("");
        // swal({
        //   title: hidden_alert + "!",
        //   text: file_w_h_check,
        //   confirmButtonText: hidden_ok,
        // });
      }
    };

    var objectURL = URL.createObjectURL(file);
    img.src = objectURL;
  });

  //show image preview
  $(document).on("click", ".show_preview", function (e) {
    e.preventDefault();
    var file_path = $(this).attr("href");
    $("#show_id").attr("src", file_path);
    $("#logo_preview").modal("show");
  });
});
