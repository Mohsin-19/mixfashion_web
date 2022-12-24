<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('OrderCategory'); ?> </h2>
        </div>

    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form method="post" id="sorting_form">
                     <table id="" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="width_1_p"><?php echo lang('sn'); ?></th>
                            <th class="width_28_p"><?php echo lang('category_name'); ?></th>
                            <th class="width_7_p"><?php echo lang('Icon'); ?></th>
                            <th class="width_25_p"><?php echo lang('description'); ?></th>
                        </tr>
                        </thead>
                        <tbody id="sortProdctCat">
                        <?php
                        $i = 1;
                        foreach ($productCategories as $fmc) {
                            ?>
                            <tr class="txt-uh-59">
                                <td class="counters c_center"><?php echo escape_output($i); ?>
                                </td>
                                <td>
                                    <input  type="hidden" name="cats[]" value="<?php echo escape_output($fmc->id); ?>">
                                    <?php echo escape_output($fmc->name); ?></td>
                                <td>
                                <?php
                                if(isset($fmc->icon) && $fmc->icon):
                                ?>
                                    <i style="color: <?php echo escape_output($fmc->icon_color)?$fmc->icon_color:''?>" class="<?php echo escape_output($fmc->icon); ?>"></i>
                                    <?php
                                    endif;
                                    ?>
                                    </td>
                                <td><?php echo escape_output($fmc->description); ?></td>

                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('category_name'); ?></th>
                            <th><?php echo lang('Icon'); ?></th>
                            <th><?php echo lang('description'); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/dist/js/jquery.dragsort.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/category_sorting.js"></script>