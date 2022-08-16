$(function () {
    "use strict";
    //remove tax row
    $(document).on('click','.remove_this_tax_row',function(){
        var this_row = $(this);
        var this_row_id = this_row.attr('id').substr(20);
        $('#tax_row_'+this_row_id).remove();
        var j = 1;
        $('.remove_this_tax_row').each(function(i, obj) {
            $(this).attr('id','remove_this_tax_row_'+j);
            $(this).parent().parent().attr('id','tax_row_'+j);
            $(this).parent().parent().find('td:first-child').text(j);
            j++;
        });
    });
    $(document).on('click','#remove_all_taxes',function(){
        $('.tax_single_row').remove();
    });
    $('#collect_tax_yes').on('click',function(){
        $('#tax_yes_section').fadeIn();
    });
    $('#collect_tax_no').on('click',function(){
        $('#tax_yes_section').fadeOut()
    });

    $('#tax_is_gst_yes').on('click',function(){
        $('#gst_yes_section').fadeIn();
    });
    $('#tax_is_gst_no').on('click',function(){
        $('#gst_yes_section').fadeOut()
    });

    $('#add_tax').on('click',function(){
        var table_tax_body = $('#tax_table_body');
        var tax_body_row_length = table_tax_body.find('tr').length;
        var new_row_number = tax_body_row_length+1;
        var show_tax_row = '';
        show_tax_row += '<tr class="tax_single_row" id="tax_row_'+new_row_number+'">';
        show_tax_row += '<td>'+new_row_number+'</td>';
        show_tax_row += '<td><input type="text" autocomplete="off" name="taxes[]" class="form-control"/></td>';
        show_tax_row += '<td><span class="remove_this_tax_row" id="remove_this_tax_row_'+new_row_number+'" style="cursor:pointer;">X</span></td>';
        show_tax_row += '</tr>';

        table_tax_body.append(show_tax_row);
    });
    $(document).on('change', 'input[type=radio][name=collect_vat]', function(e){
        if (this.value == 'Yes') {
            $('#vat_reg_no_container').show();
        }
        else if (this.value == 'No') {
            $('#vat_reg_no_container').hide();
        }
    });

    $(document).on('click','.show_preview' , function(e){
        var file_path = $(this).attr('href');
        e.preventDefault();
        //show preview
        $("#show_id").attr('src',file_path);
        $("#logo_preview").modal("show");
    });
});