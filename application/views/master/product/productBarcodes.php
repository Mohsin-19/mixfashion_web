
<?php

if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));
    echo '</p></div></section>';
}
?>
<?php
// generate 89% width for select all button
$width_89_p = "width:89%";
?>
<link rel="stylesheet" href="<?php echo base_url()?>assets/buttonCSS/checkBotton2.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/user_home.css">
<section class="content">

    <div class="panel panel-default thumbnail">
        <div class="row padding_add">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo lang('product_barcode'); ?></h2>
            </div>

        </div>


        <div class="panel-body">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <?php echo form_open(base_url() . 'Item/productBarcodeGenerator', $arrayName = array('id' => 'productBarcodeGenerator','enctype'=>'multipart/form-data')) ?>
                <button type="submit" name="submit" value="submit" class="btn btn-primary alertClass"><?php echo lang('submit'); ?></button>
                <a href="<?php echo base_url() ?>Item/products"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                <table id="datatable_id" class="table datatable table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="width_5_p c_center">
                            <label style="<?php echo escape_output($width_89_p)?>" class="container"> <?php echo lang('select_all'); ?>
                                <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th class="width_2_p"><?php echo lang('code'); ?></th>
                        <th class="width_16_p"><?php echo lang('name'); ?></th>
                        <th class="width_10_p"><?php echo lang('category'); ?></th>
                        <th class="width_7_p"><?php echo lang('purchase_price'); ?></th>
                        <th class="width_7_p"><?php echo lang('sale_price'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($products && !empty($products)) {
                        $i = count($products);
                    }
                    foreach ($products as $ingrnts) {
                        ?>
                        <tr>
                            <th class="c_center">
                                <table class="width_100_p">
                                    <tr>
                                        <td class="width_25_p">  <input class="width_100_p c_center" disabled type="number" min="1" id="qty<?php echo escape_output($ingrnts->id); ?>" name="qty[]" value=""></td>
                                        <td class="txt-uh-57">  <label class="container"><?php echo lang('select'); ?>
                                                <input type="checkbox"  class="checkbox_user" data-menu_id="<?php echo escape_output($ingrnts->id); ?>" value="<?php echo escape_output($ingrnts->id)."|".$ingrnts->name."|".$ingrnts->code."|".$ingrnts->sale_price?>" name="product_id[]"?>
                                                <span class="checkmark"></span>
                                            </label></td>
                                    </tr>
                                </table>
                            </td>
                            <td><?php echo escape_output($ingrnts->code); ?></td>
                            <td><?php echo escape_output($ingrnts->name); ?></td>
                            <td><?php echo productCategoryName($ingrnts->category_id); ?></td>
                            <td> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($ingrnts->purchase_price); ?></td>
                            <td> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($ingrnts->sale_price); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <label style="<?php echo escape_output($width_89_p)?>"  class="container"> <?php echo lang('select_all'); ?>
                                <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th class="width_2_p"><?php echo lang('code'); ?></th>
                        <th class="width_16_p"><?php echo lang('name'); ?></th>
                        <th class="width_10_p"><?php echo lang('category'); ?></th>
                        <th class="width_7_p"><?php echo lang('purchase_price'); ?></th>
                        <th class="width_7_p"><?php echo lang('sale_price'); ?></th>
                    </tr>
                    </tfoot>
                </table>
                <button type="submit" name="submit" value="submit" class="btn btn-primary alertClass"><?php echo lang('submit'); ?></button>
                <a href="<?php echo base_url() ?>Item/products"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                <?php echo form_close(); ?>
            </div>  <!-- /.table-responsive -->
        </div>
    </div>

</section>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?php echo base_url(); ?>assets/js/product_barcode.js"></script>
