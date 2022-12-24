<?php
//site setting
$getSiteSetting =  getSiteSetting();

$currency = "$";
if(isset($getSiteSetting->currency) && $getSiteSetting->currency){
    $currency = $getSiteSetting->currency;
}
//default base color
$base_color = "#6ab04c";
if(isset($getSiteSetting->base_color) && $getSiteSetting->base_color){
    $base_color = $getSiteSetting->base_color;
}
?>

<!--hidden filed use in javascript-->
<input type="hidden" class="currency" value="<?php echo escape_output($this->session->userdata('currency')) ?>">
<input type="hidden" class="delivered_order" value="<?php echo lang('delivered_order')?>">
<input type="hidden" class="new_order" value="<?php echo lang('new_order')?>">
<input type="hidden" class="cancelled_order" value="<?php echo lang('cancelled_order')?>">
<input type="hidden" class="delivered_order_value" value="<?php echo isset($sale_online_sum_delivered->sale_sum) && $sale_online_sum_delivered->sale_sum?$sale_online_sum_delivered->sale_sum:'0'; ?>">
<input type="hidden" class="new_order_value" value="<?php echo isset($sale_online_sum_new->sale_sum) && $sale_online_sum_new->sale_sum?$sale_online_sum_new->sale_sum:'0'; ?>">
<input type="hidden" class="cancelled_order_value" value="<?php echo isset($sale_online_sum_cancel->sale_sum) && $sale_online_sum_cancel->sale_sum?$sale_online_sum_cancel->sale_sum:'0'; ?>">
<input type="hidden" class="purchase_value" value="<?php echo escape_output($purchase_sum->purchase_sum); ?>">
<input type="hidden" class="salary_value" value="<?php echo escape_output($salary_sum->salary_sum); ?>">
<input type="hidden" class="Deposit_value" value="<?php echo escape_output($deposit_sum->deposit_sum); ?>">
<input type="hidden" class="Withdraw_value" value="<?php echo escape_output($withdraw_sum->withdraw_sum); ?>">
<input type="hidden" class="damage_value" value="<?php echo escape_output($waste_sum->waste_sum); ?>">
<input type="hidden" class="expense_value" value="<?php echo escape_output($expense_sum->expense_sum); ?>">
<input type="hidden" class="supp_pay_value" value="<?php echo escape_output($supplier_due_payment_sum->supplier_due_payment_sum); ?>">
<input type="hidden" class="base_color" value="<?php echo escape_output($base_color) ?>">
<input type="hidden" class="purchase_" value="<?php echo lang('purchase')?>">
<input type="hidden" class="salary_" value="<?php echo lang('salary')?>">
<input type="hidden" class="Deposit_" value="<?php echo lang('Deposit')?>">
<input type="hidden" class="Withdraw_" value="<?php echo lang('Withdraw')?>">
<input type="hidden" class="damage_" value="<?php echo lang('damage')?>">
<input type="hidden" class="expense_" value="<?php echo lang('expense')?>">
<input type="hidden" class="supp_pay_" value="<?php echo lang('supp_pay')?>">

    <!-- bootstrap datepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/local/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/local/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/local/daterangepicker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/user_home.css">

<style type="text/css">
  .todo-title{
      background-color: <?php echo escape_output($base_color)?> !important;
      color: white !important;
      border-left-color: <?php echo escape_output($base_color)?> !important;
  }
  /* end 5 */
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo lang('dashboard'); ?>
        <small><?php echo lang('business_intelligence'); ?></small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box box4column">
            <div class="inner"  style="color: <?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>">
              <h3><?php echo escape_output($total_unorder_order) ?></h3>

              <p><?php echo lang('UndeliveredOrders'); ?></p>
            </div>
            <div class="icon">
              <i style="color:<?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>"  class="fa fa-shopping-cart"></i>
            </div>
            <a href="<?php echo base_url(); ?>orderManagement/orders" class="small-box-footer"><?php echo lang('manage'); ?>
              <i data-feather="arrow-right-circle"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box box4column">
            <div class="inner"  style="color: <?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>">
              <h3><?php echo escape_output($total_order->data_count); ?></h3>

              <p><?php echo lang('TotalOrders'); ?></p>
            </div>
            <div class="icon">
              <i style="color:<?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>"  class="fa fa-shopping-cart"></i>
            </div>
            <a href="<?php echo base_url(); ?>orderManagement/orders" class="small-box-footer"><?php echo lang('manage'); ?>
            <i data-feather="arrow-right-circle"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box box4column">
            <div class="inner" style="color: <?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>">
              <h3><?php echo escape_output($customer_count->data_count); ?></h3>

              <p><?php echo lang('customers'); ?></p>
            </div>
            <div class="icon">
              <i style="color:<?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>" class="fa fa-users"></i>
            </div>
            <a href="<?php echo base_url(); ?>Customer/customers" class="small-box-footer"><?php echo lang('manage'); ?>
            <i data-feather="arrow-right-circle"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box box4column">
            <div class="inner" style="color: <?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>">
              <h3><?php echo escape_output($item_count->data_count); ?></h3>

              <p><?php echo lang('products'); ?></p>
            </div>
            <div class="icon">
              <i style="color:<?php echo escape_output($getSiteSetting->base_color); ?>;border-color:<?php echo escape_output($getSiteSetting->base_color); ?>"  class="fa fa-list"></i>
            </div>
            <a href="<?php echo base_url(); ?>Item/products" class="small-box-footer"><?php echo lang('manage'); ?>
            <i data-feather="arrow-right-circle"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <!-- quick email widget -->
      <div class="row">
        <div class="col-lg-6">
          <div class="box box-info">
          <div class="box-header">
            <i class="fa fa-link"></i>
            <h3 class="box-title"><?php echo lang('quick_links'); ?></h3>
          </div>
          <div class="box-body quick-links txt-uh-90">

            <div class="b">
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>orderManagement/orders"><span class="fa fa-dollar text-info"></span> <?php echo lang('orders'); ?></a>
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>Inventory/inventory"><span class="fa fa-cube text-info"></span><?php echo lang('inventory'); ?></a>
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>Expense/addEditExpense"><span class="fa fa-money text-info"></span>+ <?php echo lang('expense'); ?></a>
            </div>

            <div class="b">
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>Item/addEditItem"><span class="fa fa-book text-info"></span>+ <?php echo lang('add_product'); ?></a>
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>SupplierPayment/addSupplierPayment"><span class="fa fa-user text-info"></span>+ <?php echo lang('supplier_payment'); ?></a>
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>Report/balanceSheet"><span class="fa fa-dollar text-info"></span> <?php echo lang('BalanceSheet'); ?></a>
            </div>

            <div class="b">
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>Report/dailySummaryReport"><span class="fa fa-list text-info"></span><?php echo lang('daily_summary_report'); ?></a>
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>Purchase/addEditPurchase"><span class="fa fa-truck text-info"></span>+ <?php echo lang('purchase'); ?></a>
                <a class="btn icon-btn btn-info" href="<?php echo base_url(); ?>Attendance/addEditAttendance"><span class="fa fa-clock-o text-info"></span>+ <?php echo lang('attendance'); ?></a>
            </div>

          </div>
        </div>
        </div>

        <div class="col-lg-6">
          <div class="box box-info">
          <div class="box-header">
            <i class="fa fa-shopping-bag"></i>
            <h3 class="box-title"><?php echo lang('OrderThisMonth'); ?></h3>
          </div>
          <div class="box-body">
            <div class="chart-responsive txt-uh-91">
                <canvas id="pieChart" class="txt-uh-91"></canvas>
            </div>
          </div>
        </div>
        </div>
      </div>


      <div class="row">

        <div class="col-lg-12">
            <div class="box box-info">
              <div class="box-header">
                <i class="fa fa-truck"></i>
                <h3 class="box-title"><?php echo lang('operational_comparision'); ?>(<?php echo lang('this_month'); ?>)</h3>
              </div>
              <div class="box-body txt-uh-92">
                  <div class="chart">
                    <div class="chart  txt-uh-93" id="operational_comparision"></div>
                  </div>
              </div>
            </div>
        </div>


    
      </div>


      <div class="row">
          <div class="col-lg-6">
              <div class="box box-info">
                  <div class="box-header">
                      <i class="fa fa-shopping-cart"></i>
                      <h3 class="box-title"><?php echo lang('products_alert'); ?>/<?php echo lang('low_stock'); ?> <span class="txt-uh-51">(<?php echo getAlertCount() ?>)</span> </h3>
                  </div>
                  <div class="box-body txt-uh-92">
                      <ul class="todo-list">
                          <li class="todo-title">
                              <span class="text txt-uh-31"><?php echo lang('product_name'); ?></span>
                              <div class="txt-uh-94">
                                  <span><?php echo lang('current_stock'); ?></span>
                              </div>
                          </li>
                      </ul>
                      <ul class="todo-list txt-uh-95" id="top_ten_food_menu">
                          <?php
                          $totalStock = 0;
                          $grandTotal = 0;
                          $alertCount = 0;
                          $totalTK = 0;
                          $totalStockPurchase = 0;
                          if (!empty($low_stock_products) && isset($low_stock_products)):
                              foreach ($low_stock_products as $key => $value):

                                  $totalStock = $value->opening_stock + ($value->total_purchase*$value->conversion_rate)  - $value->total_damage;
                                  $totalTK = $totalStock * getLastPurchaseAmount($value->id);
                                  if ($totalStock >= 0) {
                                      $grandTotal = $grandTotal + $totalStock * getLastPurchaseAmount($value->id);
                                  }
                                  $key++;
                                  $totalStockPurchase = isset($value->conversion_rate) && (int)$value->conversion_rate?(int)($totalStock/$value->conversion_rate):'0';
                                  if ($totalStock <= $value->alert_quantity):
                                      ?>
                                      <li>
                                          <span class="text"><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></span>
                                          <div class="txt-uh-99">
                                              <span><?php echo ($totalStock) && $totalStock>0? $totalStock : '0.0' ?><?php echo " " . isset($value->sale_unit_name) && $value->sale_unit_name?$value->sale_unit_name:'' ?></span>
                                          </div>
                                      </li>
                                      <?php
                                  endif;
                              endforeach;
                          endif;
                          ?>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="col-lg-6">
              <div class="box box-info">
                  <div class="box-header">
                      <i class="fa fa-money"></i>
                      <h3 class="box-title"><?php echo lang('payment_methods'); ?></h3>
                  </div>
                  <div class="box-body">
                      <ul class="todo-list">
                          <li class="todo-title">
                              <div class="txt-uh-98">
                                  <span><?php echo lang('sn'); ?></span>
                              </div>
                              <span class="text txt-uh-31"><?php echo lang('account_name'); ?></span>
                              <div class="txt-uh-94">
                                  <span><?php echo lang('balance'); ?></span>
                              </div>
                          </li>
                      </ul>
                      <ul class="todo-list" id="customer_receivable txt-uh-95">
                          <?php
                          if ($paymentMethods && !empty($paymentMethods)) {
                              foreach ($paymentMethods as $key => $value) {
                                  $balance=0;
                                  $balance =$value->current_balance-$value->total_purchase-$value->total_supplier_due_payment+$value->total_deposit-$value->total_withdraw-$value->total_expense;
                                  $key++;

                                  ?>
                                  <li>
                                      <div class="txt-uh-96">
                                          <span><?php echo escape_output($key) ?></span>
                                      </div>
                                      <span class="text"><?php echo escape_output($value->name) ?> </span>
                                      <div class="txt-uh-97">
                                          <span><?php echo escape_output($this->session->userdata('currency')." "). $balance ?></span>
                                      </div>
                                  </li>
                              <?php  }  } ?>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-shopping-cart"></i>
                        <h3 class="box-title"><?php echo lang('top_ten_food_this_month'); ?></h3>
                    </div>
                    <div class="box-body txt-uh-92">
                        <ul class="todo-list">
                            <li class="todo-title">
                                <div class="txt-uh-98">
                                    <span><?php echo lang('sn'); ?></span>
                                </div>
                                <span class="text txt-uh-31"><?php echo lang('food_name'); ?></span>
                                <div class="txt-uh-94">
                                    <span><?php echo lang('count'); ?></span>
                                </div>
                            </li>
                        </ul>
                        <ul class="todo-list txt-uh-95" id="top_ten_food_menu">
                            <?php
                            if ($top_ten_food_menu && !empty($top_ten_food_menu)) {
                                foreach ($top_ten_food_menu as $key => $value) {
                                    $key++;
                                    ?>
                                    <li>
                                        <div class="txt-uh-96">
                                            <span><?php echo escape_output($key) ?></span>
                                        </div>
                                        <span class="text"><?php echo escape_output($value->menu_name) ?></span>
                                        <div class="txt-uh-97">
                                            <span><?php echo escape_output($value->totalQty) ?></span>
                                        </div>
                                    </li>
                                <?php } } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-shopping-cart"></i>
                        <h3 class="box-title"><?php echo lang('to_ten_p_this_month'); ?></h3>
                    </div>
                    <div class="box-body txt-uh-92">
                        <ul class="todo-list">
                            <li class="todo-title">
                                <div class="txt-uh-98">
                                    <span><?php echo lang('sn'); ?></span>
                                </div>
                                <span class="text txt-uh-31"><?php echo lang('food_name'); ?></span>
                                <div class="txt-uh-94">
                                    <span><?php echo lang('count'); ?></span>
                                </div>
                            </li>
                        </ul>
                        <ul class="todo-list txt-uh-95" id="top_ten_food_menu">
                            <?php
                            if ($top_ten_food_menu_purchase && !empty($top_ten_food_menu_purchase)) {
                                foreach ($top_ten_food_menu_purchase as $key => $value) {
                                    $key++;
                                    ?>
                                    <li>
                                        <div class="txt-uh-96">
                                            <span><?php echo escape_output($key) ?></span>
                                        </div>
                                        <span class="text"><?php echo escape_output($value->menu_name) ?></span>
                                        <div class="txt-uh-97">
                                            <span><?php echo escape_output($value->totalQty) ?></span>
                                        </div>
                                    </li>
                                <?php } } ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

      <div class="row">

          <div class="col-lg-6">
              <div class="box box-info">
                  <div class="box-header">
                      <i class="fa fa-users"></i>
                      <h3 class="box-title"><?php echo lang('top_ten_customers'); ?></h3>
                  </div>
                  <div class="box-body txt-uh-92">
                      <ul class="todo-list">
                          <li class="todo-title">
                              <div class="txt-uh-98">
                                  <span><?php echo lang('sn'); ?></span>
                              </div>
                              <span class="text txt-uh-31"><?php echo lang('customer_name'); ?></span>
                              <div class="txt-uh-94">
                                  <span><?php echo lang('sale_amount'); ?></span>
                              </div>
                          </li>
                      </ul>
                      <ul class="todo-list" id="top_ten_customer">
                          <?php
                          if ($top_ten_customer && !empty($top_ten_customer)) {
                              foreach ($top_ten_customer as $key => $value) {
                                  $key++;
                                  ?>
                                  <li>
                                      <div class="txt-uh-96">
                                          <span><?php echo escape_output($key) ?></span>
                                      </div>
                                      <span class="text"><?php echo escape_output($value->name) ?></span>
                                      <div class="txt-uh-97">
                                          <span><?php echo escape_output($this->session->userdata('currency')." "). $value->total_payable ?></span>
                                      </div>
                                  </li>
                              <?php } } ?>
                      </ul>
                  </div>
              </div>
          </div>
        <div class="col-lg-6">
          <div class="box box-info">
          <div class="box-header">
            <i class="fa fa-money"></i>
            <h3 class="box-title"><?php echo lang('supplier_payable'); ?></h3>
          </div>
          <div class="box-body">
            <ul class="todo-list">
              <li class="todo-title">
                <div class="txt-uh-98">
                    <span><?php echo lang('sn'); ?></span>
                </div>
                <span class="text txt-uh-31"><?php echo lang('supplier_name'); ?></span>
                <div class="txt-uh-94">
                  <span><?php echo lang('due_amount'); ?></span>
                </div>
              </li>
            </ul>
            <ul class="todo-list txt-uh-95" id="supplier_payable">
            <?php
                if ($supplier_payable && !empty($supplier_payable)) {
                foreach ($supplier_payable as $key => $value) {
                  $key++;
                  if($value->due != '0.00' && $value->due != ''){
                    ?>
                    <li>
                      <div class="txt-uh-96">
                        <span><?php echo escape_output($key) ?></span>
                      </div>
                      <span class="text"><?php echo escape_output($value->name) ?></span>
                      <div class="txt-uh-97">
                        <?php $current_due = $value->due - getSupplierDuePayment($value->supplier_id); ?>
                        <span><?php echo escape_output($this->session->userdata('currency')." "). $current_due ?></span>
                      </div>
                    </li>
              <?php } }  } ?>
              </ul>
          </div>
        </div>
        </div>
      </div>


      

      <div class="row">
        <div class="col-lg-12">
          <div class="box box-info">
          <div class="box-header">
            <i class="fa fa-shopping-bag"></i>
            <h3 class="box-title"><?php echo lang('monthly_order_comparision'); ?></h3>
          </div>
          <div class="box-body">
              <div class="chart">
                <div id="chart_div" class="width_100_p txt-uh-90"></div>
              </div>
          </div>
        </div>
        </div>
      </div>
</section>

<!-- bootstrap datepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/bower_components/chart.js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/local/loader.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.css">
<script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.cookie.js"></script>