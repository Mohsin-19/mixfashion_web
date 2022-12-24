<link rel="stylesheet" href="<?php echo base_url() ?>assets/buttonCSS/checkBotton2.css">
<section class="content">

  <div class="panel panel-default thumbnail">
    <div class="row padding_add">
      <div class="col-md-6">
        <h2 class="top-left-header"><?php echo lang('BulkPriceUpdate'); ?></h2>
      </div>

    </div>

    <div class="panel-body">
      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
        <?php echo form_open_multipart(site_url('bulkPriceUpdate/index'), ['id' => 'productBarcodeGenerator']) ?>
        <table id="datatable_id" class="table datatable table-striped table-bordered table-hover">
          <thead>
          <tr>
            <th class="width_1_p"><?php echo lang('sn'); ?></th>
            <th class="width_16_p"><?php echo lang('name'); ?></th>
            <th class="width_7_p"><?php echo lang('LatestPrice'); ?></th>
            <th class="width_7_p">Delivery Charge</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if ($products && !empty($products)) {
            $i = count($products);
          }
          foreach ($products as $ingrnts): ?>
            <tr>
              <td class="width_1_p">
                <?php echo escape_output($i--) ?>
              </td>
              <td>
                <input type="hidden" value="<?php echo escape_output($ingrnts->id); ?>" name="product_id[]">
                <?php echo escape_output($ingrnts->name); ?>
              </td>
              <td>
                <table class="width_100_p">
                  <tr>
                    <td class="width_1_p"><?= escape_output($this->session->userdata('currency')); ?></td>
                    <td>
                      <input type="text" onfocus="select();" name="sale_price<?= escape_output($ingrnts->id); ?>"
                             class="form-control integerchk" value="<?= escape_output($ingrnts->sale_price); ?>">
                    </td>
                  </tr>
                </table>
              </td>
              <td>
                <table class="width_100_p">
                  <tr>
                    <td class="width_1_p"><?= escape_output($this->session->userdata('currency')); ?></td>
                    <td>
                      <input type="text" onfocus="select();" name="delivery_charge<?= escape_output($ingrnts->id); ?>"
                             class="form-control " value="<?= $ingrnts->delivery_charge ?>">
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
          <tr>
            <th class="width_1_p"><?= lang('sn'); ?></th>
            <th class="width_16_p"><?= lang('name'); ?></th>
            <th class="width_7_p"><?= lang('LatestPrice'); ?></th>
            <th class="width_7_p">Delivery Charge</th>
          </tr>
          </tfoot>
        </table>
        <button type="submit" name="submit" value="submit" class="btn btn-primary alertClass">
          <?= lang('submit'); ?>
        </button>
        <a href="<?= site_url('Item/products') ?>">
          <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
        </a>
        <?php echo form_close(); ?>
      </div>  <!-- /.table-responsive -->
      <p><i class="txt-uh-51">-<?php echo lang('custom_txt1'); ?></i></p>
    </div>
  </div>

</section>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?php echo base_url(); ?>assets/js/custom_report_1.js"></script>