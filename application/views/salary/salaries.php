<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('salary'); ?> </h2>
    </div>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="row">
          <div class="col-md-3"><br>
            <div class="form-group">
              <h3 class="top-left-header txt-uh-82 c_txt_left">
                <?php echo lang('generate_salary_for'); ?>
              </h3>
            </div>
          </div>
          <?php
          $attributes = array('id' => 'generate');
          echo form_open_multipart(base_url('salary/generate/'), $attributes); ?>
          <div class="col-md-2"><br>
            <div class="form-group">
              <select name="month" class="form-control select2 width_100_p">
                <option value=""><?php echo lang('month'); ?></option>
                <option <?php echo set_select('month', "January"); ?> value="January"><?php echo lang('January'); ?></option>
                <option <?php echo set_select('month', "February"); ?> value="February"><?php echo lang('February'); ?></option>
                <option <?php echo set_select('month', "March"); ?> value="March"><?php echo lang('March'); ?></option>
                <option <?php echo set_select('month', "April"); ?> value="April"><?php echo lang('April'); ?></option>
                <option <?php echo set_select('month', "May"); ?> value="May"><?php echo lang('May'); ?></option>
                <option <?php echo set_select('month', "June"); ?> value="June"><?php echo lang('June'); ?></option>
                <option <?php echo set_select('month', "July"); ?> value="July"><?php echo lang('July'); ?></option>
                <option <?php echo set_select('month', "August"); ?> value="August"><?php echo lang('August'); ?></option>
                <option <?php echo set_select('month', "September"); ?> value="September"><?php echo lang('September'); ?></option>
                <option <?php echo set_select('month', "October"); ?> value="October"><?php echo lang('October'); ?></option>
                <option <?php echo set_select('month', "November"); ?> value="November"><?php echo lang('November'); ?></option>
                <option <?php echo set_select('month', "December"); ?> value="December"><?php echo lang('December'); ?></option>
              </select>
              <?php if (form_error('month')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <span class="error_paragraph"><?php echo form_error('month'); ?></span>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-2"><br>
            <div class="form-group">
              <select name="year" class="form-control select2 width_100_p">
                <option value=""><?php echo lang('year'); ?></option>
                <option <?php echo set_select('year', "2018"); ?> value="2018"><?php echo lang('2018s'); ?></option>
                <option <?php echo set_select('year', "2019"); ?> value="2019"><?php echo lang('2019s'); ?></option>
                <option <?php echo set_select('year', "2020"); ?> value="2020"><?php echo lang('2020s'); ?></option>
                <option <?php echo set_select('year', "2021"); ?> value="2021"><?php echo lang('2021s'); ?></option>
                <option <?php echo set_select('year', "2022"); ?> value="2022"><?php echo lang('2022s'); ?></option>
                <option <?php echo set_select('year', "2023"); ?> value="2023"><?php echo lang('2023s'); ?></option>
                <option <?php echo set_select('year', "2024"); ?> value="2024"><?php echo lang('2024s'); ?></option>
                <option <?php echo set_select('year', "2025"); ?> value="2025"><?php echo lang('2025s'); ?></option>
                <option <?php echo set_select('year', "2026"); ?> value="2026"><?php echo lang('2026s'); ?></option>
                <option <?php echo set_select('year', "2027"); ?> value="2027"><?php echo lang('2027s'); ?></option>
                <option <?php echo set_select('year', "2028"); ?> value="2028"><?php echo lang('2028s'); ?></option>
                <option <?php echo set_select('year', "2029"); ?> value="2029"><?php echo lang('2029s'); ?></option>
                <option <?php echo set_select('year', "2030"); ?> value="2030"><?php echo lang('2030s'); ?></option>
                <option <?php echo set_select('year', "2031"); ?> value="2031"><?php echo lang('2031s'); ?></option>
                <option <?php echo set_select('year', "2032"); ?> value="2032"><?php echo lang('2032s'); ?></option>
                <option <?php echo set_select('year', "2033"); ?> value="2033"><?php echo lang('2033s'); ?></option>
              </select>
              <?php if (form_error('year')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <span class="error_paragraph"><?php echo form_error('year'); ?></span>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-2">
            <br>
            <input type="submit" name="submit" value="<?php echo lang('submit'); ?>" class="btn btn-primary">
          </div>
          <?php echo form_close(); ?>
        </div>

        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('salary'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_23_p"><?php echo lang('month'); ?> - <?php echo lang('year'); ?></th>
              <th class="width_10_p"><?php echo lang('total'); ?></th>
              <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($salaries && !empty($salaries)) {
              $i = count($salaries);
            }
            foreach ($salaries as $usrs) {
              ?>
              <tr>
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($usrs->month); ?> - <?php echo escape_output($usrs->year); ?></td>
                <td><?php echo escape_output($this->session->userdata('currency')) ?><?php echo escape_output($usrs->total_amount); ?></td>

                <th class="c_center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                      <li>
                        <a class="printNow" data-id="<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"
                           href="#"><i class="fa fa-print"></i><?php echo lang('print'); ?></a>
                      </li>
                      <li>
                        <a href="<?php echo base_url() ?>salary/addEditSalary/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i
                              class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                      </li>
                      <li>
                        <a class="delete"
                           href="<?php echo base_url() ?>salary/deleteSalary/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i
                              class="fa fa-trash"></i><?php echo lang('delete'); ?></a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              <?php
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_23_p"><?php echo lang('month'); ?> - <?php echo lang('year'); ?></th>
              <th class="width_10_p"><?php echo lang('total'); ?></th>
              <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.print.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatable_custom/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.dataTables.min.css">
<script src="<?php echo base_url(); ?>assets/js/custom_report.js"></script>
<script src="<?php echo base_url(); ?>assets/js/print_salary.js"></script>

