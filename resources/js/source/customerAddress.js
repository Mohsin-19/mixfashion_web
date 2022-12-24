import {getDeliveryCharge} from "./cart";

window.intlTelInput = require('intl-tel-input');
// window.utils = require('../../plugins/intl-tel-input/build/js/utils');

window.validatePhone = function (validation, replacer) {
   var consultInput = document.querySelector(validation);
   // var errorMsg = document.querySelector("#error-msg");
   // var validMsg = document.querySelector("#valid-msg");
   var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number",];


   var iti = window.intlTelInput(consultInput, {
      allowDropdown: false,
      separateDialCode: true,
      onlyCountries: ["bd"],
      utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.min.js',
   });

   var reset = function () {
      consultInput.classList.remove("uk-form-danger");
      consultInput.classList.remove("uk-form-success");
      // errorMsg.innerHTML = "";
      // errorMsg.classList.add("hide");
      // validMsg.classList.add("hide");
   };

   // on blur: validate
   consultInput.addEventListener("blur", function () {
      reset();
      if (consultInput.value.trim()) {
         if (iti.isValidNumber()) {
            consultInput.classList.add("uk-form-success");
            // validMsg.classList.remove("hide");
            var number = iti.getNumber();
            $(replacer).val(number);
         } else {
            consultInput.classList.add("uk-form-danger");
            var errorCode = iti.getValidationError();
            // errorMsg.innerHTML = errorMap[errorCode];
            // errorMsg.classList.remove("hide");
            $(replacer).val("");
         }
      }
   });
   // on keyup / change flag: reset
   consultInput.addEventListener("change blur", reset);
   consultInput.addEventListener("keyup blur", reset);

   $(validation).css("padding-left", "100px");
   $(validation).closest(".iti").css("width", "100%");
}



function replace_phone_prefix(phone) {
  let ItemOne = phone.replace(/^(?:\+?88|0088)/, "");
  return ItemOne.replace(/\s+/g, '');
}

$(document).on('keyup', '.address_phone', function () {
  let phone = $(this).val();
  phone = replace_phone_prefix(phone);
  $(this).val(phone);
  const method = "^(?:\\+?88|0088)?01[15-9]\\d{8}$";
  var regExpression = new RegExp(method);
  if (regExpression.test(phone)) {
      $(this).removeClass('is-invalid').addClass('is-valid');
      $(this).closest('form').find('[type="submit"]').removeAttr('disabled');
  } else {
      $(this).removeClass('is-valid').addClass('is-invalid');
      $(this).closest('form').find('[type="submit"]').attr('disabled', 'true');
  }
});




// delivery_districts

$(function () {

   var phone_validation = $(document).find(".phone_validation");
   if (phone_validation.length) {
      validatePhone('.phone_validation', "#l_phone"); // phone
   }



});


/**
 * load address list on the address modal
 */
function table_load_address() {
   var tbody = $('#customer_addresses');
   $.post(base_url + "Ajaxpublic/getCustomerAddress", {
      c_id: true
   }, function (data) {
      tbody.html(data);
   });
}

// UIkit.util.on(document, 'show', '#addMoreAddress', function (e) {
//    e.preventDefault();
//    table_load_address();
// });

$(document).on('click', '.shipHereBadge', function () {
   const currency = $(".hidden_currency").val();
   var addressItem = $(this).closest('.addressItem');
   var default_id = addressItem.find('.address_id').val();

   $('.addressItem').find('.uk-card').css({
      cursor: 'pointer',
      border: 'none'
   });
   addressItem.find('.uk-card').css({
      cursor: 'pointer',
      border: '1px solid #fdb813'
   });

   $.post(base_url + "Ajaxpublic/setCustomerDefaultAddress", {
      default_id: default_id
   }, function (data) {
      if (data.address) {
         var address = data.address;
         var addressData = `<p class="uk-margin-remove">
                    <b>Name: </b> <span class="name">${address.name}</span>
                  </p>
                  <p class="uk-margin-remove">
                    <b>Phone: </b><span class="phone_one">${address.phone_one} <br> ${address.phone_two} </span>
                  </p>
                  <p class="uk-margin-remove">
                    <b>Area: </b> <span class="area">${address.area}</span>
                  </p>
                  <p class="uk-margin-remove">
                    <b>Address: </b> <span class="address">${address.address}</span>
                  </p>`;
         $('#defaultAddress').html(addressData);

         $('.addressItem').find('.uk-card').find('.shipHereBadge').remove();
         $('.addressItem').find('.uk-card').append('<span class="uk-badge uk-position-absolute shipHereBadge" style="right: 16px;bottom: 23px;background: #fcb812;padding: 12px;">Ship Here</span>');

         if (address.delivery_charge) {
            var delivery_charge = Number(address.delivery_charge);
            checkout_summary_re_calculation(delivery_charge);
         }
      }
      // UIkit.modal('#addMoreAddress').hide();
   });

});


export const checkout_summary_re_calculation = (d_charge) => {
   const currency = $(".hidden_currency").val();
   let subTotal = Cart.total();
   let btn2Box = $(".btn2Box");
   let discount = Number(btn2Box.find('.coupon_amount').val());
   let total_summary = Number(subTotal) + d_charge - Number(discount);
   let checkout_Summary = $('#checkout_Summary');

   $('#order_del_charge').val(d_charge);

   checkout_Summary.find('.checkout_del_charge').html(currency + `<span class="d_charge_amount">${decimalPoint(d_charge)}</span>`);
   checkout_Summary.find('.checkout_total').html(currency + ' ' + decimalPoint(total_summary));
   $('.final_total').html(decimalPoint(total_summary));
}

function add_new_address_action() {
   var customer_address = $('#addAddressForm').find('.uk-modal-body');
   $.post(base_url + "Ajaxpublic/add_delivery_address", {
      c_id: true
   }, function (data) {
      customer_address.html(data);
   });
}

$(document).on('click', '#addMoreAddressButton', function () {
   add_new_address_action();
});

// UIkit.util.on(document, 'hidden', '#addAddressForm', function () {
//    UIkit.modal('#addMoreAddress').show();
// });


// UIkit.util.on(document, 'shown', '#addAddressForm', function () {
//    validatePhone('#Address_phone1', "#p_c_phone"); // phone
//    validatePhone('#Address_phone2', "#p_c_phone2"); // phone
// });


$(document).on('click', '.saveShippingAddress', function () {
   var thisShipping = $(this).closest('#addAddressForm');
   var formData = {
      p_c_name: thisShipping.find('#p_c_name').val(),
      p_c_phone: thisShipping.find('#p_c_phone').val(),
      p_c_phone2: thisShipping.find('#p_c_phone2').val(),
      p_area: thisShipping.find('#p_area').val(),
      p_address: thisShipping.find('#p_address').val(),
      address_id: thisShipping.find('#address_id').val(),
      shipping_customer_id: thisShipping.find('#shipping_customer_id').val()
   }
   $.post(base_url + "Ajaxpublic/SaveShippingAddress", formData, function (data) {
      if (data.status === true) {
         setTimeout(function () {
            // UIkit.modal('#addAddressForm').hide();
         }, 300)
         swal_alert_happy(data.msg, data.msg);
      } else {
         swal_alert_sad(data.msg, data.msg);
      }
   });
});


$(document).on('click', '.editAddressForm', function () {
   var id = $(this).attr('data-id');
   var customer_address = $('#addAddressForm').find('.uk-modal-body');
   $.post(base_url + "Ajaxpublic/editShippingAddress", {
      id: id
   }, function (data) {
      customer_address.html(data);
   });
});


$(document).on('click', '.deleteAddressForm', function () {
   var id = $(this).attr('data-id');
   swal({
         imageUrl: base_url + "assets/images/happy.png",
         imageHeight: 1500,
         title: "Are you sure?",
         text: "Your Address will be deleted!",
         showCancelButton: true,
         confirmButtonClass: "uk-button-danger",
         confirmButtonText: "Yes, delete it!",
         closeOnConfirm: true,
         reverseButtons: true
      },
      function () {
         $.post(base_url + "Ajaxpublic/deleteShippingAddress", {
            id: id
         }, function (data) {
            table_load_address();
         });
      });

});


//save change profile data
$(document).on("click", ".save_change_profile_data", function (e) {
   // e.preventDefault();

   $(".save_change_profile_data").css({
      backgroundColor: "rgb(181, 227, 162)",
      cursor: "no-drop",
      disabled: true,
   });

   var formData = new FormData($("#form_change_profile")[0]);
   $.ajax({
      url: base_url + "Ajaxpublic/changeProfile",
      method: "POST",
      async: false,
      data: formData,
      enctype: "multipart/form-data",
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (data) {
         if (data.c_status == true) {
            swal_alert_happy('', data.msg);
            setTimeout(function () {
               window.location.assign('/');
            }, 1000);
         }
      },
   });
});