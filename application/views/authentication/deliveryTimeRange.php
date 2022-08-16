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
        <?php echo lang('delivery_time_range'); ?>
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
                <?php echo form_open(base_url() . 'Authentication/deliveryTimeRange/'.(isset($getSiteSetting) && $getSiteSetting->id?$getSiteSetting->id:''), $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
                <div class="box-body">
                    <?php
                    $data = json_decode($getSiteSetting->deliverytimerange);
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th></th>
                                    <th><?php echo lang('Day'); ?>Day</th>
                                    <th><?php echo lang('DeliveryStartTime'); ?></th>
                                    <th><?php echo lang('DeliveryEndTime'); ?></th>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" <?php echo isset($data[0]->status) && $data[0]->status && $data[0]->status==1?'checked':''?> name="status_1" value="1"> </td>
                                    <td><input type="hidden" value="Saturday" class="form-control" name="date_name[]"> Saturday</td>
                                    <td><input type="text" name="s_time[]" id="s_time_1" class="form-control customDatepicker_time counter"  value="<?php echo isset($data[0]->s_time) && $data[0]->s_time?$data[0]->s_time:''?>"></td>
                                    <td><input type="text" name="e_time[]" id="e_time_1" class="form-control customDatepicker_time"  value="<?php echo isset($data[0]->e_time) && $data[0]->e_time?$data[0]->e_time:''?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  <?php echo isset($data[1]->status) && $data[1]->status && $data[1]->status==1?'checked':''?>  name="status_2" value="1"> </td>
                                    <td><input type="hidden" value="Sunday" class="form-control" name="date_name[]"> Sunday</td>
                                    <td><input type="text" name="s_time[]" id="s_time_2" class="form-control customDatepicker_time counter"  value="<?php echo isset($data[1]->s_time) && $data[1]->s_time?$data[1]->s_time:''?>"></td>
                                    <td><input type="text" name="e_time[]" id="e_time_2" class="form-control customDatepicker_time"  value="<?php echo isset($data[1]->e_time) && $data[1]->e_time?$data[1]->e_time:''?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  <?php echo isset($data[2]->status) && $data[2]->status && $data[2]->status==1?'checked':''?>  name="status_3" value="1"> </td>
                                    <td><input type="hidden" value="Monday" class="form-control" name="date_name[]"> Monday</td>
                                    <td><input type="text" name="s_time[]" id="s_time_3" class="form-control customDatepicker_time counter"  value="<?php echo isset($data[2]->s_time) && $data[2]->s_time?$data[2]->s_time:''?>"></td>
                                    <td><input type="text" name="e_time[]" id="e_time_3" class="form-control customDatepicker_time"  value="<?php echo isset($data[2]->e_time) && $data[2]->e_time?$data[2]->e_time:''?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  <?php echo isset($data[3]->status) && $data[3]->status && $data[3]->status==1?'checked':''?>  name="status_4" value="1"> </td>
                                    <td><input type="hidden" value="Tuesday" class="form-control" name="date_name[]"> Tuesday</td>
                                    <td><input type="text" name="s_time[]" id="s_time_4" class="form-control customDatepicker_time counter"  value="<?php echo isset($data[3]->s_time) && $data[3]->s_time?$data[3]->s_time:''?>"></td>
                                    <td><input type="text" name="e_time[]" id="e_time_4" class="form-control customDatepicker_time"  value="<?php echo isset($data[3]->e_time) && $data[3]->e_time?$data[3]->e_time:''?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  <?php echo isset($data[4]->status) && $data[4]->status && $data[4]->status==1?'checked':''?>  name="status_5" value="1"> </td>
                                    <td><input type="hidden" value="Wednesday" class="form-control" name="date_name[]"> Wednesday</td>
                                    <td><input type="text" name="s_time[]" id="s_time_5" class="form-control customDatepicker_time counter"  value="<?php echo isset($data[4]->s_time) && $data[4]->s_time?$data[4]->s_time:''?>"></td>
                                    <td><input type="text" name="e_time[]" id="e_time_5" class="form-control customDatepicker_time"  value="<?php echo isset($data[4]->e_time) && $data[4]->e_time?$data[4]->e_time:''?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  <?php echo isset($data[5]->status) && $data[5]->status && $data[5]->status==1?'checked':''?>  name="status_6" value="1"> </td>
                                    <td><input type="hidden" value="Thursday" class="form-control" name="date_name[]"> Thursday</td>
                                    <td><input type="text" name="s_time[]" id="s_time_6" class="form-control customDatepicker_time counter"  value="<?php echo isset($data[5]->s_time) && $data[5]->s_time?$data[5]->s_time:''?>"></td>
                                    <td><input type="text" name="e_time[]" id="e_time_6" class="form-control customDatepicker_time"  value="<?php echo isset($data[5]->e_time) && $data[5]->e_time?$data[5]->e_time:''?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  <?php echo isset($data[6]->status) && $data[6]->status && $data[6]->status==1?'checked':''?>  name="status_7" value="1"> </td>
                                    <td><input type="hidden" value="Friday" class="form-control" name="date_name[]"> Friday</td>
                                    <td><input type="text" name="s_time[]" id="s_time_7" class="form-control customDatepicker_time counter"  value="<?php echo isset($data[6]->s_time) && $data[6]->s_time?$data[6]->s_time:''?>"></td>
                                    <td><input type="text" name="e_time[]" id="e_time_7" class="form-control customDatepicker_time"  value="<?php echo isset($data[6]->e_time) && $data[6]->e_time?$data[6]->e_time:''?>"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary check_time"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>authentication/siteSetting"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>