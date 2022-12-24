<?php

$order = isset($order) ? $order : json_decode([]);
$areas = isset($areas) ? $areas : [];

?>

<form id="quickOrderEditForm">

    <input type="hidden" name="id" value="<?= $order->id ?>">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="deliveryDate">Delivery Date</label>
              <?php
              $delivery_date = $order->delivery_date ? date('Y-m-d', strtotime($order->delivery_date)) : '';
              ?>
                <input type="text" name="delivery_date" class="form-control customDatepicker" id="deliveryDate"
                       value="<?= $delivery_date ?>" placeholder="YYYY-MM-DD">
            </div>
        </div> <!-- col-sm-6 -->
        <div class="col-sm-6">
            <div class="form-group">
                <label for="deliveryTime">Delivery Time</label>
              <?php
              $delivery_time = $order->delivery_time ? date('h:ia', strtotime($order->delivery_time)) : '';
              ?>
                <input type="text" name="delivery_time" class="form-control customTimePicker" id="deliveryTime"
                       value="<?= $delivery_time ?>" placeholder="hh:mm A">
            </div>
        </div> <!-- col-sm-6 -->
    </div> <!-- row -->


    <fieldset>
        <legend>Shipping Address</legend>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="checkout_name" class="form-control" id="name" value="<?= $order->checkout_name ?>"
                   placeholder="Name">
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="phone_one">Phone One</label>
                    <input type="text" name="checkout_phone" class="form-control" id="phone_one"
                           value="<?= $order->checkout_phone ?>" placeholder="Phone One">
                </div>
            </div> <!-- col-sm-6 -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="phone_two">Phone Two</label>
                    <input type="text" name="checkout_email" class="form-control" id="phone_two"
                           value="<?= $order->checkout_email ?>" placeholder="Phone Two">
                </div>
            </div> <!-- col-sm-6 -->
        </div> <!-- row -->

        <div class="form-group">
            <label for="area">Area</label>
            <select name="area" class="form-control select2" id="area">
              <?php
              $orderArea = $order->area;
              $areaOption = '';
              foreach ($areas as $area) {
                $selected = strtolower($orderArea) == strtolower($area->name) ? 'selected' : '';
                $areaOption .= '<option value="' . ucfirst($area->name) . '" ' . $selected . '>' . ucfirst($area->name) . '</option>';
              }
              echo $areaOption;
              ?>
            </select>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea type="text" name="address" class="form-control" id="address" rows="4"
                      placeholder="Address"><?= $order->address ?></textarea>
        </div>

    </fieldset>

    <div class="form-group">
        <button type="submit" class="btn btn-default">Update</button>
    </div>
</form>