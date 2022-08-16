<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">


<span id="single_page_name" class="d-none">myOrders</span>




<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="col-md-12">
      <ol class="breadcrumb justify-content-start">
        <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
        <li class="breadcrumb-item active">My orders</li>
      </ol>
    </div>
  </div>
</div>


<div class="main_content">
  <div class="custom-container pb-5">

    <div class="card">
      <div class="card-body table-responsive">
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th scope="col" class="text-center"><?= lang('sn'); ?></th>
              <th scope="col" class="text-center">OrderNo.</th>
              <th scope="col" class="text-center">Unit</th>
              <th scope="col" class="text-center">
                <?= lang('total') ?>
                <span class=" ml-1" data-container="body" data-toggle="popover" data-content="<?= lang('inc_d_tax'); ?>">
                  <i class="fas fa-question-circle"></i>
                </span>
              </th>
              <th scope="col" class="text-center">Date</th>
              <th scope="col" class="text-center"><?= lang('Status'); ?></th>
              <th scope="col" class="text-center"><?php echo lang('actions'); ?>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($orders && !empty($orders)) {
              $i = count($orders);
            }
            foreach ($orders as $value) :
            ?>
              <tr>
                <td class="txt-18 text-center" scope="row"><?= ($i--)  ?></td>
                <td class="txt-18 text-center"><?= $value->order_number ?></td>
                <td class="txt-18 text-center"><?= sizeof($value->items) ?></td>
                <td class="txt-18 text-center"><?= floating($value->total_amount) ?></td>
                <td class="txt-18 text-center"><?= (date("d/m/Y h:sa", strtotime($value->order_date_time)))  ?></td>
                <td class="txt-18 text-center set_text_status<?= $value->id ?>"><?= $value->status ?></td>
                <td class="txt-18 text-center">
                  <?php
                  $current = date('Y-m-d H:i:s');
                  $orderDate = date('Y-m-d H:i:s', strtotime($value->order_date_time) + (60 * 60));
                  if ($value->status != 'New') {
                    $disable = 'uk-tooltip="Cancel Not Available" disabled';
                  } elseif ($value->status == 'New' && (strtotime($orderDate) < strtotime($current))) {
                    $disable = 'uk-tooltip="Cancel Order"';
                  } else {
                    $disable = 'uk-tooltip="title: Order cancel after ' . date('h:ia', strtotime($orderDate)) . ' " disabled';
                  }
                  ?>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-primary showInfo" data-id="<?= $value->id ?>" uk-tooltip="View Order">
                      view
                    </button>
                    <button class="btn btn-danger cancel_order" data-id="<?= $value->id ?>" <?= $disable ?>>
                      Cancel
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>
    </div>

  </div>
</div>




<div class="modal fade" id="showOrderModal" tabindex="-1" role="dialog" aria-labelledby="showOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="showOrderModalLabel">Order details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center">Sl</th>
              <th>Product</th>
              <th class="text-center">Price</th>
              <th class="text-center">Quantity</th>
            </tr>
          </thead>
          <tbody class="order_details_body"></tbody>

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>