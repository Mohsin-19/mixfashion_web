$('#supplierModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
});

    var product_id_container = [];
    $(function () {
        "use strict";
        //Initialize Select2 Elements
        $('.select2').select2();

        var suffix =$(".rowCount").length;
        var tab_index = 4;

        $('#product_id').on('change', function (){
            var product_details=$('#product_id').val();
            if (product_details != '') {

                var product_details_array = product_details.split('|');
                var index = product_id_container.indexOf(product_details_array[0]);
                //$("#unit_price_modal").val(product_details_array[3]);
                $("#unit_price_modal").val(product_details_array[3]);
                $("#cartPreviewModal").modal('show');


            }
        });
        $('#addToCart').on('click', function (e){
            e.preventDefault();
            var unit_price = $("#unit_price_modal").val();
            var qty_modal = $("#qty_modal").val();
            appendCart(unit_price,qty_modal);
        });

        function appendCart(unit_price,qty_modal) {
            var product_details=$('#product_id').val();
            var product_details_array = product_details.split('|');

            suffix++;
            tab_index++;
            var cart_row = '<tr class="rowCount" data-id="' + suffix + '" id="row_' + suffix + '">'+
                '<td style="padding-left: 10px;"><p id="sl_' + suffix + '">'+suffix+'</p></td>'+
                '<td><span style="padding-bottom: 5px;">'+product_details_array[1]+'</span></td>'+
                '<input type="hidden" id="product_id_' + suffix + '" name="product_id[]" value="' + product_details_array[0] + '"/>'+
                '<input type="hidden" id="conversion_rate_id_' + suffix + '" name="conversion_rate[]" value="' + product_details_array[4] + '"/>'+
                '<td><input type="text" autocomplete="off" tabindex="'+ tab_index +'" id="unit_price_' + suffix + '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="Unit Price" value="'+ unit_price +'" onkeyup="return calculateAll();"/><span class="label_aligning">'+currency+'</span></td>'+
                '<td><input type="text" autocomplete="off" data-countID="'+suffix+'" tabindex="'+ tab_index+1 +'" id="quantity_amount_' + suffix + '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID"  value="'+ qty_modal +'"  placeholder="Qty/Amount" onkeyup="return calculateAll();" ><span class="label_aligning">' + product_details_array[2] + '</span></td>'+
                '<td><input type="text" autocomplete="off" id="total_' + suffix + '" name="total[]" class="form-control aligning" placeholder="Total" readonly /><span class="label_aligning">'+currency+'</span></td>'+
                '<td><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' + suffix + ',' + product_details_array[0] +');" ><i style="color:white" class="fa fa-trash"></i> </a></td>'+
                '</tr>';
            tab_index++;

            $('#purchase_cart tbody').prepend(cart_row);

            product_id_container.push(product_details_array[0]);
            $('#product_id').val('').change();
            calculateAll();
            $("#cartPreviewModal").modal('hide');
        }

        // Validate form
        $('#purchase_form').on('submit', function (){

            var supplier_id = $("#supplier_id").val();
            var payment_method_id = $("#payment_method_id").val();

            var date = $("#date").val();
            //var note = $("#note").val();
            var paid = $("#paid").val();
            var productCount = $("#purchase_cart tbody tr").length;
            var error = false;


            if(supplier_id==""){
                $("#supplier_id_err_msg").text(supplier_field_required);
                $(".supplier_id_err_msg_contnr").show(200);
                error = true;
            }

            if(payment_method_id==""){
                $("#payment_method_id_err_msg").text(account_field_required);
                $(".payment_method_id_err_msg_contnr").show(200);
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


            if(paid=="" || !(Number(paid))){
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


        $("#subtotal").val(subtotal);

        var other =  parseFloat($.trim($("#other").val()));

        if($.trim(other)==""|| $.isNumeric(other)==false){
            other=0;
        }

        var grand_total = parseFloat(subtotal)  + parseFloat(other);

        grand_total = grand_total.toFixed(2);

        $("#grand_total").val(grand_total);

        var paid = $("#paid").val();

        if($.trim(paid)==""|| $.isNumeric(paid)==false){
            paid=0;
        }

        if(Number(paid)==0){
            $("#payment_method_id").prop("disabled", true);
        }else{
            $("#payment_method_id").prop("disabled", false);
        }

        var due = parseFloat(grand_total) - parseFloat(paid);

        $("#due").val(due.toFixed(2));
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

jQuery(document).ready(function($) {
    "use strict";
    $(document).on('keydown', '.integerchk1', function(e){
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

    $(document).on('keyup', '.integerchk1', function(e){

        var input = $(this).val();
        var ponto = input.split('.').length;
        var slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });

});