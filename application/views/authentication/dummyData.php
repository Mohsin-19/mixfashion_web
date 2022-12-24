<section class="content-header">
    <h1>
        <?php echo lang('upload_food_menu'); ?>
    </h1>

    <?php
    if ($this->session->flashdata('exception')) {

        echo '<div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));
        echo '</p></div>';
    }
    if ($this->session->flashdata('exception_err')) {

        echo '<div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception_err'));
        echo '</p></div>';
    }
    ?>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-footer c_center">
                    <div class="col-md-4 col-md-offset-4">
                        <a class="delete btn btn-primary btn-block" href="<?php echo base_url() ?>Authentication/dummyData/add">
                            <i class="fa fa-check"></i> <?php echo lang('Import Dummy Data'); ?></a>
                    </div>

                    <div class="col-md-4 col-md-offset-4">
                        <div class="clearfix"><p></p></div>
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <a class="delete_dummy_data btn btn-danger btn-block" href="<?php echo base_url() ?>Authentication/dummyData/delete">
                            <i class="fa fa-trash"></i> <?php echo lang('Delete Dummy Data'); ?></a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>