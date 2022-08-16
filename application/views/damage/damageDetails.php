<section class="content-header">
    <h1>
        <?php echo lang('details_damage'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url() . 'Damage/addEditDamage/' . $encrypted_id, $arrayName = array('id' => 'Damage_form')) ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <h3><?php echo lang('ref_no'); ?></h3>
                                <p class="field_value"><?php echo escape_output($damage_details->reference_no); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <h3><?php echo lang('date'); ?> </h3>
                                <p class="field_value"><?php echo date($this->session->userdata('date_format'), strtotime($damage_details->date)); ?></p>
                            </div> 
                        </div>

                        <div class="col-md-4">
                            <div class="form-group"> 
                                <h3><?php echo lang('responsible_person'); ?> </h3>
                                <p class="field_value"><?php echo employeeName($damage_details->employee_id); ?></p>
                            </div>   
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6">  
                            <div class="form-group"> 
                                <h3><?php echo lang('products'); ?> </h3> 
                            </div>   
                        </div> 
                    </div> 

                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="table-responsive" id="Damage_cart">          
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="10%"><?php echo lang('sn'); ?></th>
                                            <th width="25%"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
                                            <th width="25%"><?php echo lang('quantity_amount'); ?></th>
                                            <th width="25%"><?php echo lang('loss_amount'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 0;
                                        if ($damage_products && !empty($damage_products)) {
                                            foreach ($damage_products as $value) {
                                                $i++;
                                                echo '<tr id="row_' . $i . '">' .
                                                '<td class="width_10_p txt-uh-12"><p>' . $i . '</p></td>' .
                                                '<td class="width_20_p"><span class="txt-uh-37">' . getItemNameById($value->product_id) . ' (' . getItemCodeById($value->product_id) . ')</span></td>' .
                                                '<td class="width_15_p">' . $value->damage_amount . unitName(getSaleUnitIdByIgId($value->product_id)) . '</td>' .
                                                '<td class="width_15_p">' . $this->session->userdata('currency') . " " . $value->loss_amount . '<span"></span></td>' .
                                                '</tr>';
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div> 
                        </div>

                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <h3><?php echo lang('total_loss'); ?></h3>
                                <p class="field_value"> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($damage_details->total_loss); ?>
                                   </p>
                            </div>   
                        </div>  
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <h3><?php echo lang('note'); ?></h3>
                                <p class="field_value"><?php echo escape_output($damage_details->note); ?></p>
                            </div> 
                        </div> 
                    </div> 
                </div> 
                <div class="box-footer">
                    <!-- <a href="<?php echo base_url() ?>Damage/addEditDamage/<?php echo escape_output($encrypted_id); ?>"><button type="button" class="btn btn-primary"><?php echo lang('edit'); ?></button></a> -->
                    <a href="<?php echo base_url() ?>Damage/damages"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?> 
            </div> 
        </div>
    </div> 
</section>