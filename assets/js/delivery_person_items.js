//auto counter, dynamically generate filed name,id etc
function counter() {

    var i = 1;
    $(".counter1").each(function(){
        $(this).attr('id',"s_amount_"+i);
        i++;
    });
    var i = 1;
    $(".counter_row").each(function(){
        $(this).html(i+". ");
        i++;
    });
    i = 1;
    $(".counter2").each(function(){
        $(this).attr('id',"e_amount_"+i);
        i++;
    });
    i = 1;
    var j = 0;
    $(".c_item").each(function(){
        $(this).attr('id',"item_"+i);
        $(this).attr('name',"item_"+j);
        $(this).attr('data-id',i);
        j++;
        i++;
    });
    i = 1;
    j = 0;
    $(".c_order").each(function(){
        $(this).attr('id',"order_"+i);
        $(this).attr('name',"order_number_"+j);
        i++;
        j++;
    });
    i = 1;
    $(".c_status").each(function(){
        $(this).attr('id',"status_"+i);
        i++;
    });
    i = 1;
    $(".c_td").each(function(){
        $(this).attr('id',"td_"+i);
        i++;
    });
    i = 1;
    j = 0;
    $(".c_amount").each(function(){
        $(this).attr('id',"amount_"+i);
        $(this).attr('name',"amount_"+j);
        $(this).attr('data-id',i);
        i++;
        j++;
    });
    i = 1;
    j= 0;
    $(".c_description").each(function(){
        $(this).attr('id',"description_"+i);
        $(this).attr('name',"description_"+j);
        j++;
        i++;
    });

    i = 0;
    $(".value_row").each(function(){
        $(this).attr('value',i);
        i++;
    });
}
//call calculate row
function cal_row() {
    var sub_total = 0;
    var opening_amount = 0;
    $(".c_amount").each(function(){
        var amount = $(this).val();
        var id = $(this).attr("data-id");
        var item = $("#item_"+id).val();

        if($.trim(amount) == "" || $.isNumeric(amount) == false){
            amount = 0;
        }else{
            amount = Number($(this).val());
            var item = $("#item_"+id).val();
            if(item=="Opening Cash"){
                sub_total+=amount;
            }else if(item=="Expense"){
                sub_total-=amount;
            }else if(item=="Purchase"){
                sub_total-=amount;
            }else if(item=="Delivery"){
                sub_total+=amount;
            }
        }
        if(item=="Opening Cash"){
            opening_amount+=amount;
        }

        var this_s = $("#item_"+id).val();

        if(this_s=="Expense"){
            $("#status_"+id).removeClass('fa-plus');
            $("#status_"+id).addClass('fa fa-minus');
        }else if(this_s=="Purchase"){
            $("#status_"+id).removeClass('fa-plus');
            $("#status_"+id).addClass('fa fa-minus');
        }else{
            $("#status_"+id).removeClass('fa-minus');
            $("#status_"+id).addClass('fa fa-plus');
        }
    });
    $(".total_amount").html(sub_total.toFixed(2));
    $(".current_balance").val(sub_total);
    $("#opening_amount").val(opening_amount);

}
//call counter function
counter();
//call calculate row
cal_row();
//add more row
$(document).on('click','.add_more' , function(e){
    var html_c = $(".order_numbers_hidden").html();
    var role = role_;
    var options = `<option value="Expense">${expense}</option>
                                                <option value="Purchase">${purchase}</option>
                                                <option value="Delivery">${Delivery}</option>`;
    if(role=="Admin"){
        options = `<option value="Opening Cash">${OpeningCash}</option>
                                                <option value="Expense">${expense}</option>
                                                <option value="Purchase">${purchase}</option>
                                                <option value="Delivery">${Delivery}</option>`;
    }
    var html = `<tr class="row_counter">
                                        <td>
                                            <table class="width_100_p">
                                                <tr>
                                                    <td class="width_1_p">
                                                    <input type="hidden" value="" class="value_row" name="value_row[]">
                                                    <span class="counter_row">1. </span></td>
                                                    <td>
                                                        <select  class="width_100_p form-control select2 c_item" style="width: 100%" name="items[]" id="">
                                                           ${options}
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="c_td">
                                            <select disabled class="width_100_p form-control select2 c_order" style="width: 100%"  id="">

               ${html_c}
                                            </select>
                                        </td>
                                        <td>
                                            <table class="width_100_p">
                                                <tr>
                                                    <td>
                                                        <i  class="fa fa-plus c_status"></i>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amounts[]"  onfocus="select()"  class="form-control integerchk c_amount" value="">
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                        <td><input type="text" class="form-control c_description" name="descriptions[]" value=""></td>
                                        <td class="txt-uh-33" "><a href="#" class="delete_row"><i class="txt-uh-24 fa fa-trash"></i> </a> </td>
                                    </tr>
      `;
    $(".added_row").append(html);
    $('.select2').select2();
    counter();
    cal_row();
});
$(document).on('click','.delete_row' , function(e){
    e.preventDefault();
    var this_s = $(this);
    swal({
        title: hidden_alert+"!",
        text: are_you_sure+"?",
        cancelButtonText:hidden_cancel,
        confirmButtonText:hidden_ok,
        confirmButtonColor: '#3c8dbc',
        showCancelButton: true
    }, function() {
        this_s.parent().parent().remove();
        cal_row();
    });
});
$(document).on('click','.check_row' , function(e){
    e.preventDefault();
    var this_s = $(this);
    var url = $(this).attr('href');
    //check at least 1 row
    var totalRow = $(".row_counter").length;
    if(!totalRow){
        $(".error_item").show();
    }else{
        $(".error_item").hide();

        var i = 1;
        var status  = false;
        var j = 2;
        var delivery_person_id = $("#delivery_person_id").val();
        if(delivery_person_id==''){
            status = true;
            $("#select2-delivery_person_id-container").parent().css({"border":"1px solid red"});
        }else{
            $("#select2-delivery_person_id-container").parent().css({"border":"1px solid #ced4da"});
        }
        //check at least 1 row
        var totalRow = $(".row_counter").length;
        if(!totalRow){
            status = true;
            $(".error_item").show();
        }else{
            $(".error_item").hide();
        }

        $(".c_amount").each(function(){
            var amount = $(this).val();
            if($.trim(amount) == "" || $.isNumeric(amount) == false){
                status = true;
                $(this).css({"border":"1px solid red"});

            }else{
                $(this).css({"border":"1px solid #ced4da"});
            }

        });

        $(".c_item").each(function(){
            var id = $(this).attr("data-id");
            var value = $(this).val();
            var focus_status = 1;
            if(value=="Expense" || value=="Purchase"){
                var description = $("#description_"+id).val();
                if(description==''){
                    status = true;
                    if(focus_status==1){
                        $("#description_"+id).focus();
                        focus_status++;
                    }
                    $("#description_"+id).css({"border":"1px solid red"});
                }else{
                    $("#description_"+id).css({"border":"1px solid #ced4da"});
                }
            }

            if(value=="Purchase" || value=="Delivery"){
                var order = $("#order_"+id).val();
                if(order==''){
                    status = true;
                    $("#td_"+id+" .select2-selection--single").css({"border":"1px solid red"});
                }else{
                    $("#td_"+id+" .select2-selection--single").css({"border":"1px solid #ced4da"});
                }
            }else{
                $("#td_"+id+" .select2-selection--single").css({"border":"1px solid #ced4da"});
            }

        });

        if(status==true) {
            return false;
        }else{
            swal({
                title: hidden_alert+"!",
                text: are_you_sure+"?",
                cancelButtonText:hidden_cancel,
                confirmButtonText:hidden_ok,
                confirmButtonColor: '#3c8dbc',
                showCancelButton: true
            }, function() {
                window.location.href=url;
            });
        }

    }
});
$(document).on('change','.c_item' , function(e){
    var this_s = $(this).val();
    var id = $(this).attr('data-id');
    if(this_s=="Expense"){
        $("#status_"+id).removeClass('fa-plus');
        $("#status_"+id).addClass('fa fa-minus');
    }else if(this_s=="Purchase"){
        $("#status_"+id).removeClass('fa-plus');
        $("#status_"+id).addClass('fa fa-minus');
    }else{
        $("#status_"+id).removeClass('fa-minus');
        $("#status_"+id).addClass('fa fa-plus');
    }

    if(this_s=="Opening Cash"){
        $("#order_"+id).attr("disabled",true);
        $("#order_"+id).val("").change();
    }else if(this_s=="Expense"){
        $("#order_"+id).attr("disabled",true);
        $("#order_"+id).val("").change();
    }else{
        $("#order_"+id).attr("disabled",false);
    }
    cal_row();
});
$(document).on('keyup','.c_amount' , function(e){
    cal_row();
});
$(document).on('submit','#add_dpitems' , function(e){
    var i = 1;
    var status  = false;
    var j = 2;
    var delivery_person_id = $("#delivery_person_id").val();
    if(delivery_person_id==''){
        status = true;
        $("#select2-delivery_person_id-container").parent().css({"border":"1px solid red"});
    }else{
        $("#select2-delivery_person_id-container").parent().css({"border":"1px solid #ced4da"});
    }
    //check at least 1 row
    var totalRow = $(".row_counter").length;
    if(!totalRow){
        status = true;
        $(".error_item").show();
    }else{
        $(".error_item").hide();
    }

    $(".c_amount").each(function(){
        var amount = $(this).val();
        if($.trim(amount) == "" || $.isNumeric(amount) == false){
            status = true;
            $(this).css({"border":"1px solid red"});

        }else{
            $(this).css({"border":"1px solid #ced4da"});
        }

    });

    $(".c_item").each(function(){
        var id = $(this).attr("data-id");
        var value = $(this).val();
        var focus_status = 1;
        if(value=="Expense" || value=="Purchase"){
            var description = $("#description_"+id).val();
            if(description==''){
                status = true;
                if(focus_status==1){
                    $("#description_"+id).focus();
                    focus_status++;
                }
                $("#description_"+id).css({"border":"1px solid red"});
            }else{
                $("#description_"+id).css({"border":"1px solid #ced4da"});
            }
        }

        if(value=="Purchase" || value=="Delivery"){
            var order = $("#order_"+id).val();
            if(order==''){
                status = true;
                $("#td_"+id+" .select2-selection--single").css({"border":"1px solid red"});
            }else{
                $("#td_"+id+" .select2-selection--single").css({"border":"1px solid #ced4da"});
            }
        }else{
            $("#td_"+id+" .select2-selection--single").css({"border":"1px solid #ced4da"});
        }

    });

    if(status==true) {
        return false;
    }

});