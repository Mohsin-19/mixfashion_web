"use strict";
var product_id_container = [];
$(function () {
  "use strict";
  //Initialize Select2 Elements
  $(".select2").select2();

  var suffix = $(".rowCount").length;

  $("#food_menu_id").on("change", function () {
    var f_menu_id = $("#food_menu_id").val();
    $("#food_menu_damage_quantity").val("");
    if (f_menu_id != "") {
      $("#damage_quantity").val("");
      $("#damage_cart tbody tr").remove();
      $("#product_id").prop("disabled", true);
      $("#food_menu_damage").modal("show");
    } else {
      $("#damage_quantity").val("");
      $("#damage_cart tbody tr").remove();
      $("#product_id").prop("disabled", false);
    }
    $("#food_menu_damage_quantity_row").css("display", "block");
    //     alert(f_menu_id);
  });
  $("#delete_all_product_list").on("click", function () {
    $("#damage_cart").find("tbody").empty();
    $("#total_loss").val("");
    $("#food_menu_damage_quantity_row").hide();
  });
  $("#food_menu_damage").on("hidden.bs.modal", function () {
    //  alert('test');
    // $('#food_menu_id').val('');
    //   $('#food_menu_id').prop('selected', false);
    // $('select#food_menu_id option').removeAttr("selected");
  });
  $("#food_menu_damage_button").on("click", function () {
    var id = $("#food_menu_id").val();
    var f_menu_id = $("#food_menu_id").val();
    var quantity = $("#food_menu_damage_quantity").val();
    if (quantity == "") {
      $("#food_menu_damage_quantity_err_msg").text(
        "The Quantity field is required."
      );
      $(".food_menu_damage_quantity_err_msg_contnr").show(200);
      error = true;
      return error;
    }

    var url = base_url;
    var currency = currency;

    if (id != "") {
      $("#damage_quantity").val(quantity);
      $("#food_menu_damage").modal("hide");
      var options = "";
      $.ajax({
        type: "get",
        url: base_url + "Damage/food_menus_products",
        data: { id: f_menu_id, get_csrf_token_name: get_csrf_hash },
        dataType: "json",
        success: function (data) {
          //    alert('test');
          //    var json = $.parseJSON(data);
          //   alert(json);
          $("#food_menu_damage_quantity").val("");
          var j = 0;
          var total_loss = 0;

          $.each(data, function (i, v) {
            var qty = 0;
            var los_amount = 0;
            qty = quantity * v.consumption;
            los_amount = quantity * v.consumption * v.unit_price;
            total_loss = total_loss + los_amount;
            j++;
            i++;
            options +=
              '<tr class="rowCount" data-id="' +
              i +
              '" id="row_' +
              i +
              '">' +
              '<td style="padding-left: 10px;"><p id="sl_' +
              i +
              '">' +
              j +
              "</p></td>" +
              '<input type="hidden" id="product_id_' +
              i +
              '" name="product_id[]" value="' +
              v.product_id +
              '"/>' +
              '<td><span style="padding-bottom: 5px;">' +
              v.name +
              "(" +
              v.code +
              ")" +
              "</span></td>" +
              '<td style="width: 15%"><input readonly  type="text" data-countID="' +
              i +
              '" id="damage_amount_' +
              i +
              '" name="damage_amount[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="Damage Qty/Amt" value=" ' +
              qty +
              ' " /><span class="label_aligning"> ' +
              v.unit_name +
              '</span><span id="unit_consumption_product_' +
              i +
              '" class="unit_consumption_product" style="display:none">' +
              v.consumption +
              "</span></td>" +
              '<input type="hidden" id="last_purchase_price_' +
              i +
              '" name="last_purchase_price[]" value="' +
              i +
              '"/>' +
              '<td><input type="text" autocomplete="off" id="loss_amount_' +
              i +
              '" name="loss_amount[]" onfocus="this.select();" class="form-control aligning" placeholder="Loss Amt" value=" ' +
              los_amount +
              ' " /><span class="label_aligning">' +
              currency +
              '</span><span id="unit_price_product_' +
              i +
              '" class="unit_price_product" style="display:none">' +
              v.unit_price +
              "</span></td>" +
              // '<td><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' + i + ',' + i +');" ><i class="fa fa-trash"></i> </a></td>'+
              "</tr>";
          });
          $("#damage_cart tbody").append(options);
          /* $("#total_loss").val(total_loss);*/
        },
      });
    }
  });
  $("#damage_quantity").on("keyup", function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      $(this).val("");
    }

    var given_amount = $(this).val() != "" ? $(this).val() : 0;

    //check wether value is valid or not
    remove_last_two_digit_without_percentage(given_amount, $(this));

    given_amount = $(this).val() != "" ? $(this).val() : 0;

    total_loss = 0;
    $(".rowCount").each(function (i, obj) {
      var row_id = $(this).attr("id").substr(4);
      var unit_price = $(this).find(".unit_price_product").html();
      var unit_consumption = $(this).find(".unit_consumption_product").html();
      var updated_consumption =
        parseFloat(unit_consumption) * parseFloat(given_amount);
      var updated_price = (
        parseFloat(unit_price) * parseFloat(updated_consumption)
      ).toFixed(2);
      $("#damage_amount_" + row_id).val(updated_consumption);
      $("#loss_amount_" + row_id).val(updated_price);
      total_loss = (parseFloat(total_loss) + parseFloat(updated_price)).toFixed(
        2
      );
      // console.log('updated price: '+updated_price+', updated consumption: '+updated_consumption);
    });
    /* $('#total_loss').val(total_loss);*/
  });
  $("#product_id").on("change", function () {
    $("#food_menu_id").prop("disabled", true);

    var product_details = $("#product_id").val();

    if (product_details != "") {
      var product_details_array = product_details.split("|");

      /*for(var i=1; i <= product_id_container.length; i++){
               if(product_details_array[0] == product_id_container[i]){
                swal('Ingredient already remains in cart, you can change the consumption value')
                return false;
               }
            } */
      var index = product_id_container.indexOf(product_details_array[0]);

      if (index > -1) {
        swal({
          title: hidden_alert + "!",
          text: product_already_remain,
          confirmButtonText: hidden_ok,
          confirmButtonColor: "#3c8dbc",
        });
        $("#product_id").val("").change();
        return false;
      }

      suffix++;

      var cart_row =
        '<tr class="rowCount" data-id="' +
        suffix +
        '" id="row_' +
        suffix +
        '">' +
        '<td style="padding-left: 10px;"><p id="sl_' +
        suffix +
        '">' +
        suffix +
        "</p></td>" +
        '<input type="hidden" id="product_id_' +
        suffix +
        '" name="product_id[]" value="' +
        product_details_array[0] +
        '"/>' +
        '<td><span style="padding-bottom: 5px;">' +
        product_details_array[1] +
        "</span></td>" +
        '<td style="width: 15%"><input type="text" autocomplete="off" data-countID="' +
        suffix +
        '" id="damage_amount_' +
        suffix +
        '" name="damage_amount[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="' +
        damage_amt +
        '" /><span class="label_aligning"> ' +
        product_details_array[2] +
        "</span></td>" +
        '<input type="hidden" id="last_purchase_price_' +
        suffix +
        '" name="last_purchase_price[]" value="' +
        product_details_array[3] +
        '"/>' +
        '<td><input type="text" autocomplete="off" id="loss_amount_' +
        suffix +
        '" name="loss_amount[]" onfocus="this.select();" class="form-control aligning" onkeyup="return calculateAll();" placeholder="' +
        loss_amt +
        '"  /><span class="label_aligning">' +
        currency +
        "</span></td>" +
        '<td><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' +
        suffix +
        "," +
        product_details_array[0] +
        ');" ><i class="fa fa-trash"></i> </a></td>' +
        "</tr>";

      $("#suffix_hidden_field").val(suffix);

      $("#damage_cart tbody").append(cart_row);

      product_id_container.push(product_details_array[0]);

      $("#product_id").val("").change();
      calculateAll();
    }
  });

  // Validate form
  $("#damage_form").on("submit", function () {
    var date = $("#date").val();
    var employee_id = $("#employee_id").val();
    var note = $("#note").val();
    var total_loss = $("#total_loss").val();
    var productCount = $("#damage_cart tbody tr").length;
    var error = false;

    if (employee_id == "") {
      $("#employee_id_err_msg").text(responsible_person_field_required);
      $(".employee_id_err_msg_contnr").show(200);
      error = true;
    }

    if (date == "") {
      $("#date_err_msg").text(date_field_required);
      $(".date_err_msg_contnr").show(200);
      error = true;
    }
    if (total_loss == "") {
      $("#total_loss_err_msg").text(total_loss_field_required);
      $(".total_loss_err_msg_contnr").show(200);
      error = true;
    }

    if (productCount < 1) {
      $("#product_id_err_msg").text(at_least_product);
      $(".product_id_err_msg_contnr").show(200);
      error = true;
    }

    if (note.length > 200) {
      $("#note_err_msg").text(note_field_cannot);
      $(".note_err_msg_contnr").show(200);
      error = true;
    }

    $(".integerchk").each(function () {
      var n = $(this).attr("data-countID");
      var damage_amount = $.trim($("#damage_amount_" + n).val());
      if (damage_amount == "" || isNaN(damage_amount)) {
        $("#damage_amount_" + n)
          .css({ "border-color": "red" })
          .show(200)
          .delay(2000, function () {
            $("#damage_amount_" + n).css({ "border-color": "#d2d6de" });
          });
        error = true;
      }
    });

    if (error == true) {
      return false;
    }
  });
});

function calculateAll() {
  var total_loss = 0;
  var i = 1;
  $(".rowCount").each(function () {
    var id = $(this).attr("data-id");
    var damage_amount = $("#damage_amount_" + id).val();
    var temp = "#sl_" + id;
    $(temp).html(i);
    i++;

    if (typeof damage_amount !== "undefined" && damage_amount !== null) {
      var last_purchase_price = $("#loss_amount_" + id).val();

      if ($.trim(damage_amount) == "" || $.isNumeric(damage_amount) == false) {
        damage_amount = 0;
      }
      if (
        $.trim(last_purchase_price) == "" ||
        $.isNumeric(last_purchase_price) == false
      ) {
        last_purchase_price = 0;
      }

      var loss_amount =
        parseFloat($.trim(damage_amount)) *
        parseFloat($.trim(last_purchase_price));

      total_loss += parseFloat(loss_amount);
    }
  });
  //$("#total_loss").val(total_loss);
}
//delete row
function deleter(suffix, product_id) {
  swal(
    {
      title: hidden_alert + "!",
      text: are_you_sure + "?",
      cancelButtonText: hidden_cancel,
      confirmButtonText: hidden_ok,
      confirmButtonColor: "#3c8dbc",
      showCancelButton: true,
    },
    function () {
      $("#row_" + suffix).remove();
      var product_id_container_new = [];

      for (var i = 0; i < product_id_container.length; i++) {
        if (product_id_container[i] != product_id) {
          product_id_container_new.push(product_id_container[i]);
        }
      }

      product_id_container = product_id_container_new;

      updateRowNo();
      calculateAll();
    }
  );
}
function updateRowNo() {
  var numRows = $("#damage_cart tbody tr").length;
  for (var r = 0; r < numRows; r++) {
    $("#damage_cart tbody tr")
      .eq(r)
      .find("td:first p")
      .text(r + 1);
  }
}
//remove last digits if number is more than 2 digits after decimal
function remove_last_two_digit_without_percentage(value, object_element) {
  if (value.length > 0 && value.indexOf(".") > 0) {
    var percentage = false;
    var number_without_percentage = value;
    if (value.indexOf("%") > 0) {
      percentage = true;
      number_without_percentage = value
        .toString()
        .substring(0, value.length - 1);
    }
    var number = number_without_percentage.split(".");
    if (number[1].length > 2) {
      var value = parseFloat(Math.floor(number_without_percentage * 100) / 100);
      add_percentage = percentage ? "%" : "";
      if (isNaN(value)) {
        object_element.val("");
      } else {
        object_element.val(value.toString() + add_percentage);
      }
    }
  }
}
