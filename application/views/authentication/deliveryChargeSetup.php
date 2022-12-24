<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));
    echo '</p></div></section>';
}
?>
<?php
if ($this->session->flashdata('exception_1')) {

    echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception_1'));
    echo '</p></div></section>';
}
?>
<section class="content-header">
    <h1>
        <?php echo lang('delivery_charge_setup'); ?>
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
                <?php echo form_open(base_url() . 'Authentication/deliveryChargeSetup/'.(isset($getSiteSetting) && $getSiteSetting->id?$getSiteSetting->id:''), $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
                <div class="box-body">
                    <?php
                    $data = json_decode($getSiteSetting->deliveryChargeSetup);
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">

                                    <tr>
                                        <th>
                                            <?php echo lang('StartAmount'); ?></th>
                                        <th>
                                            <?php echo lang('EndAmount'); ?>
                                        </th>
                                        <th>
                                            <?php echo lang('Charge'); ?>
                                        </th>
                                        <th>

                                        </th>
                                    </tr>

                                <tbody class="added_row">
                                <?php
                                if(isset($data) && $data):
                                    foreach ($data as $value):
                                        ?>
                                        <tr>
                                            <td><input type="text" name="s_amount[]" class="form-control check_required integerchk counter1"  value="<?php echo isset($value->s_amount) && $value->s_amount?$value->s_amount:'0'?>"></td>
                                            <td><input type="text" name="e_amount[]" class="form-control check_required integerchk counter2"  value="<?php echo isset($value->e_amount) && $value->e_amount?$value->e_amount:'0'?>"></td>
                                            <td><input type="text" name="c_amount[]" class="form-control check_required integerchk "  value="<?php echo isset($value->c_amount) && $value->c_amount?$value->c_amount:'0'?>"></td>
                                            <td class="txt-uh-23"><a href="#" class="delete_row"><i class="txt-uh-24 fa fa-trash"></i> </a> </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                else:
                                    ?>

                                    <?php
                                endif;
                                ?>
                                </tbody>

                            </table>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-2">
                            <button type="button" name="button" value="submit" class="btn btn-primary add_more"><?php echo lang('AddMore'); ?></button>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary check_amount"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>authentication/siteSetting"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/js/delivery_charge_setup.js"></script>