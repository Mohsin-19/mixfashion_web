onkeydown = function (e) {
  //prevent enter key
  if (e.which == 13) {
    e.preventDefault();
  }
}
var base_url = $(".base_url_ajax").val();

$(function () {
  "use strict";

  $(document).on('click', '.add_category_by_ajax', function (e) {
    $("#addCategoryModal").modal('show');
  });
  $(document).on('click', '.add_supplier_by_ajax', function (e) {
    $("#addSupplierModal").modal('show');
  });

  $(document).on('click', '.add_purchase_unit_by_ajax', function (e) {
    $("#addPurchaseUnitModal").modal('show');
  });
  $(document).on('click', '.add_image_for_crop', function (e) {
    $("#AddItemImageModal").modal('show');
  });
  $(document).on('click', '.add_sale_unit_by_ajax', function (e) {
    $("#addSaleUnitModal").modal('show');
  });
  $(document).on('click', '.show_guide', function (e) {
    var guide = $(this).attr('data-guide');
    $(".show_guide_text").html(guide);
    $("#guideModal").modal('show');
  });
  $(document).on('change', '.check_type', function (e) {
    var value = $(this).val();
    if (value == 2) {
      $(".disable_service").prop("disabled", true);
    } else {
      $(".disable_service").prop("disabled", false);
    }

  });
  $(document).on('click', '#addCategory', function (e) {
    var name_cat = $("#name_cat").val();
    var error = 0;
    if (name_cat == '') {
      error = 1;
      var cl1 = ".name_err_msg";
      var cl2 = ".name_err_msg_contnr";
      $(cl1).text("The Name field is required!");
      $(cl2).show(200).delay(6000).hide(200, function () {});
    } else {
      $("#name_cat").css('border', '1px solid #ccc');
    }
    if (error == 0) {
      var data = $("form#add_category_form").serialize();
      $.ajax({
        type: 'get',
        url: base_url + 'Ajax/addCategoryByAjax',
        datatype: 'json',
        data: data,
        success: function (data) {
          if (data) {
            var json = $.parseJSON(data);
            var html = '<option>' + select_ + '</option>';
            $.each(json.categories, function (i, v) {
              html += '<option value="' + v.id + '">' + v.name + '</option>';
            });
            $("#category_id").html(html);
            $("#category_id").val(json.id).change();
            $("#addCategoryModal").modal('hide');
          }
        }
      });
    }
  });

  // -- add suppliers start
  $(document).on('click', '#addSupplier', function (e) {
    var name_supplier = $("#name_supplier").val();
    var error = 0;
    if (name_supplier == '') {
      error = 1;
      var cl1 = ".name_err_msg";
      var cl2 = ".name_err_msg_contnr";
      $(cl1).text("The Name field is required!");
      $(cl2).show(200).delay(6000).hide(200, function () {});
    } else {
      $("#name_supplier").css('border', '1px solid #ccc');
    }
    if (error == 0) {
      var data = $("form#add_supplier_form").serialize();
      $.ajax({
        type: 'get',
        url: base_url + 'Ajax/addSupplierByAjax',
        datatype: 'json',
        data: data,
        success: function (data) {
          if (data) {
            var json = $.parseJSON(data);
            var html = '<option>' + select_ + '</option>';
            $.each(json.supplier, function (i, v) {
              html += '<option value="' + v.id + '">' + v.name + '</option>';
            });
            $("#supplier_id").html(html);
            $("#supplier_id").val(json.id).change();
            $("#addSupplierModal").modal('hide');
          }
        }
      });
    }
  });
  // -- add suppliers ends
  $(document).on('submit', '#product_form', function (e) {
    var error = false;
    $(".required_check").each(function () {
      var value = $(this).val();
      if (value == '') {
        $(this).css({
          "border-color": "red"
        }).show(200).delay(2000, function () {
          $(this).css({
            "border-color": "#d2d6de"
          });
        });
        error = true;
      }
    });

    if (error == true) {
      return false;
    }
  });
  $(document).on('click', '#addPurchaseUnit', function (e) {
    var unit_name = $("#unit_name_p").val();
    var error = 0;
    if (unit_name == '') {
      error = 1;
      var cl1 = ".unit_name_err_msg";
      var cl2 = ".unit_name_err_msg_contnr";
      $(cl1).text("The Unit Name field is required!");
      $(cl2).show(200).delay(6000).hide(200, function () {});
    } else {
      $("#unit_name").css('border', '1px solid #ccc');
    }
    if (error == 0) {
      var data = $("form#add_purchase_unit_form").serialize();
      $.ajax({
        type: 'get',
        url: base_url + 'Ajax/addUnitByAjax',
        datatype: 'json',
        data: data,
        success: function (data) {
          if (data) {
            var json = $.parseJSON(data);
            var html = '<option>' + select_ + '</option>';
            $.each(json.units, function (i, v) {
              html += '<option value="' + v.id + '">' + v.unit_name + '</option>';
            });
            $("#purchase_unit_id").html(html);
            var sale_unit_id = $("#sale_unit_id").val();
            $("#purchase_unit_id").val(json.id).change();
            $("#sale_unit_id").html(html);
            $("#sale_unit_id").val(sale_unit_id).change();
            $("#addPurchaseUnitModal").modal('hide');
          }
        }
      });
    }

  });

  $(document).on('click', '#addSaleUnit', function (e) {
    var unit_name = $("#unit_name_sale").val();
    var error = 0;
    if (unit_name == '') {
      error = 1;
      var cl1 = ".unit_name_err_msg";
      var cl2 = ".unit_name_err_msg_contnr";
      $(cl1).text("The Unit Name field is required!");
      $(cl2).show(200).delay(6000).hide(200, function () {});
    } else {
      $("#unit_name").css('border', '1px solid #ccc');
    }
    if (error == 0) {
      var data = $("form#add_sale_unit_form").serialize();
      $.ajax({
        type: 'get',
        url: base_url + 'Ajax/addUnitByAjax',
        datatype: 'json',
        data: data,
        success: function (data) {
          if (data) {
            var json = $.parseJSON(data);
            var html = '<option>' + select_ + '</option>';
            $.each(json.units, function (i, v) {
              html += '<option value="' + v.id + '">' + v.unit_name + '</option>';
            });
            var purchase_unit_id = $("#purchase_unit_id").val();
            $("#purchase_unit_id").html(html);
            $("#sale_unit_id").html(html);
            $("#sale_unit_id").val(json.id).change();
            $("#purchase_unit_id").val(purchase_unit_id).change();
            $("#addSaleUnitModal").modal('hide');
          }
        }
      });
    }

  });

  $('#addCategoryModal').on('hidden.bs.modal', function () {
    $("#name_cat").val('');
    $("#description_cat").val('');
  });

  $('#addPurchaseUnitModal').on('hidden.bs.modal', function () {
    $("#unit_name_p").val('');
    $("#description_p").val('');
  });
  $('#addSaleUnitModal').on('hidden.bs.modal', function () {
    $("#unit_name_sale").val('');
    $("#description_s").val('');
  });

});

function getSubcat() {
  var category_id = $("#category_id").val();
  var sub_id = $("#category_id").find(':selected').attr('data-subcategory_id');
  if (!sub_id) {
    sub_id = '';
  }
  var product_id = '';
  $.ajax({
    type: 'get',
    url: base_url + 'Ajax/getSubcategory',
    dataType: 'json',
    data: {
      category_id: category_id,
      product_id: product_id
    },
    success: function (data) {
      if (data.status == true) {
        $("#subcategory_id").html(data.html_o);
      } else {
        $("#subcategory_id").html('<option>' + select_ + '</option>');
      }
      if (sub_id) {
        $("#subcategory_id").val(sub_id).change();
      }
    }
  });
}
getSubcat();

$(document).on('change', '#category_id', function (e) {
  getSubcat();
});
$uploadCrop = $('#upload-demo').croppie({
  enableExif: true,
  viewport: {
    width: 700,
    height: 964,
    type: 'square'
  },
  boundary: {
    width: 700,
    height: 964
  }
});
$('#upload').on('change', function () {
  var reader = new FileReader();
  reader.onload = function (e) {
    $uploadCrop.croppie('bind', {
      url: e.target.result
    }).then(function () {
      console.log('jQuery bind complete');
    });

  }
  reader.readAsDataURL(this.files[0]);
});
$('#has_offer').on('change', function () {
  var this_value = $(this).val();
  if (this_value == "Yes") {
    $(".offer_div").show(333);
  } else {
    $(".offer_div").hide(333);
  }
});
$('.upload-result').on('click', function (ev) {
  $uploadCrop.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (resp) {
    var selected_image = $("#upload").val();
    if (selected_image == '') {
      swal({
        title: hidden_alert + "!",
        text: img_select_error_msg,
        confirmButtonText: hidden_ok,
        confirmButtonColor: '#3c8dbc'
      });
      return false;
    } else {
      $.ajax({
        url: base_url + "Ajax/saveItemImage",
        type: "POST",
        dataType: 'json',
        data: {
          "image": resp
        },
        success: function (data) {
          $("#AddItemImageModal").modal('hide');
          $(".cr-image").remove();
          $("#image_url").val(data.image_name);
          $("#upload").val('');
          html = '<img style="width:50%;" src="' + resp + '" />';
          $("#upload-demo-i").html(html);
        }
      });
    }

  });
});





$(function () {

  var dom = $(document);
  dom.on('click', '.remveItemAttr', function () {
    var trLength = $(this).closest('tbody').find('tr');
    if (trLength.length > 1) {
      $(this).closest('tr').remove();
    } else {
      var attrTbody = dom.find('#attributeTableTbody');
      attrTbody.find('select').val('');
      attrTbody.find('select').val('');
      attrTbody.find('input').val('');
    }

  }).on('click', '.addItemAttr', function () {
    var attrTbody = dom.find('#attributeTableTbody');
    var html = `<tr>${$("#firstAttributeRow").html()}</tr>`;
    attrTbody.append(html);
    attrTbody.find('tr').each(function (i, obj) {
      $(this).find('.color').attr('name', "attribute[" + i + "][color]");
      $(this).find('.size').attr('name', "attribute[" + i + "][size]");
      $(this).find('.price').attr('name', "attribute[" + i + "][price]");
      $(this).find('.qty').attr('name', "attribute[" + i + "][qty]");
    });
  });

});