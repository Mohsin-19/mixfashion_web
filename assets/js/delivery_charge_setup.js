//row counter function
function counter() {

    var i = 1;
    $(".counter1").each(function(){
        $(this).attr('id',"s_amount_"+i);
        i++;
    });
    var i = 1;
    $(".counter2").each(function(){
        $(this).attr('id',"e_amount_"+i);
        i++;
    });
}
//set row counter
counter();
//add more row
$(document).on('click','.add_more' , function(e){
    var html = `
      <tr>
                                        <td><input type="text" name="s_amount[]" class="form-control check_required  integerchk counter1"  value=""></td>
                                        <td><input type="text" name="e_amount[]" class="form-control check_required integerchk  counter2"  value=""></td>
                                        <td><input type="text" name="c_amount[]" class="form-control check_required integerchk"  value=""></td>
                                        <td class="txt-uh-23"><a href="#" class="delete_row"><i   class="txt-uh-24 fa fa-trash"></i> </a> </td>
                                    </tr>
      `;
    $(".added_row").append(html);
    counter();
});
//delete row
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
    });
});
//call before submit the form for checking delivery charge amount
$('#add_whitelabel').on('submit',function(){
    var i = 1;
    var status  = false;
    var j = 2;
    $(".counter1").each(function(){
        var s_amount = Number($(this).val());
        var e_amount = Number($("#e_amount_"+i).val());
        var tmp_s_amount = Number($("#s_amount_"+j).val());

        if(s_amount > e_amount){
            status = true;
            $(this).css("border","1px solid red");
            $("#e_amount_"+i).css("border","1px solid red");
        }else{
            if(tmp_s_amount && (tmp_s_amount<=e_amount)){
                status = true;
                $("#s_amount_"+j).css("border","1px solid red");
                $("#e_amount_"+i).css("border","1px solid red");
            }else{
                $("#e_amount_"+i).css("border","1px solid #ccc");
            }

        }
        i++;
        j++;
    });

    //check required fields
    $(".check_required").each(function(){
        var value = $.trim($(this).val());
        if(value == '' || isNaN(value)){
            status = true;
            $(this).css("border","1px solid red");
        }else{
            $(this).css("border","1px solid #ccc");
        }
    });


    if(status==true) {
        return false;
    }

});