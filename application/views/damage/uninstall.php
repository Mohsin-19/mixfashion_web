<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/uninstall.css">
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
	</br>
	</br> 
    <div class="row">
    	<?php if($this->session->flashdata('status') == 'error'){ ?>
    	<div class="col-md-6 col-md-offset-3">
    		<div class="panel-default"> 
    			<div class="alert alert-danger" role="alert">
				  <?php echo escape_output($this->session->flashdata('exception')); ?>
				</div>
    		</div>
    	</div>
    	<?php } ?>

    	<?php if($this->session->flashdata('status') == 'success'){ ?>
    	<div class="col-md-6 col-md-offset-3">
    		<div class="panel-default"> 
    			<div class="alert alert-success" role="alert">
				  <?php echo escape_output($this->session->flashdata('exception')); ?>
				</div>
    		</div>
    	</div>
    	<?php } ?>

    	<div class="col-md-6 col-md-offset-3">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title c_center">Uninstall Your Software</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form action="<?php echo base_url();?>Authentication/Uninstall" method='POST' accept-charset="UTF-8" role="form">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="Username" name="username" type="text">
			    		</div>
			    		<?php if (form_error('username')) { ?>
                            <div class="alert alert-danger txt-1">
                                <p><?php echo form_error('username'); ?></p>
                            </div>
                        <?php } ?>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Purchase Code" name="purchase_code" type="text">
			    		</div>
			    		<?php if (form_error('purchase_code')) { ?>
                            <div class="alert alert-danger txt-1">
                                <p><?php echo form_error('purchase_code'); ?></p>
                            </div>
                        <?php } ?>
			    		<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
			    		<a href="<?php echo base_url() ?>Authentication/Index"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
			    	</fieldset>
			      	</form> 
			    </div>
			    <div class="panel-footer">
			    	<h4 class="txt-2">Please make sure that you have good internet connection</h4>
			    </div>
			</div>
		</div>
	</div>
</div>