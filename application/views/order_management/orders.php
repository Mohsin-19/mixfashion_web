<!--hidden filed use in javascript-->
<input type="hidden" class="somethingiswrong" value="<?php echo lang('somethingiswrong'); ?>">


<?php
if ($this->session->flashdata('exception')) {
  echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
  echo escape_output($this->session->flashdata('exception'));
  echo '</p></div></section>';
}
$getSiteSetting = getSiteSetting();
$currency = "$";
if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
  $currency = $getSiteSetting->currency;
}
?>

<section class="content-header">
  <div class="row">
    <div class="col-md-1">
      <h2 class="top-left-header"><?php echo lang('orders'); ?> </h2>
    </div>
    <?php echo form_open(base_url() . 'orderManagement/orders') ?>
    <div class="col-md-2">
      <?php
      $old_date = set_value('date');
      ?>
      <input type="text" name="date" id="" class="form-control customDatepicker" value="<?php echo isset($old_date) && $old_date ? $old_date : date("Y-m-d", strtotime('today')) ?>">
    </div>
    <div class="col-md-2">
      <?php
      $old_date = set_value('date');
      ?>
      <input type="text" name="phone" id="" placeholder="Customer Phone" class="form-control" value="<?php echo set_value('phone') ?>">
    </div>
    <div class="col-md-2">
      <select class="form-control select2 width_100_p" name="area">
        <option value=""><?php echo lang('Area'); ?></option>
        <?php foreach ($areas as $value) : ?>
          <option <?php echo set_select('area', $value->name); ?> value="<?php echo escape_output($value->name); ?>"><?php echo escape_output($value->name); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2">
      <select class="form-control select2 width_100_p" name="status">
        <option value="">Status</option>
        <?php if (has_permission('show_new')) : ?>
          <option value="New"><?php echo lang('New'); ?></option>
        <?php endif; ?>
        <?php if (has_permission('show_process')) : ?>
          <option value="In Progress"><?php echo lang('InProgress'); ?></option>
        <?php endif; ?>
        <?php if (has_permission('show_dispatch')) : ?>
          <option value="Dispatch"><?php echo lang('dispatch'); ?></option>
        <?php endif; ?>
        <?php if (has_permission('show_complete')) : ?>
          <option value="Delivered"><?php echo lang('Delivered'); ?></option>
        <?php endif; ?>
        <?php if (has_permission('show_return')) : ?>
          <option value="Return"><?php echo lang('Return'); ?></option>
        <?php endif; ?>
        <?php if (has_permission('show_cancel')) : ?>
          <option value="Cancel"><?php echo lang('cancel'); ?></option>
        <?php endif; ?>
      </select>
    </div>
    <div class="col-md-1">
      <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
    </div>
    <?php echo form_close(); ?>

    <?php if (has_permission('product_purchase')) : ?>
      <div class="col-md-2">
        <a href="<?= site_url('orderManagement/productPurchase') ?>" class="btn btn-block btn-primary pull-left"><?= lang('ProducttoPurchase'); ?></a>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->

        <?php
        $has_permission = has_permission(['print_invoice', 'view_invoice', 'quick_edit_invoice', 'print_package_slip', 'process_order', 'dispatch_order', 'complete_order', 'return_order', 'cancel_order', 'assign_delivery', 'add_note']);
        $print_invoice = has_permission('print_invoice');
        $view_invoice = has_permission('view_invoice');
        $quick_edit = has_permission('quick_edit_invoice');
        $print_package_slip = has_permission('print_package_slip');
        $processing_order = has_permission(['process_order', 'dispatch_order', 'complete_order', 'return_order', 'cancel_order']);
        $assign_delivery = has_permission('assign_delivery');
        $add_note = has_permission('add_note');
        ?>
        <div class="box-header">
          <div class="row">
            <div class="col-sm-6">
              <a href="<?= site_url('orderManagement/printAll') ?>" class="btn btn-primary"> <?= lang('print'); ?> </a>
            </div> <!-- col -->
          </div> <!-- row -->
        </div>
        <div class="box-body table-responsive">

          <p class="txt-uh-60">&nbsp;</p>
          <div class="clearfix"></div>

          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th scope="col"><?= lang('sn'); ?></th>
                <th scope="col">OrderNo</th>
                <th scope="col">OrderArea</th>
                <th scope="col" style="min-width: 70px;">OrderDate</th>
                <th scope="col uk-text-center" style="min-width: 70px;">OrderTime</th>
                <th scope="col" style="min-width: 85px;">DeliveryDate</th>
                <th scope="col" style="min-width: 90px;">DeliveryTime</th>
                <th scope="col" style="min-width: 100px;">CustomerName</th>
                <th scope="col" style="min-width: 100px;">ShippingName</th>
                <th scope="col" class="text-center width_1_p"><?= lang('payment'); ?></th>
                <th scope="col" class="text-center width_1_p" style="min-width: 70px;"><?= lang('status'); ?></th>
                <th scope="col" class="text-center" style="min-width: 75px;">statusTime</th>
                <th scope="col"><?= lang('note'); ?></th>
                <?php if ($has_permission) : ?>
                  <th scope="col" class="width_1_p not-export-col"><?= lang('actions'); ?></th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($orders && !empty($orders)) {
                $i = count($orders);
              }
              foreach ($orders as $value) :
                $order_id = $value->id;
              ?>
                <tr>
                  <td class="txt-uh-41" scope="row"><?= $i-- ?></td>
                  <td class="txt-uh-41"><?= $value->order_number ?></td>
                  <td class="txt-uh-41 order-area-<?= $order_id ?>"><?= $value->area ?></td>
                  <td class="txt-uh-41"><?= date("d-m-Y", strtotime($value->order_date_time)) ?></td>
                  <td class="txt-uh-41"><?= date("h:ia", strtotime($value->order_date_time)) ?></td>
                  <td class="txt-uh-41 delivery-date-<?= $order_id ?>">
                    <?= $value->delivery_date ? date("d-m-Y", strtotime($value->delivery_date)) : '<b class="text-danger">Not Set</b>' ?>
                  </td>
                  <td class="txt-uh-41 delivery-time-<?= $order_id ?>">
                    <?= $value->delivery_time ? $value->delivery_time : '<b class="text-danger">Not Set</b>' ?>
                  </td>
                  <td class="txt-uh-41 customer-name-<?= $order_id ?>">
                    <?= $value->customer_name ? $value->customer_name : '<b class="text-danger">Not Found</b>' ?>
                  </td>
                  <td class="txt-uh-41 checkout-name-<?= $order_id ?>">
                    <?= $value->checkout_name ? $value->checkout_name : '<b class="text-danger">Not Found</b>' ?>
                  </td>
                  <td class="txt-uh-41 text-bold text-center">
                    <?php
                    if ($value->paymentName == 'Cash On Delivery') {
                      echo 'COD';
                    } elseif ($value->paymentName == 'SSLCOMMERZ') {
                      echo '<b class="text-success" title="' . $value->paymentName . '">Online</b>';
                    } else {
                      echo $value->paymentName;
                    }
                    ?>
                  </td>
                  <td class=" txt-uh-41 set_text_status<?= $order_id ?> text-center ">

                    <?php
                    if ($value->status == "New" && $value->del_status == "Deleted") {
                      echo '<b class="text-danger">Incomplete</b>';
                    } else {
                      echo $value->status;
                    }

                    ?>
                  </td>
                  <td class=" txt-uh-41 set_text_time<?= $order_id ?> text-center"><?= date('h:ia', strtotime($value->updated_at)) ?></td>
                  <td class=" txt-uh-41 text-center set_text_note<?= $order_id ?>">
                    <button type="button" class="btn text-aqua" style="background: transparent;" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="left" data-title="Note Info" data-content="<?= $value->note ? $value->note : 'No note' ?>">
                      <i class="fa fa-info-circle"></i>
                    </button>
                  </td>
                  <?php if ($has_permission) : ?>
                    <td class="txt-uh-41">
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">

                          <?php if ($value->status == "New" && $value->del_status == "Deleted") : ?>
                            <li>
                              <a class="btn_mark_complete" href="<?= site_url('admin/ajax/order-mark-complete/' . $order_id) ?>">Mark Complete</a>
                            </li>
                          <?php endif; ?>

                          <?php if ($print_invoice) : ?>
                            <li>
                              <a class="action_btn" id="1action_btn_<?php echo escape_output($value->id); ?>" data-id="<?php echo escape_output($value->id); ?>" data-status="1" data-status_value="<?php echo escape_output($value->status); ?>" href="#"><?= lang('print_invoice'); ?></a>
                            </li>
                          <?php endif; ?>

                          <?php if ($quick_edit) : ?>
                            <li>
                              <a class="action_btn editOrderInformation" href="<?= $value->id ?>">Quick Edit</a>
                            </li>
                          <?php endif; ?>

                          <?php if ($print_package_slip) : ?>
                            <li>
                              <a class="action_btn" id="5action_btn_<?= escape_output($value->id); ?>" data-id="<?= escape_output($value->id); ?>" data-status="5" data-status_value="<?= escape_output($value->status); ?>" href="#"><?= lang('Packing Slip'); ?></a>
                            </li>
                          <?php endif; ?>
                          <?php if ($processing_order) : ?>
                            <li>
                              <a class="action_btn" id="action_btn_<?php echo escape_output($value->id); ?>" data-id="<?php echo escape_output($value->id); ?>" data-status="2" data-status_value="<?php echo escape_output($value->status); ?>" href="#"><?php echo lang('ChangeStatus'); ?></a>
                            </li>
                          <?php endif; ?>
                          <?php if ($assign_delivery) : ?>
                            <li>
                              <a class="action_btn" id="2action_btn_<?= escape_output($value->id); ?>" data-id="<?= escape_output($value->id); ?>" data-status="3" data-status_value="<?php echo escape_output($value->delivery_person_id); ?>" href="#"><?= lang('AssignDeliveryPerson'); ?></a>
                            </li>
                          <?php endif; ?>
                          <?php if ($add_note) : ?>
                            <li>
                              <a class="action_btn" id="3action_btn_<?php echo escape_output($value->id); ?>" data-id="<?php echo escape_output($value->id); ?>" data-status="4" data-status_value="<?php echo escape_output($value->note); ?>" href="#">Add Note</a>
                            </li>
                          <?php endif; ?>

                        </ul>
                      </div>
                    </td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th scope="col"><?= lang('sn'); ?></th>
                <th scope="col">OrderNo</th>
                <th scope="col">OrderArea</th>
                <th scope="col">OrderDate</th>
                <th scope="col">OrderTime</th>
                <th scope="col">DeliveryDate</th>
                <th scope="col">DeliveryTime</th>
                <th scope="col">CustomerName</th>
                <th scope="col">ShippingName</th>
                <th scope="col">Payment</th>
                <th scope="col"><?= lang('status'); ?></th>
                <th scope="col" class="text-center">statusTime</th>
                <th scope="col" class="text-center"><?= lang('note'); ?></th>
                <?php if ($has_permission) : ?>
                  <th scope="col" class="not-export-col"><?php echo lang('actions'); ?></th>
                <?php endif; ?>
              </tr>
            </tfoot>
          </table>


        </div> <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>

<input type="hidden" id="status_change_id" name="status_change_id" value="">

<div class="modal fade" id="change_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body">
        <form class="">
          <div class="col-md-12">
            <div class="form-group">
              <label><?php echo lang('status'); ?></label>
              <select class="form-control" name="status_f" id="status_f">
                <?php if (has_permission('new_order')) : ?>
                  <option value="New"><?php echo lang('New'); ?></option>
                <?php endif; ?>
                <?php if (has_permission('process_order')) : ?>
                  <option value="In Progress"><?php echo lang('InProgress'); ?></option>
                <?php endif; ?>
                <?php if (has_permission('dispatch_order')) : ?>
                  <option value="Dispatch"><?php echo lang('dispatch'); ?></option>
                <?php endif; ?>
                <?php if (has_permission('complete_order')) : ?>
                  <option value="Delivered"><?php echo lang('Delivered'); ?></option>
                <?php endif; ?>
                <?php if (has_permission('return_order')) : ?>
                  <option value="Return"><?php echo lang('Return'); ?></option>
                <?php endif; ?>
                <?php if (has_permission('cancel_order')) : ?>
                  <option value="Cancel"><?php echo lang('cancel'); ?></option>
                <?php endif; ?>
              </select>

              <div class="alert alert-error show_msg txt-uh-61">
                <p class="msg_p"></p>
              </div>
            </div>

          </div>
        </form>
        <p>&nbsp;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="change_status_add">
          <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="assign_delivery_person" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body">
        <form class="">
          <div class="col-md-12">
            <div class="form-group">
              <label><?php echo lang('DeliveryPerson'); ?></label>
              <select class="form-control select2 width_100_p" name="employee_id" id="employee_id">
                <option value=""><?php echo lang('select'); ?></option>
                <?php
                foreach ($employees as $value) :
                  if ($value->id != 1) :
                ?>
                    <option value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?></option>
                <?php
                  endif;
                endforeach;
                ?>
              </select>
            </div>

          </div>
        </form>
        <p>&nbsp;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="assign_delivery_person_add">
          <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="note_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body">
        <form class="">
          <div class="col-md-12">
            <div class="form-group">
              <label><?php echo lang('note'); ?></label>
              <textarea id="note" name="note" class="form-control"></textarea>
            </div>

          </div>
        </form>
        <p>&nbsp;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="note_add">
          <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="order_edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title">Quick Edit Information </h4>
      </div>
      <div class="modal-body">
        <!-- html data append here -->
      </div> <!-- modal-body -->
    </div>
  </div>
</div>


<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
<script src="<?= base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/orders.js'); ?>"></script>