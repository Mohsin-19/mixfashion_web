//show items details
$(document).on("click", ".showInfo", function (e) {
  e.preventDefault();
  var showOrderModal = $("#showOrderModal");
  var id = $(this).attr("data-id");
  $.ajax({
    url: base_url + "Ajaxpublic/getOrderItemsByCustomerId",
    method: "POST",
    async: false,
    data: {
      order_id: id
    },
    dataType: "json",
    success: function (data) {

      if (data.status) {
        showOrderModal.find('.order_details_body').html(data.html);
        showOrderModal.modal('show');
      } else {
        swal_alert_sad('', 'Order details not found. contact with authority');
      }

    },
  });
});