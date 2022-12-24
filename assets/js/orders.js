$(function () {
  "use strict";
  //initial datatable
  $('#datatable').DataTable({
    'autoWidth': false,
    'ordering': false
  });

  $(document).on('click', '.action_btn', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-id");
    $("#status_change_id").val(id);
    var status = $(this).attr("data-status");
    var status_value = $(this).attr("data-status_value");
    //change status
    if (Number(status) == 2) {
      $("#change_status").modal('show');
      $("#status_f").val(status_value).change();
      //assign delivery person
    } else if (Number(status) == 3) {
      $("#assign_delivery_person").modal('show');
      if (status_value && status_value != 0) {
        $("#employee_id").val(status_value).change();
      } else {
        $("#employee_id").val('').change();
      }
      //add note
    } else if (Number(status) == 4) {
      $("#note_modal").modal('show');
      var previous_note = $(".set_text_note" + id).text();
      $("#note").val(previous_note);
      //print order
    } else if (Number(status) == 1) {
      let newWindow = open("print_invoice/" + id, 'Print Invoice', 'width=1000,height=550');
      newWindow.focus();
      newWindow.onload = function () {
        newWindow.document.body.insertAdjacentHTML('afterbegin');
      };
    } else if (Number(status) == 5) {
      let newWindow = open("print_packing_slip/" + id, 'Print Packing Slip', 'width=1000,height=550');
      newWindow.focus();
      newWindow.onload = function () {
        newWindow.document.body.insertAdjacentHTML('afterbegin');
      };
    } else if (Number(status) == 6) {
      let newWindow = open("view_print_invoice/" + id, 'View Invoice', 'width=1000,height=550');
      newWindow.focus();
      newWindow.onload = function () {
        newWindow.document.body.insertAdjacentHTML('afterbegin');
      };
    }
  });

  $(document).on('click', '#change_status_add', function (e) {
    e.preventDefault();
    var id = $("#status_change_id").val();
    var status_f = $("#status_f").val();
    $(".show_msg").hide();
    $(".msg_p").html('');
    swal({
      title: hidden_alert + "!",
      text: are_you_sure + "?",
      cancelButtonText: hidden_cancel,
      confirmButtonText: hidden_ok,
      confirmButtonColor: '#3c8dbc',
      showCancelButton: true
    }, function () {
      var timing = new Date().toLocaleTimeString('en-US', {
        hour: 'numeric',
        hour12: true,
        minute: 'numeric'
      });
      $.ajax({
        url: base_url + 'Ajax/changeStatus',
        method: 'get',
        dataType: 'json',
        data: {
          'id': id,
          'status': status_f
        },
        success: function (data) {
          if (data.status == true) {
            $(".set_text_status" + id).html(status_f);
            $(".set_text_time" + id).html(timing);
            $("#action_btn_" + id).attr("data-status_value", status_f);
            $("#change_status").modal('hide');
          } else {
            $(".msg_p").html(data.msg);
            $(".show_msg").show();
          }
        },
        error: function () {
          alert(somethingiswrong);
        }
      });
    });
  });

  $(document).on('click', '#assign_delivery_person_add', function (e) {
    e.preventDefault();
    var id = $("#status_change_id").val();
    var employee_id = $("#employee_id").val();

    swal({
      title: hidden_alert + "!",
      text: are_you_sure + "?",
      cancelButtonText: hidden_cancel,
      confirmButtonText: hidden_ok,
      confirmButtonColor: '#3c8dbc',
      showCancelButton: true
    }, function () {
      $.ajax({
        url: base_url + 'Ajax/assignDeliveryPerson',
        method: 'get',
        dataType: 'json',
        data: {
          'id': id,
          'employee_id': employee_id
        },
        success: function (data) {
          $("#2action_btn_" + id).val(employee_id);
          $("#assign_delivery_person").modal('hide');
        },
        error: function () {
          alert(somethingiswrong);
        }
      });
    });
  });

  $(document).on('click', '#note_add', function (e) {
    e.preventDefault();
    var id = $("#status_change_id").val();
    var note = $("#note").val();
    swal({
      title: hidden_alert + "!",
      text: are_you_sure + "?",
      cancelButtonText: hidden_cancel,
      confirmButtonText: hidden_ok,
      confirmButtonColor: '#3c8dbc',
      showCancelButton: true
    }, function () {
      $.ajax({
        url: base_url + 'Ajax/addNote',
        method: 'get',
        dataType: 'json',
        data: {
          'id': id,
          'note': note
        },
        success: function (data) {
          $(".set_text_note" + id).find('button').attr('data-content', note);
          $("#note_modal").modal('hide');
        },
        error: function () {
          alert(somethingiswrong);
        }
      });

    });

  });


  $(document).on('click', '.editOrderInformation', function (e) {
    e.preventDefault();
    var href_id = $(this).attr('href');
    var order_edit_modal = $(document).find('#order_edit_modal');
    order_edit_modal.find('.modal-title').text('Quick Edit #' + href_id);
    order_edit_modal.modal('show');
    $.ajax({
      url: base_url + '/admin/ajax/get-order-edit-info',
      method: 'POST',
      data: {
        order_id: href_id
      },
      dataType: 'html',
      success: function (htmlData) {
        order_edit_modal.find('.modal-body').html(htmlData);
      },
      error: function () {
        alert(somethingiswrong);
      }
    });
  });

  $(document).on('submit', '#quickOrderEditForm', function (e) {
    e.preventDefault();
    var column = $(document);
    var order_edit_modal = $(document).find('#order_edit_modal');

    $.ajax({
      url: base_url + '/admin/ajax/update-order-quick-info',
      method: 'POST',
      data: $(this).serialize(),
      success: function (htmlData) {
        column.find('.order-area-' + htmlData.id).text(htmlData.area);
        column.find('.delivery-date-' + htmlData.id).text(htmlData.delivery_date);
        column.find('.delivery-time-' + htmlData.id).text(htmlData.delivery_time);
        column.find('.checkout-name-' + htmlData.id).text(htmlData.checkout_name);
        // console.log(htmlData);
        order_edit_modal.modal('hide');
      },
      error: function (response) {
        alert(response);
      }
    });
  }).on("click", ".btn_mark_complete", function (event) {
    event.preventDefault();
    var thisBtn = $(this);
    var order_edit_modal = $('#order_edit_modal');
    $.ajax({
      url: thisBtn.attr('href'),
      method: 'POST',
      success: function (htmlData) {
        if (htmlData.del_status == "Live") {
          let order = htmlData.order;
          $('.set_text_status' + order.id).text(order.status);
          thisBtn.remove();
        }
        order_edit_modal.modal('hide');
      },
      error: function (response) {
        console.log(response);
      }
    });

  });


  let DataPopover = $('[data-toggle=popover]')

  if (DataPopover.length) {
    DataPopover.popover();
  }




});