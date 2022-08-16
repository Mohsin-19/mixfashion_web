<link rel="stylesheet" href="<?php echo base_url()?>assets/buttonCSS/checkBotton2.css">
<section class="content-header">
    <h1>
        <h2 class="top-left-header"><?php echo lang('salary'); ?> </h2>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">


            <!-- general form elements -->
            <div class="box box-primary">
                <div class="row">
                    <div class="col-md-12"><br>
                        <div class="form-group">
                            <h3  class="top-left-header txt-uh-82"><?php echo lang('generate_salary_for'); ?>: <?php echo escape_output($month)?> - <?php echo escape_output($year)?></h3>
                        </div>
                    </div>
                </div>

                <!-- form start -->
                <?php
                $attributes = array('id' => 'add_salary');
                echo form_open_multipart(base_url('salary/addEditSalary/'), $attributes); ?>
                <input type="hidden" name="month" value="<?php echo escape_output($month)?>">
                <input type="hidden" name="year" value="<?php echo escape_output($year)?>">
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="width_10_p">
                                    <label class="container width_83_p"> <?php echo lang('select_all'); ?>
                                        <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th class="width_15_p" ><?php echo lang('name'); ?></th>
                                <th class="width_10_p"><?php echo lang('salary'); ?></th>
                                <th class="width_10_p"><?php echo lang('additional'); ?></th>
                                <th class="width_10_p"><?php echo lang('subtraction'); ?></th>
                                <th class="width_10_p"><?php echo lang('total'); ?></th>
                                <th class="width_15_p"><?php echo lang('note'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($getSalaryUsers && !empty($getSalaryUsers)) {
                                $i = count($getSalaryUsers);
                            }
                            foreach ($getSalaryUsers as $usrs) {
                                    ?>
                                    <tr class="row_counter" data-id="<?php echo escape_output($usrs->id); ?>">
                                        <td class="c_center">
                                            <table class="width_100_p">
                                                <tr>
                                                    <td class="txt-uh-81">  <label class="container"><?php echo lang('select'); ?>
                                                            <input type="checkbox"  class="checkbox_user" value="1" name="product_id<?php echo escape_output($usrs->id); ?>">
                                                            <span class="checkmark"></span>
                                                        </label></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td><?php echo escape_output($usrs->full_name); ?>
                                            <input type="hidden" name="user_id[]" value="<?php echo escape_output($usrs->id); ?>">
                                        </td>
                                        <td><input type="text" class="form-control"  id="salary_<?php echo escape_output($usrs->id); ?>" name="salary[]" value="<?php echo isset($usrs->salary) && $usrs->salary?$usrs->salary:'0.00'?>" readonly></td>
                                        <td><input type="text" class="form-control cal_row integerchk" onfocus="select();" id="additional_<?php echo escape_output($usrs->id); ?>"  name="additional[]" value=""></td>
                                        <td><input type="text" class="form-control cal_row integerchk" onfocus="select();" id="subtraction_<?php echo escape_output($usrs->id); ?>"  name="subtraction[]" value=""></td>
                                        <td><input type="text" class="form-control" readonly id="total_<?php echo escape_output($usrs->id); ?>"  name="total[]" value=""></td>
                                        <td><input type="text" class="form-control"  name="notes[]" value=""></td>
                                    </tr>
                                    <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="width_10_p"><label  class="container width_83_p"> <?php echo lang('select_all'); ?>
                                        <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                        <span class="checkmark"></span>
                                    </label></th>
                                <th class="width_15_p"><?php echo lang('name'); ?></th>
                                <th class="width_10_p"><?php echo lang('salary'); ?></th>
                                <th class="width_10_p"><?php echo lang('additional'); ?></th>
                                <th class="width_10_p"><?php echo lang('subtraction'); ?></th>
                                <th class="width_10_p"><?php echo lang('total'); ?> = <span class="total_amount"></span></th>
                                <th class="width_15_p"><?php echo lang('note'); ?></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>salary/generate"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/js/salary.js"></script>