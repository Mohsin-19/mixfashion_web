<!--load invoice js-->
<script src="<?php echo base_url(); ?>assets/js/invoice_setting.js"></script>
<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));
    echo '</p></div></section>';
}
?>
<section class="content-header">
    <h1>
        <?php echo lang('restaurant_setting'); ?>
    </h1>

</section>

<!-- Main content -->
<section class="content">
    <div class="row">

        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php
                $attributes = array('id' => 'restaurant_setting_form');
                echo form_open_multipart(base_url('POS_setting/setting/' . $encrypted_id),$attributes); ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('outlet_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="outlet_name" name="outlet_name" class="form-control" placeholder="<?php echo lang('outlet_name'); ?>" value="<?php echo escape_output($outlet_information->outlet_name); ?>">
                            </div>
                            <?php if (form_error('outlet_name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('outlet_name'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error txt-uh-21 display_none" id="outlet_name_error">
                                <p><?php echo lang('TheShopNamefieldisrequired'); ?></p>
                            </div>


                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('address'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off" type="text" id="address" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>" value="<?php echo escape_output($outlet_information->address); ?>">
                            </div>
                            <?php if (form_error('address')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('address'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error txt-uh-21 display_none" id="address_error">
                                <p><?php echo lang('TheAddressfieldisrequired'); ?></p>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 display_none">

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label> <small>(<?php echo lang('Notforlogin, for showing in print receipt'); ?>)</small>
                                <input tabindex="4" autocomplete="off" type="text" id="phone" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo escape_output($outlet_information->phone); ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('phone'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error txt-uh-21 display_none" id="phone_error">
                                <p><?php echo lang('ThePhonefieldisrequired'); ?></p>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('invoice_footer'); ?></label>
                                <input tabindex="4" autocomplete="off" type="text" name="invoice_footer" class="form-control" placeholder="<?php echo lang('invoice_footer'); ?>" value="<?php echo escape_output($outlet_information->invoice_footer); ?>">
                            </div>
                            <?php if (form_error('invoice_footer')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('invoice_footer'); ?></p>
                                </div>
                            <?php } ?>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group radio_button_problem">
                                <label><?php echo lang('collect_tax'); ?> <span class="required_star">*</span></label>
                                <div class="radio">
                                    <label>
                                        <input tabindex="5" autocomplete="off" type="radio" name="collect_tax" id="collect_tax_yes" value="Yes"
                                            <?php
                                            if ($outlet_information->collect_tax == "Yes") {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('Yes'); ?> </label>
                                    <label>

                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <input tabindex="5" autocomplete="off" type="radio" name="collect_tax" id="collect_tax_no" value="No"
                                            <?php
                                            if ($outlet_information->collect_tax == "No" || ($outlet_information->collect_tax != "Yes" && $outlet_information->collect_tax != "No")) {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('No'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php if (form_error('collect_tax')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('collect_tax'); ?></p>
                                </div>
                            <?php } ?>


                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('tax_registration_no'); ?> <span class="required_star">*</span></label>
                                <input tabindex="7" autocomplete="off" type="text" id="tax_registration_no" name="tax_registration_no" class="form-control" placeholder="<?php echo lang('tax_registration_no'); ?>" value="<?php echo escape_output($outlet_information->tax_registration_no); ?>">
                            </div>
                            <?php if (form_error('tax_registration_no')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('tax_registration_no'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error txt-uh-21 display_none" id="tax_registration_no_error">
                                <p><?php echo lang('TheTaxRegistrationNofieldisrequired'); ?></p>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group radio_button_problem">
                                <label><?php echo lang('print_format'); ?> <span class="required_star">*</span></label>
                                <div class="radio">
                                    <label>
                                        <input tabindex="5" autocomplete="off" type="radio" name="print_format" id="print_format_thermal" value="No Print"
                                            <?php
                                            if ($outlet_information->print_format == "No Print") {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('NoPrint'); ?> </label>

                                    <label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input tabindex="5" autocomplete="off" type="radio" name="print_format" id="print_format_thermal" value="Thermal Print"
                                            <?php
                                            if ($outlet_information->print_format == "Thermal Print") {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('ThermalPrint'); ?> </label>
                                    <label>

                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <input tabindex="5" autocomplete="off" type="radio" name="print_format" id="print_format_a4" value="A4 Print"
                                            <?php
                                            if ($outlet_information->print_format == "A4 Print") {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('A4Print'); ?>
                                    </label>
                                    <label>

                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <input tabindex="6" autocomplete="off" type="radio" name="print_format" id="print_format_ha4" value="Half A4 Print"
                                            <?php
                                            if ($outlet_information->print_format == "Half A4 Print") {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('HalfA4Print'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php if (form_error('print_format')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('print_format'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('invoice_logo'); ?></label><a class="btn btn-xs btn-primary show_preview pull-right" href="<?php echo base_url()?>images/<?php echo escape_output($outlet_information->invoice_logo); ?>">Show</a>
                                <input tabindex="8" autocomplete="off" type="file" name="invoice_logo" class="form-control">
                                <input tabindex="8" autocomplete="off" type="hidden" name="invoice_logo_p" class="form-control"  value="<?php echo escape_output($outlet_information->invoice_logo); ?>">
                            </div>
                            <?php if (form_error('invoice_logo')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('invoice_logo'); ?></p>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="col-md-3 display_none">

                            <div class="form-group">
                                <label><?php echo lang('product_modal_status'); ?></label>
                                <select class="form-control select2 width_100_p" name="product_modal_status">
                                    <option <?php echo escape_output($outlet_information->product_modal_status) && $outlet_information->product_modal_status=="Show"?'selected':''?> value="Show">Yes</option>
                                    <option  <?php echo escape_output($outlet_information->product_modal_status) && $outlet_information->product_modal_status=="Hide"?'selected':''?> value="Hide">No</option>
                                </select>

                            </div>
                            <?php if (form_error('product_modal_status')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('product_modal_status'); ?></p>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div id="tax_yes_section" style="display:<?php if($outlet_information->collect_tax=="Yes"){echo "block;";}else{echo "none;";}?>">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label><?php echo lang('my_tax_title'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="1" type="text" id="tax_title" name="tax_title" class="form-control" placeholder="<?php echo lang('my_tax_title'); ?>" value="<?php echo escape_output($outlet_information->tax_title); ?>">
                                </div>
                                <?php if (form_error('tax_title')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('tax_title'); ?></p>
                                    </div>
                                <?php } ?>
                                <div class="alert alert-error txt-uh-21 display_none" id="tax_title_error">
                                    <p>The Tax Title field is required.</p>
                                </div>
                                <button id="show_how_tax_title_works" type="button" class="btn btn-primary" data-toggle="modal" data-target="#show_how_tax_title_works_modal"><?php echo lang('how_tax_title_works'); ?></button>


                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label><?php echo lang('tax_registration_no'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="1" type="text" id="tax_registration_no" name="tax_registration_no" class="form-control" placeholder="<?php echo lang('tax_registration_no'); ?>" value="<?php echo escape_output($outlet_information->tax_registration_no); ?>">
                                </div>
                                <?php if (form_error('tax_registration_no')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('tax_registration_no'); ?></p>
                                    </div>
                                <?php } ?>
                                <div class="alert alert-error txt-uh-21 display_none" id="tax_registration_no_error">
                                    <p><?php echo lang('TheTaxRegistrationNofieldisrequired.'); ?></p>
                                </div>

                            </div>


                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group radio_button_problem">
                                    <label><?php echo lang('tax_is_gst'); ?> <span class="required_star">*</span></label>
                                    <div class="radio">
                                        <label>
                                            <input tabindex="5" type="radio" name="tax_is_gst" id="tax_is_gst_yes" value="Yes"
                                                <?php
                                                if ($outlet_information->tax_is_gst == "Yes") {
                                                    echo "checked";
                                                };
                                                ?>
                                            >Yes </label>
                                        <label>

                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <input tabindex="6" type="radio" name="tax_is_gst" id="tax_is_gst_no" value="No"
                                                <?php
                                                if ($outlet_information->tax_is_gst == "No" || ($outlet_information->tax_is_gst != "Yes" && $outlet_information->tax_is_gst != "No")) {
                                                    echo "checked";
                                                };
                                                ?>
                                            >No
                                        </label>
                                    </div>
                                </div>
                                <?php if (form_error('tax_is_gst')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('tax_is_gst'); ?></p>
                                    </div>
                                <?php } ?>
                                <button id="what_will_happen_if_i_say_yes" type="button" class="btn btn-primary" data-toggle="modal" data-target="#what_will_happen_if_i_say_yes_modal"><?php echo lang('if_i_say_yes'); ?></button>

                            </div>
                        </div>
                        <div id="gst_yes_section" style="display:<?php if($outlet_information->tax_is_gst=="Yes"){echo "block;";}else{echo "none;";} ?>">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label><?php echo lang('state_code'); ?> <span class="required_star">*</span></label>
                                        <input tabindex="1" type="text" id="state_code" name="state_code" class="form-control" placeholder="<?php echo lang('state_code'); ?>" value="<?php echo escape_output($outlet_information->state_code); ?>">
                                    </div>
                                    <?php if (form_error('state_code')) { ?>
                                        <div class="alert alert-error txt-uh-21">
                                            <p><?php echo form_error('state_code'); ?></p>
                                        </div>
                                    <?php } ?>
                                    <div class="alert alert-error txt-uh-21 display_none" id="state_code_error">
                                        <p><?php echo lang('TheStateCodefieldisrequired.'); ?></p>
                                    </div>

                                </div>


                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label><?php echo lang('my_tax_fields');?> <span class="required_star">*</span></label>
                                    <table id="datatable" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                            <th class="width_20_p"><?php echo lang('name'); ?></th>
                                            <th class="width_10_p"><span id="remove_all_taxes" class="txt-uh-72">X</span></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tax_table_body">
                                        <?php
                                        $new_row_number = 1;
                                        $show_tax_row = '';
                                        if(isset($outlet_taxes) && count($outlet_taxes)>0){
                                            foreach($outlet_taxes as $single_tax){
                                                $show_tax_row .= '<tr class="tax_single_row" id="tax_row_'.$new_row_number.'">';
                                                $show_tax_row .= '<td>'.$new_row_number.'</td>';
                                                $show_tax_row .= '<td><input type="hidden" name="p_tax_id[]" value="'.$single_tax->id.'"> <input type="text" name="taxes[]" class="form-control" value="'.$single_tax->tax.'"/></td>';
                                                $show_tax_row .= '<td><span class="remove_this_tax_row txt-uh-72" id="remove_this_tax_row_'.$new_row_number.'">X</span></td>';
                                                $show_tax_row .= '</tr>';
                                                $new_row_number++;
                                            }
                                        }
                                        ////This variable could not be escaped because need print as a html
                                        echo $show_tax_row
                                        ?>
                                        </tbody>
                                    </table>
                                    <button id="add_tax" class="btn btn-primary" type="button"><?php echo lang('add_more'); ?></button>
                                    <!-- <input tabindex="1" type="text" name="state_code" class="form-control" placeholder="State Code" value="<?php echo set_value('state_code'); ?>" /> -->
                                </div>
                                <?php if (form_error('taxes[]')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('taxes[]'); ?></p>
                                    </div>
                                <?php } ?>
                                <button id="show_how_tax_fields_work" type="button" class="btn btn-primary" data-toggle="modal" data-target="#show_how_tax_fields_work_modal"><?php echo lang('how_tax_fields_work'); ?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
</section>


<div class="modal fade" id="logo_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 c_center">
                        <img  src="" id="show_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="show_sample_invoice_with_tax_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo lang('SampleInvoice'); ?></h4>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <img src="<?php echo base_url()?>assets/images/GST Invoice.png">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="show_how_tax_title_works_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo lang('how_tax_title_works'); ?></h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('how_tax_title_works_details'); ?>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="what_will_happen_if_i_say_yes_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo lang('WhatwillhappenifIsayYes'); ?></h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('yes_happen_details'); ?>


                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="show_how_tax_fields_work_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo lang('Howtaxfieldswork'); ?></h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('tax_details'); ?>


                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>