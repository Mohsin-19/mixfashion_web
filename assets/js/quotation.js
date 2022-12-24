
var product_id_container = [];
$(function () {
    "use strict";
    $(document).on('keydown', '.discount', function(e){
        /*$('.integerchk').keydown(function(e) {*/
        var keys = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
        return (
            keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105));
    });
    $(document).on('keyup', '.discount', function(e){
        var input = $(this).val();
        var ponto = input.split('.').length;
        var slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9.%]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });

    //Initialize Select2 Elements
    $('.select2').select2();

    var suffix =$(".rowCount").length;

    var tab_index = 4;

    $(document).on('change', '#product_id', function(e){
        var product_details=$('#product_id').val();
        if (product_details != '') {
            var product_details_array = product_details.split('|');
            var index = product_id_container.indexOf(product_details_array[0]);

            if (index > -1) {
                swal({
                    title: hidden_alert+"!",
                    text: product_already_remain,
                    confirmButtonText:hidden_ok,
                    confirmButtonColor: '#3c8dbc'
                });
                $('#product_id').val('').change();
                return false;
            }
            suffix++;
            tab_index++;

            var cart_row = '<tr class="rowCount" data-id="' + suffix + '" id="row_' + suffix + '">'+
                '<td class="txt-uh-66"><p id="sl_' + suffix + '">'+suffix+'</p></td>'+
                '<td><span class="txt-uh-62">'+product_details_array[1]+'</span></td>'+
                '<input type="hidden" id="product_id_' + suffix + '" name="product_id[]" value="' + product_details_array[0] + '"/>'+
                '<td><input type="text" autocomplete="off" tabindex="'+ tab_index +'" id="unit_price_' + suffix + '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="Unit Price" value="'+ product_details_array[3] +'" onkeyup="return calculateAll();"/><span class="label_aligning">'+currency+'</span></td>'+
                '<td><input type="text" autocomplete="off" data-countID="'+suffix+'" tabindex="'+ tab_index+1 +'" id="quantity_amount_' + suffix + '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID"  placeholder="Qty/Amount" onkeyup="return calculateAll();" ><span class="label_aligning">' + product_details_array[2] + '</span></td>'+
                '<td><input type="text" autocomplete="off" id="total_' + suffix + '" name="total[]" class="form-control aligning" placeholder="Total" readonly /><span class="label_aligning">'+currency+'</span></td>'+
                '<td><input type="text" autocomplete="off" id="" name="description[]" class="form-control" placeholder="'+description+'" /></td>'+
            '<td><a class="btn btn-danger btn-xs txt-uh-63" onclick="return deleter(' + suffix + ',' + product_details_array[0] +');" ><i style="color:white" class="fa fa-trash"></i> </a></td>'+
            '</tr>';
            tab_index++;

            $('#quotation_cart tbody').append(cart_row);

            product_id_container.push(product_details_array[0]);
            $('#product_id').val('').change();
            calculateAll();
        }
    });


    // Validate form
    $(document).on('submit', '#quotation_form', function(e){
        var customer_id = $("#customer_id").val();
        var date = $("#date").val();
        //var note = $("#note").val();
        var paid = $("#paid").val();
        var productCount = $("#quotation_cart tbody tr").length;
        var error = false;

        if(customer_id==""){
            $("#customer_id_err_msg").text(customer_field_required);
            $(".customer_id_err_msg_contnr").show(200);

            error = true;
        }

        if(date==""){
            $("#date_err_msg").text(date_field_required);
            $(".date_err_msg_contnr").show(200);

            error = true;
        }

        if(productCount < 1){
            $("#product_id_err_msg").text(at_least_product);
            $(".product_id_err_msg_contnr").show(200);

            error = true;
        }
        if(paid==""){
            $("#paid_err_msg").text(paid_field_required);
            $(".paid_err_msg_contnr").show(200);
            error = true;
        }

        $(".countID").each(function () {
            var n = $(this).attr("data-countID");
            var quantity_amount = $.trim($("#quantity_amount_"+n).val());
            if(quantity_amount == '' || isNaN(quantity_amount)){
                $("#quantity_amount_"+n).css({"border-color":"red"}).show(200).delay(2000,function(){
                    $("#quantity_amount_"+n).css({"border-color":"#d2d6de"});
                });
                error = true;
            }
        });

        if(error == true){
            return false;
        }
    });



})
function cal_disc(disc,sub_total) {
    var totalDiscount = 0;
    if ($.trim(disc) == '' || $.trim(disc) == '%' || $.trim(disc) == '%%' || $.trim(disc) == '%%%'  || $.trim(disc) == '%%%%'){
        totalDiscount = 0;
    }else{
        var Disc_fields = disc.split('%');
        var discAmount = Disc_fields[0];
        var discP = Disc_fields[1];
        if (discP == "") {
            totalDiscount = (sub_total * (parseFloat($.trim(discAmount)) / 100));
        } else {
            if (!disc) {
                discAmount = 0;
            }
            totalDiscount = parseFloat(discAmount);
        }
        return totalDiscount;
    }
}
function calculateAll(){
    var subtotal = 0;
    var i = 1;
    $(".rowCount").each(function () {
        var id = $(this).attr("data-id");
        var unit_price=$("#unit_price_"+id).val();
        var temp = "#sl_"+id;
        $(temp).html(i);
        i++;
        var quantity_amount = $("#quantity_amount_"+id).val();
        if($.trim(unit_price) == "" || $.isNumeric(unit_price) == false){
            unit_price=0;
        }
        if($.trim(quantity_amount) == "" || $.isNumeric(quantity_amount) == false){
            quantity_amount=0;
        }

        var quantity_amount_and_unit_price=parseFloat($.trim(unit_price))*parseFloat($.trim(quantity_amount));

        $("#total_"+id).val(quantity_amount_and_unit_price.toFixed(2));
        subtotal += parseFloat($.trim($("#total_" + id).val()));
    });


    if (isNaN(subtotal)) {
        subtotal = 0;
    }


    $("#subtotal").val(subtotal.toFixed(2));

    var other =  parseFloat($.trim($("#other").val()));

    var disc =$("#discount").val();

    var total_discount = cal_disc(disc,subtotal);
    if($.trim(other)==""|| $.isNumeric(other)==false){
        other=0;
    }
    if($.trim(disc)==""){
        total_discount=0;
    }

    var grand_total = parseFloat(subtotal)  + parseFloat(other) - total_discount;

    grand_total = grand_total.toFixed(2);

    $("#grand_total").val(grand_total);

}
function deleter(suffix, product_id){

    swal({
        title: hidden_alert+"!",
        text: are_you_sure+"?",
        cancelButtonText:hidden_cancel,
        confirmButtonText:hidden_ok,
        confirmButtonColor: '#3c8dbc',
        showCancelButton: true
    }, function() {
        $("#row_"+suffix).remove();
        $("#paid").val('');
        var product_id_container_new = [];
        for(var i = 0; i < product_id_container.length; i++){
            if(product_id_container[i] != product_id){
                product_id_container_new.push(product_id_container[i]);
            }
        }
        product_id_container = product_id_container_new;
        calculateAll();
    });
}
$('#supplierModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
});