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
if ($this->session->flashdata('exception_r')) {

    echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-times"></i>';
    echo escape_output($this->session->flashdata('exception_r'));
    echo '</p></div></section>';
}
?>

<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('Pages'); ?></h2>
        </div>
        <div class="col-md-offset-2 col-md-2">
            <a href="<?php echo base_url() ?>page/addEditPage"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('AddPage'); ?></button></a>
        </div>
        <div class="col-md-2">
            <a href="<?php echo base_url() ?>page/orderPage"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('OrderPage'); ?></button></a>
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
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="width_1_p"><?php echo lang('sn'); ?></th>
                            <th class="width_23_p"><?php echo lang('MenuName'); ?></th>
                        </tr>
                        </thead>
                        <tbody id="sortpage">
                        <?php
                        $i = 1;
                        foreach ($pages as $usrs) {
                            ?>
                            <tr>
                                <td class="counters c_center"><?php echo escape_output($i); ?>
                                <td>
                                    <input  type="hidden" name="pages[]" value="<?php echo escape_output($usrs->id); ?>">
                                    <?php echo escape_output($usrs->menu_name); ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="width_1_p"><?php echo lang('sn'); ?></th>
                            <th class="width_23_p" ><?php echo lang('MenuName'); ?></th>
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
<script src="<?php echo base_url(); ?>assets/js/sorting_page.js"></script>
