<?php
$default_address = isset($default_address) ? $default_address : null;

if (count($address)) :

  foreach ($address as $key => $item) :
    if ($default_address == $item->id) {
      $border = 'border: 1px solid #fdb813';
      $class = 'selectAddress';
      $hasDefault = true;
    } else {
      $border = '';
      $class = '';
      $hasDefault = false;
    }

    ?>
    <div class="card mb-3 position-relative <?= $class ?>" style="<?= $border ?>">

      <div class="card-body">
        <input type="hidden" class="address_id" value="<?= $item->id ?>">
        <div class="clearfix">
          <div class="float-left">
            Address <?= $key + 1 ?>
          </div>
          <div class="float-right btn-group btn-group-sm">
            <button type="button" class="editAddressForm btn btn-info" data-toggle="tooltip" title="edit"
                    data-id="<?= $item->id ?>" data-customer="<?= $item->customer_id ?>">
              <i class="fas fa-edit"></i>
            </button>
            <?php if ($hasDefault) : ?>
              <button type="button" class="deleteAddressForm btn btn-danger" data-toggle="tooltip" title="Can't Delete Default" disabled="">
                <i class="fas fa-trash-alt"></i>
              </button>
            <?php else : ?>
              <button type="button" class="deleteAddressForm btn btn-danger" data-toggle="tooltip" title="Delete"
                      data-id="<?= $item->id ?>" data-customer="<?= $item->customer_id ?>">
                <i class="fas fa-trash-alt"></i>
              </button>
            <?php endif; ?>
          </div>
        </div>
        <p class="uk-margin-remove">
          <b>Name: </b> <span class="name"><?= $item->name ?></span>
        </p>
        <p class="uk-margin-remove">
          <b>Phone: </b><span class="phone_one"><?= $item->phone_one ?></span>
        </p>
        <?php if ($item->phone_two) : ?>
          <p class="uk-margin-remove">
            <b>Phone 2: </b><span class="phone_two"><?= $item->phone_two ?></span>
          </p>
        <?php endif; ?>
        <p class="uk-margin-remove">
          <b>Area: </b> <span class="area"><?= $item->area ?></span>
        </p>
        <p class="uk-margin-remove">
          <b>Address: </b> <span class="address"><?= $item->address ?></span>
        </p>

        <?php if ($default_address == $item->id) : ?>
          <span class="uk-badge uk-position-absolute shipHereBadge"
                style="right: 16px;bottom: 23px;background: rgb(25, 107, 68);padding: 12px;">
              <span uk-icon="check"></span>
            </span>
        <?php else : ?>
          <span class="uk-badge uk-position-absolute shipHereBadge"
                style="right: 16px;bottom: 23px;background: #fcb812;padding: 12px;cursor:pointer"
                uk-tooltip="title: Ship Here">Ship Here</span>
        <?php endif; ?>
      </div>

    </div>


  <?php
  endforeach;

endif;
?>
