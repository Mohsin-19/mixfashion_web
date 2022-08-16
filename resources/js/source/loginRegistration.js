var timer1 = null,
  interval1 = 1000,
  timeInterval = 300;

function stopTime1() {
  clearInterval(timer1);
  timer1 = null;
  var timeInterval = 300;
}

(function ($) {

  function startTime1() {
    var timeInterval = 30;
    if (timer1 !== null) return;
    timer1 = setInterval(function () {
      timeInterval--;
      if (timeInterval < 1) {
        $('#resentOtp').removeAttr('disabled');
        $('.otp_counter').hide();
        stopTime1();
      } else {
        $(".otp_counter").html(timeInterval);
      }
    }, interval1);
  }

  function loadingIn() {
    $(".preloader").fadeIn();
  }

  function loadingOut() {
    $(".preloader").fadeOut();
  }



  $("body").on('submit', '#customer_signin', function (event) {
    event.preventDefault();
    var action = $(this).attr('action');
    var signinForm = $(this);
    $.ajax({
      type: 'POST',
      url: action,
      data: $(this).serialize(),
      beforeSend: function () {
        loadingIn();
      },
      success: function (data) {
        if (data.status === true) {
          $("#resentOtp")
            .css({
              backgroundColor: "#96b983",
              cursor: "no-drop"
            })
            .attr("data-access", "no access");
          startTime1();
          signinForm.find(".loginTitle").text(data.msg);
          $(".loginSubmitCard").fadeOut(300);
          $(".otpSubmitForm").fadeIn(300);
          $(".otpSubmitForm").find('#userPhone').val(data.l_phone);
        } else {
          swal_alert_sad(hidden_alert, data.msg);
        }
      },
      error: function (xhr) { // if error occurred
        console.log(xhr);
      },
      complete: function () {
        loadingOut();
      }
    });

  }).on('keyup', '#f_otpCode', function () {

    var otpCode = $(this).val();
    if (otpCode.length == 4) {
      $("#otp_form_submit").trigger('submit');
    }
    if (otpCode.length > 4) {
      swal_alert_sad(hidden_alert, 'OTP code maximum length 4');
      $(this).val('');
    }

  }).on('submit', '#otp_form_submit', function (event) {
    event.preventDefault();
    var action = $(this).attr('action');
    $.ajax({
      type: 'POST',
      url: action,
      data: $(this).serialize(),
      beforeSend: function () {
        loadingIn();
      },
      success: function (data) {
        if (data.status === true) {
          swal_alert_happy(hidden_alert, data.msg);
          window.location.assign('/');
        } else {
          $('#resentOtp').removeAttr('disabled');
          swal_alert_sad(hidden_alert, data.msg);
        }
      },
      error: function (xhr) { // if error occurred
        console.log(xhr);
      },
      complete: function () {
        loadingOut();
      }
    });

  }).on("click", "#resentOtp", function () {

    $('#customer_signin').trigger('submit');

  });




})(jQuery)