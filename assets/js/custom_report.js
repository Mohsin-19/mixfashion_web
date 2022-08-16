//pdf,print,export datatable
var jqry = $.noConflict();
jqry(document).ready(function () {
   "use strict";

   //use for every report view
   var today = new Date();
   var dd = today.getDate();
   var mm = today.getMonth() + 1; //January is 0!
   var yyyy = today.getFullYear();

   if (dd < 10) {
      dd = '0' + dd
   }

   if (mm < 10) {
      mm = '0' + mm
   }
   today = yyyy + '-' + mm + '-' + dd;

   //get title and datatable id name from hidden input filed that is before in the table in view page for every datatable
   var datatable_name = $(".datatable_name").attr('data-id_name');
   var title = $(".datatable_name").attr('data-title');
   var TITLE = title + ", " + today;
   jqry("#" + datatable_name).DataTable({
      'autoWidth': false,
      'ordering': false,
      dom: 'Bfrtip',
      buttons: [
         {
            extend: 'print',
            title: TITLE,
            exportOptions: {
               columns: ':visible:not(.not-export-col)'
            }
         },
         {
            extend: 'excelHtml5',
            title: TITLE
         },
         {
            extend: 'pdfHtml5',
            title: TITLE
         }
      ]
   });
});