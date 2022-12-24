<section class="content">
  <div class="row">
    <div class="col-md-12">

      <?= form_open('admin/permission', ['role' => 'form', 'id' => 'permission_form']); ?>

      <div class="box box-primary">

        <div class="box-header with-border">
          <div class="row">
            <div class="col-sm-4">
              <h3 class="box-title"><?= lang('manage_permission'); ?></h3>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <?= form_dropdown('role', $roles, [$role], ['class' => 'form-control select2']) ?>
              </div>
            </div>
          </div>
        </div> <!-- /.box-header -->

        <!-- /.box-header -->
        <div class="box-body table-responsive">

          <table class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p">Group</th>
              <th class="width_1_p">Create</th>
              <th class="width_1_p">Read</th>
              <th class="width_1_p">Update</th>
              <th class="width_1_p">Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($access as $group_key => $item): ?>
              <tr>
                <td style="vertical-align: middle;">
                  <label>
                    <?= $form_input = form_checkbox(['name' => '', 'class' => 'selectAll flat-red']) ?>
                    <?= ucfirst($group_key) ?>
                  </label>
                </td>
                <?php
                $i = 0;

                foreach ($item as $key => $singleItem):
                  $i++;
                  $td = '<td style="vertical-align: middle">';
                  $tdClose = '</td>';
                  $form_input = form_checkbox(['name' => 'access[]', 'class' => 'flat-red singleItem', 'id' => $key, 'value' => $key, 'checked' => role_has_permission($key, $role)]);
                  $form_label = '<label for="' . $key . '">' . $singleItem . '</label>';
                  if ($i == 3) {
                    echo $td;
                    echo $form_input;
                    echo $form_label;
                    echo $tdClose;
                    if (count($item) > 4) {
                      echo $td;
                    }
                  } elseif ($i >= 4 && count($item) > 4) {
                    echo '<div class="form-group">';
                    echo $form_input;
                    echo $form_label;
                    echo '</div>';
                    if (count($item) == $i) {
                      echo $tdClose;
                    }
                  } else {
                    echo $td;
                    echo $form_input;
                    echo $form_label;
                    echo $tdClose;
                  }
                endforeach;
                ?>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div> <!-- /.box-body -->
      </div>

      <?= form_close(); ?>
    </div>
  </div>
</section>

<script>

   function change_user_permission() {
      var formData = new FormData($("#permission_form")[0]);
      $.ajax({
         method: "POST",
         url: '<?= site_url("admin/permission") ?>',
         data: formData,
         processData: false,
         contentType: false,
         dataType: "json",
         success: function (data) {
            swal({
               title: data.msg,
               text: data.msg,
               confirmButtonText: 'Ok'
            });
         }
      })
   }

   $(document).on('change', '.select2', function () {
      window.location.href = base_url + "admin/permission?role=" + $(this).val();
   });

   function check_parent_button(item) {
      const length = item.find('.singleItem').length
      const checkLength = item.find(".singleItem:checked").length;
      if (length === checkLength) {
         item.closest('tr').find(".selectAll").iCheck('check');
      } else {
         item.closest('tr').find(".selectAll").iCheck('uncheck');
      }
   }


   $(document).find('tr').each(function () {
      check_parent_button($(this), true);
   });

   $(document).on('ifChanged', '.selectAll', function () {
      const table_row = $(this).closest('tr');
      const singleItem = table_row.find(".singleItem");

      const length = singleItem.length
      const checkLength = table_row.find(".singleItem:checked").length;

      if (length === checkLength) {
         if ($(this).is(":not(:checked)")) {
            singleItem.iCheck('uncheck');
         }
      }else{
         if ($(this).is(':checked')) {
            singleItem.iCheck('check');
         }
      }

   });

   $(document).on('ifChanged', '.singleItem', function () {
      check_parent_button($(this).closest('tr'));
      change_user_permission();
   });

   $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
   });

</script>

