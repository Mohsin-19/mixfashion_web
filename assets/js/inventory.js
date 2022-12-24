$(function () {
   "use strict";

   $('#product_id').on('change', function () {
      var product_id = this.value;
      var category_id = $('select.category_id').find(':selected').val();
      if (product_id || category_id) {
         $('#food_id').prop('disabled', true);
      } else {
         $('#food_id').prop('disabled', false);
      }
   });
   $('#category_id').on('change', function () {
      var category_id = this.value;
      if (category_id) {
         $('#food_id').prop('disabled', true);
      } else {
         $('#food_id').prop('disabled', false);
      }

      var options = '';
      $.ajax({
         type: 'get',
         url: base_url + 'Ajax/getIngredientInfoAjax',
         data: {category_id: category_id, get_csrf_token_name: get_csrf_hash},
         datatype: 'json',
         success: function (data) {
            var json = $.parseJSON(data);
            options += '<option  value="">' + product + '</option>';
            $.each(json, function (i, v) {
               options += '<option  value="' + v.id + '">' + v.name + '(' + v.code + ')</option>';
            });
            $('#product_id').html(options);
         }
      });
   });
});

$(document).ready(function () {
   var category_id = $('select.category_id').find(':selected').val();
   var product_id = $('select.product_id').find(':selected').val();
   var food_id = $('select.food_id').find(':selected').val();
   if (food_id) {
      $('#category_id').prop('disabled', false);
      $('#product_id').prop('disabled', false);

   } else if (product_id || category_id) {
      $('#category_id').prop('disabled', false);
      $('#product_id').prop('disabled', false);
   } else {
      if (food_id) {
         $('#category_id').prop('disabled', true);
         $('#product_id').prop('disabled', true);
      }
   }

   if (category_id) {
      var options = '';
      var selectedID = $("#hiddentIngredientID").val();
      $.ajax({
         type: 'get',
         url: base_url + 'Ajax/getIngredientInfoAjax',
         data: {category_id: category_id, get_csrf_token_name: get_csrf_hash},
         datatype: 'json',
         success: function (data) {
            var json = $.parseJSON(data);
            options += '<option  value="">' + product + '</option>';
            $.each(json, function (i, v) {
               options += '<option  value="' + v.id + '">' + v.name + '(' + v.code + ')</option>';
            });
            $('#product_id').html(options);
            $('#product_id').val(selectedID).change();
         }
      });
   }
   $('#stockValue').html(stock_value + ': ' + currency + ' ' + $('#grandTotal').val() + '<a class="top" title="' + inventory_tooltip + '" data-placement="top" data-toggle="tooltip" style="cursor:pointer" data-original-title="' + inventory_tooltip + '"><i class="fa fa-question fa-lg form_question"></i></a>');
});
