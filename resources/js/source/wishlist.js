import axios from "axios";

(function($) {
  function load_wishlist_data(wishlist) {
    var totalWishlist = wishlist.length;
    $(document)
      .find(".wishlist_count")
      .text(totalWishlist);
  }

  function load_wishlist() {
    axios
      .post("/get-wishlist")
      .then((response) => {
        let resData = response.data;
        if (resData.status) {
          load_wishlist_data(resData.wishlist);
        }
      })
      .catch((error) => {
        console.log("error", error);
      });
  }

  $(document)
    .on("click", "#addToWishlist", function(event) {
      event.preventDefault();
      var product_id = $(this).attr("href");
      if (product_id) {
        axios
          .post(`/add-to-wishlist/${product_id}`)
          .then((response) => {
            let resData = response.data;
            if (resData.status) {
              load_wishlist_data(resData.wishlist);
            } else {
              swal_alert_happy(null, resData.msg);
            }
          })
          .catch((error) => {
            console.log("error", error);
          });
      } else {
        swal_alert_sad(null, "Product not found for add wishlist");
      }
    })
    .on("click", ".removeFromWishlist", function(event) {
      event.preventDefault();
      var product_id = $(this).attr("href");
      axios
        .post(`/remove-wishlist/${product_id}`)
        .then((response) => {
          let resData = response.data;
          if (resData.status) {
            $(this)
              .closest("tr")
              .remove();
            load_wishlist_data(resData.wishlist);
          } else {
            swal_alert_happy(null, resData.msg);
          }
        })
        .catch((error) => {
          console.log("error", error);
        });
    });

  $(document).ready(function() {
    load_wishlist();
  });
})(jQuery);

$(document).on("click", ".wishlistProduct", function(event) {
  event.preventDefault();

  const id = parseInt($(this).attr("data-id"));
  const name = $(this).attr("data-name");
  const itemInfo = $(this).closest(".itemInfo");
  // const price = itemInfo.find('.itemAmount').html();

  const price = $(this).attr("data-price");
  const offer_txt = $(this).attr("data-offer");
  const description = $(this).attr("data-description");
  const image_url = $(this).attr("data-image");
  const current_qty = itemInfo.find(".showOverlayVal").text();
  const qty = Cart.exists(id) ? parseInt(current_qty) : 0;
  const detailsModal = $(document).find(".productDetailsModal");

  // galery
  detailsModal.find(".showIncreaseDecreaseVal").text(qty);

  detailsModal.find(".btn_m").attr("data-id", id);
  detailsModal.find(".btn_p").attr("data-id", id);
  detailsModal.find(".buyNow").attr("data-id", id);
  detailsModal.find(".wlist").attr("data-id", id);
  detailsModal.find(".title_d").html(name);
  detailsModal.find(".descTitle").html(offer_txt); // offer text
  detailsModal.find(".des_d").html(description);
  detailsModal.find(".amount_d").html(price);
  detailsModal.find("#product_img").attr("data-zoom-image", image_url);
  detailsModal.find("#product_img").attr("src", image_url);

  detailsModal.find("#product_id").attr("value", id);

  detailsModal
    .find(".amount_d")
    .find("del")
    .css({
      marginRight: "15px",
      color: "#e4c417",
    });

  UIkit.modal(".productDetailsModal").show();
});
