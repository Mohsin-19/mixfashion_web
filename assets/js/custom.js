//use for every report view
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
}

if(mm<10) {
    mm = '0'+mm
}
today = yyyy + '-' + mm + '-' + dd;

//initial select2
$('.select2').select2();
$(".select_multiple").select2({
    multiple: true,
    placeholder: 'Select',
    allowClear: true
});
$('.select_multiple').val('placeholder').trigger("change");

$('.customDatepickerCustom').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    endDate: '+0d',
});
$('.customDatepickerCustom1').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    startDate: '+1d'
});
//Date picker
$('#date').datepicker({
    format: 'dd-mm-yyyy',
    /*format: 'yyyy-mm-dd',*/
    autoclose: true
});
$('#dates2').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
});
$('.customDatepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
});
$('.customDatepicker_time').datetimepicker({
    format: 'hh:mm A'
});
$('.customDatepicker1').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
});
$(".datepicker_months").datepicker({
    format: 'yyyy-M',
    autoclose: true,
    viewMode: "months",
    minViewMode: "months"
});

feather.replace();

// $('[data-toggle="tooltip"]').tooltip();

//iCheck for checkbox and radio inputs
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass   : 'iradio_minimal-blue'
})


