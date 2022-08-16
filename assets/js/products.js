$(function () {
   "use strict";

   $(document).on('click', '.addGalleryBtn', function(event){
      event.preventDefault();
      var item_id = $(this).attr('href');
      $('#product_id').val(item_id);
      $('#galaryImageModal').modal('show');
   });


   var category_id = $("#category_id").val();
   var supplier_id = $("#supplier_id").val();
   var subcategory_id = $("#subcategory_id").val();
   //get data using ajax datatable
   var datatable = $('#datatable').DataTable({
      'processing': true,
      'serverSide': true,
      'ordering': false,
      'order': [],
      'ajax': {
         url: base_url + "Item/getAjaxData",
         type: "POST",
         dataType: 'json',
         data: {
            category_id: category_id, supplier_id: supplier_id, subcategory_id: subcategory_id,
            get_csrf_token_name: get_csrf_hash
         },
      },
      "columnDefs": [{
         "target": [0, 3, 4],
         "orderable": false,
      }]
   });
});