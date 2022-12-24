import { checkout_summary_re_calculation } from "./customerAddress";

window.Cart = require("cart-localstorage");

window.sumArray = function (array) {
  return array.reduce(function (a, b) {
    return Number(a) + Number(b);
  }, 0);
};

window.decimalPoint = function (input) {
  return Number(input).toFixed(2);
};

window.numberWithCommas = function (inputNumber) {
  var x = Math.round(inputNumber);
  var inputNumber =
    x.toString().split(".")[0].length > 3
      ? x
          .toString()
          .substring(0, x.toString().split(".")[0].length - 3)
          .replace(/\B(?=(\d{2})+(?!\d))/g, ",") +
        "," +
        x.toString().substring(x.toString().split(".")[0].length - 3)
      : x.toString();
  return currency + " " + inputNumber;
};

var dom = $(document);

renderCart();
Cart.onChange(renderCart);

/**
 * return the delivery charge
 * @param amount
 * @returns {number}
 */
function getDeliveryCharge(amount) {
  var return_amount = 0;
  var end_amount = 0;
  var last_dl_amount = 0;
  for (var i = 0; i < window.delivery_charge.length; i++) {
    var s_amount = window.delivery_charge[i].s_amount;
    var e_amount = window.delivery_charge[i].e_amount;
    var c_amount = window.delivery_charge[i].c_amount;
    if (Number(s_amount) <= amount && Number(e_amount) >= amount) {
      return_amount = c_amount;
    }
    end_amount = window.delivery_charge[i].e_amount;
    last_dl_amount = window.delivery_charge[i].c_amount;
  }
  let d_charge = amount >= end_amount ? last_dl_amount : return_amount;
  return Number(d_charge);
}

/**
 * return the item tax amount
 * @param amount
 * @param percentage
 * @returns {number}
 */
function getTaxAmount(amount, percentage) {
  if (percentage) {
    return amount * (parseFloat(percentage) / 100);
  } else {
    return 0;
  }
}

/**
 * calculate the cart related amount
 * @param total_cart_qty
 * @param sub_total
 * @param s_status
 */
function calculate_summary(total_del_charge, total_tax) {
  const items = Cart.list();
  const cartTotal = Cart.total();
  let noDelivery = items.filter(
    (noDel) =>
      noDel.delivery_charge === null || parseInt(noDel.delivery_charge) === 0
  );
  let main_charge = noDelivery.length ? getDeliveryCharge(cartTotal) : 0;

  let areas = get_delivery_areas();
  let area_id = $("#district_name").val();
  let d_charge = 0;
  let area = areas.find(
    (findArea) => parseInt(findArea.id) === parseInt(area_id)
  );
  if (area) {
    let area_rate = area.hasOwnProperty("delivery_charge")
      ? area.delivery_charge
      : 0;
    let charge_type = area.hasOwnProperty("charge_type")
      ? area.charge_type
      : "";
    if (charge_type === "avg_charge") {
      d_charge +=
        parseInt(main_charge) +
        (parseInt(main_charge) * parseInt(area_rate)) / 100;
    } else if (charge_type === "flat_charge") {
      d_charge = parseInt(main_charge) + parseInt(area_rate);
      // console.log(d_charge);
    }

    d_charge = noDelivery.length
      ? parseInt(d_charge) + parseInt(total_del_charge)
      : parseInt(total_del_charge);

    $("#city").val(d_charge);
    $("#city_name").val(area.name);
    $(".close_coupon").trigger("click");
  } else {
    d_charge = parseInt(main_charge) + parseInt(total_del_charge);
  }

  let vat_charge = Number(cartTotal) * 0.075;
  // console.log('d_charge', d_charge);
  // console.log('area_id', area_id);
  // console.log('areas', areas);
  // console.log('area', area);

  let summary = $("#checkout_Summary");
  let coupon_amount = $(".coupon_amount").val();
  coupon_amount = coupon_amount ? coupon_amount : 0;

  // Number(total_tax)) remove total tax from cart
  let payable =
    Number(cartTotal) +
    Number(vat_charge) +
    Number(d_charge) -
    Number(coupon_amount);
  summary.find(".checkout_subtotal").text(numberWithCommas(cartTotal));
  summary.find(".vat_charge").text(numberWithCommas(vat_charge));
  summary.find(".del_charge").text(numberWithCommas(d_charge));
  summary.find(".checkout_total").text(numberWithCommas(payable));

  if (cartTotal) {
    $(".process_order").removeAttr("disabled");
  } else {
    $(".process_order").attr("disabled", "disabled");
  }
}

function checkout_items(index, item, cart_price, row_total) {
  let id = item.hasOwnProperty("id") ? item.id : "";
  let name = item.hasOwnProperty("name") ? item.name : "";
  let color_name = item?.color_name || null;
  let size_name = item?.size_name || null;
  let attr_qty = item?.attr_qty || null;
  let delivery_charge = item.hasOwnProperty("actual_del_charge")
    ? item.actual_del_charge
    : 0;
  let cart_qty = item.hasOwnProperty("quantity") ? item.quantity : 0;
  // console.log(delivery_charge);
  return `<tr>
          <td class="text-center">${index + 1}</td>
          <td> <a href="/product/${id}">${name}</a> <br> <small>${numberWithCommas(
    cart_price
  )}</small> ${
    delivery_charge
      ? `<small>| Delivery charge: ${numberWithCommas(delivery_charge)}</small>`
      : ""
  }${size_name ? `<p class="m-0 small">Size: ${size_name}</p>` : ""}${
    color_name ? `<p class="m-0 small">Color: ${color_name}</p>` : ""
  }</td>
    <td class="text-center">
      <div class="input-group input-group-sm plus-minus-group mx-auto">
        <div class="input-group-prepend">
          <button type="button" data-id="${id}" data-qty="${attr_qty}" data-cart-qty="${cart_qty}" class="btn btn_m "><i class="icon-minus"></i></button>
        </div>
        <input type="text" value="${cart_qty}" class="form-control text-center" readonly="readonly">
        <div class="input-group-append">
          <button type="button" data-qty="${attr_qty}" data-cart-qty="${cart_qty}" data-id="${id}" class="btn btn_p "><i class="icon-plus"></i></button>
        </div>
      </div>
    </td>
    <td class="text-right">${numberWithCommas(row_total)}</td>
  </tr>`;
}

/**
 * render the cart on the front cart item
 */
function renderCart() {
  const items = Cart.list();
  const itemsTotal = Cart.total();
  const currency = $(".hidden_currency").val();
  let total_tax = 0;
  let total_discount = 0;
  let cart_total = 0;
  let cartItem = "";
  let checkoutItems = "";
  let total_del_charge = 0;
  let single_page = $("#single_page_name").text();

  $(".btnCart").show();
  $(".btnBuy").hide();
  $(".qty").val(0);

  items.map((item, index) => {
    var id = item.id;
    var color_id = item.color_id;
    var size_id = item.size_id;
    var row_tax = item.tax_percentage;
    var cart_qty = item.quantity;
    var attr_qty = item.attr_qty;

    var category_id = item.hasOwnProperty("category_id") ? item.category_id : 0;
    var subcategory_id = item.hasOwnProperty("subcategory_id")
      ? item.subcategory_id
      : 0;
    var delivery_charge = item.hasOwnProperty("actual_del_charge")
      ? item.actual_del_charge
      : 0;
    var cart_price = Number(item.price);
    var sale_price = 0;
    var discount_price = 0;
    var row_discount = 0;

    if (Number(item.discount_price) && item.has_offer === "Yes") {
      discount_price = Number(item.discount_price);
      sale_price = Number(item.price);
      cart_price = discount_price;

      row_discount = item.sale_price - discount_price;
      total_discount += row_discount * cart_qty;
    }

    var row_total = cart_qty * cart_price;

    if (delivery_charge !== "free" && parseInt(delivery_charge) > 0) {
      let del_charge = parseInt(delivery_charge);
      total_del_charge += del_charge;
    }

    cart_total += row_total;

    var row_tax_total = getTaxAmount(row_total, row_tax);
    total_tax += row_tax_total;
    if (single_page === "checkout") {
      checkoutItems += checkout_items(index, item, cart_price, row_total);
    } else if (single_page === "payment") {
      let block_cats = [47, 49, 50];
      if (block_cats.includes(category_id)) {
        $(".cashOnDelivery").attr("disabled", "disabled");
        $(".cashOnDelivery").attr("title", "Cash on delivery not allowed");
        $(".cashOnDelivery").addClass("disabled");
      }
    } else if (single_page === "product") {
      // start single page
      $("#amount_" + id).text(numberWithCommas(cart_price));
      $(".qty_" + id).val(cart_qty);
      $(".btnCart_" + id).hide();
      $(".btnBuy_" + id).show();
      dom.find(`.AttrProduct${color_id + size_id}`).prop("checked", true);
      // end single page
    }

    cartItem += `<li>
                  <a href="/remove" class="item_remove removeItem" data-id="${id}"><i class="ion-close"></i></a>
                  <a href="/product/${id}"><img src="${
      item.image
    }" alt="cart_thumb2">${
      item.name
    }</a><span class="cart_quantity" data-value="${cart_qty}"> ${cart_qty} x <span class="cart_amount"></span> ${numberWithCommas(
      cart_price
    )}</span>
                    <input class="qty" type="hidden" value="${attr_qty}">
                </li>`;
  });

  $(".addToCartBox").html(cartItem);
  $("#checkoutItemBody").html(checkoutItems);
  window.total_cart_tax = Number(total_tax);

  $(".cart_count").text(items.length);
  $(".cart_footer").find(".totalVal").text(numberWithCommas(itemsTotal));

  // window.total_discount = parseFloat(total_discount);

  setTimeout(function () {
    calculate_summary(total_del_charge, total_tax);
  }, 300);
}

/**
 * making a set of product
 * @param params
 * @returns
 */
function product_item(id) {
  var parameters = $("#productParameters").text();
  if (parameters) {
    let product = JSON.parse(parameters);
    if (Object.keys(product).length) {
      let discount_price = product.hasOwnProperty("discount_price")
        ? product.discount_price
        : 0;
      let has_offer = product.hasOwnProperty("has_offer")
        ? product.has_offer
        : 0;
      let price = product.hasOwnProperty("price") ? product.price : 0;

      if (Number(discount_price) && has_offer === "Yes") {
        price = Number(discount_price);
      }
      product.price = price;
      return product;
    }
  }
  return {};
}

$(document)
  .on("click", ".itemWrapper", function () {
    let details = $(this).attr("data-details");
    if (details) {
      window.location.assign(details);
    }
  })
  .on("click", ".removeItem", function (e) {
    e.preventDefault();
    const product_id = parseInt($(this).attr("data-id"));
    Cart.remove(product_id);
  })
  .on("click", ".cartQuantityPlus", function (e) {
    e.preventDefault();
    const product_id = parseInt($(this).attr("data-id"));
    if (Cart.exists(product_id)) {
      Cart.quantity(product_id, 1);
    }
  })
  .on("click", ".cartQuantityMinus", function (e) {
    e.preventDefault();
    const product_id = parseInt($(this).attr("data-id"));
    if (Cart.exists(product_id)) {
      Cart.quantity(product_id, -1);
    }
  })
  .on("click", ".btn_p, .btnCart", function () {
    var activeAttribute = dom.find("input[name=activeAttribute]:checked");
    var inputQty = 0;
    var productQty = 0;
    var plusBtn = $(this);

    if (activeAttribute.length) {
      inputQty = $("#pro_qty").val();
      productQty = activeAttribute.attr("data-qty");
      plusBtn = $(".btn_p");
    } else {
      inputQty = $(this).attr("data-cart-qty");
      productQty = $(this).attr("data-qty");
    }

    if (parseInt(productQty) > parseInt(inputQty)) {
      var product_id = $(this).attr("data-id");
      var id = parseInt(product_id);
      if (Cart.exists(id)) {
        Cart.quantity(id, 1);
      } else {
        var product = product_item(id);
        if (activeAttribute.length) {
          var attribute_price = activeAttribute.attr("data-price");
          attribute_price = attribute_price ? Number(attribute_price) : 0;
          product.color_id = activeAttribute.attr("data-color-id");
          product.color_name = activeAttribute.attr("data-color-name");
          product.size_id = activeAttribute.attr("data-size-id");
          product.size_name = activeAttribute.attr("data-size-name");
          product.attr_qty = productQty;

          if (attribute_price) {
            product.price = attribute_price;
          }
        }

        let product_price = parseInt(product.price);
        let product_id = parseInt(product.id);
        if (product_id && product_price) {
          setTimeout(() => {
            fb_pixel_AddToCart(
              [{ id: `SKU-${product_id}`, quantity: 1 }],
              product_price
            );
          }, 3000);
        }
        Cart.add(product, 1);
      }
    } else {
      plusBtn.prop("disabled", true);
    }
  })

  .on("change", "input[name=activeAttribute]", function () {
    var thisItem = $(this);
    var qty = thisItem.attr("data-qty");
    console.log(qty, inputQty);
    if (qty >= inputQty) {
      $(".btn_p").prop("disabled", false);
      var item_id = parseInt(thisItem.val());
      let price = thisItem.attr("data-price");
      price = price ? Number(price) : 0;
      if (Cart.exists(item_id)) {
        Cart.update(item_id, "color_id", thisItem.attr("data-color-id"));
        Cart.update(item_id, "color_name", thisItem.attr("data-color-name"));
        Cart.update(item_id, "size_id", thisItem.attr("data-size-id"));
        Cart.update(item_id, "size_name", thisItem.attr("data-size-name"));
        if (price) {
          Cart.update(item_id, "price", parseInt(price));
        }
      } else {
        if (price) {
          $(".product_price .price").text(price);
        }
      }
    } else {
      $(".qty_3").val(qty);
      $(".btn_p").prop("disabled", true);
    }
  })
  .on("click", ".btn_m", function () {
    var plusBtn = $(this);
    var inputQty = $(this).attr("data-cart-qty");

    if (inputQty) {
      plusBtn.closest(".btn_p").prop("disabled", false);
    } else {
      $(".btn_p").prop("disabled", false);
    }

    var product_id = $(this).attr("data-id");
    var id = parseInt(product_id);
    if (Cart.exists(id)) {
      Cart.quantity(id, -1);
    }
  })
  .on("click", ".small-galary-img", function (e) {
    // alert('ol');
    e.preventDefault();
    const image = $(this).attr("data-image");
    console.log(image);
    $(this)
      .closest(".product_gallery_item")
      .find(".product_gallery_item")
      .removeClass("active");
    $(this).closest(".product-image").find("#product_img").attr("src", image);
    $(this)
      .closest(".product-image")
      .find("#product_img")
      .attr("data-zoom-image", image);
    //   let img = `<img id="product_img" src='${image}' data-zoom-image='${image}' alt="product_img1" style="width: 300px;"/>`;
    //    $(".product_img_box").html(img);
    $("#product_img").elevateZoom();
    $(this).addClass("active");
  });

/**
 * checkout summary calculation
 */
function checkout_summary_calculation() {
  let subTotal = Cart.total();
  let discount = Number($("#hidden_coupon_amount").val());
  let d_charge = Number($("#city").val());
  let vat_charge = Number(subTotal) * 0.075;
  let total_summary =
    Number(subTotal) + Number(vat_charge) + Number(d_charge) - Number(discount);

  let checkout_Summary = $("#checkout_Summary");
  checkout_Summary.find(".checkout_subtotal").text(numberWithCommas(subTotal));
  checkout_Summary.find(".vat_charge").text(numberWithCommas(vat_charge));
  checkout_Summary.find(".delCharge").text(numberWithCommas(d_charge));
  checkout_Summary.find(".checkout_discount").text(numberWithCommas(discount));
  checkout_Summary
    .find(".checkout_total")
    .text(numberWithCommas(total_summary));
}

/**
 * Coupon effected calculation
 * @param amount
 * @param enter_code
 * @param coupon_text
 */
function coupon_effect_calculation(amount, enter_code, coupon_text) {
  var couponForm = $("#check_coupon");
  var discount = coupon_text == "free-delivery" ? coupon_text : Number(amount);

  $("#hidden_coupon_code").val(enter_code);
  if (coupon_text == "free-delivery") {
    discount = $("#city").val();
    $("#hidden_coupon_amount").val(discount);
  }
  $("#hidden_coupon_amount").val(discount);

  if (discount) {
    couponForm.find(".input-group").addClass("d-none");
    couponForm.find(".coupon_alert").removeClass("d-none");
    couponForm.find(".coupon_text").text(coupon_text);
    $("#coupon_amount").text(discount);
  } else {
    couponForm.find(".input-group").removeClass("d-none");
    couponForm.find(".coupon_alert").addClass("d-none");
  }
  checkout_summary_calculation();
}

//check coupon
$(document)
  .on("submit", "#check_coupon", function (event) {
    event.preventDefault();
    var couponForm = $(this);
    var total = Cart.total();
    var enter_code = couponForm.find("#coupon").val();
    var formAction = couponForm.attr("action");
    if (enter_code) {
      $.ajax({
        method: "POST",
        url: formAction,
        data: {
          enter_code: enter_code,
          total: total,
        },
        success: function (data) {
          if (data.delivery_charge) {
            coupon_effect_calculation(0, enter_code, data.delivery_charge);
          } else if (data.status === true) {
            var discount = (total * parseInt(data.amount)) / 100;
            coupon_effect_calculation(discount, enter_code, data.coupon_txt);
          } else {
            coupon_effect_calculation(0, "", "");
            swal_alert_sad(hidden_alert, data.msg);
          }
        },
      });
    } else {
      couponForm.find("#coupon").val("");
      swal_alert_sad(hidden_alert, "Invalid coupon code");
    }
  })
  .on("click", ".close_coupon", function (e) {
    e.preventDefault();
    coupon_effect_calculation(0, "", "");
    $("#check_coupon").find("#coupon").val("");
  });

//select date
$(document)
  .on("click", ".process_order", function (e) {
    e.preventDefault();
    $("#shipping-submit").trigger("click");
  })
  .on("submit", "#shipping-form", function (e) {
    e.preventDefault();
    var action = $(this).attr("action");
    var cart_list = Cart.list();
    var cart_total = Cart.total();
    var total_items = cart_list.length;
    var total_payable = $("#checkout_Summary").find(".checkout_total").text();
    var vat_charge = $("#checkout_Summary").find(".vat_charge").text();
    var total_tax = 0;
    var data =
      $(this).serialize() +
      "&cart_total=" +
      cart_total +
      "&total_items=" +
      total_items +
      "&vat_charge=" +
      vat_charge +
      "&total_payable=" +
      total_payable +
      "&total_tax=" +
      total_tax +
      "&cart=" +
      JSON.stringify(cart_list);
    // var form = $(this).serializeArray();
    // data.cart = JSON.stringify(cart_list);
    // data.form = JSON.stringify(form);

    $.ajax({
      type: "POST",
      url: action,
      data: data,
      beforeSend: function () {
        // before loading...
      },
      success: function (response) {
        if (response.status) {
          window.location.href = "/confirm-payment";
        } else {
          swal_alert_sad(hidden_alert, "Checkout validation error!");
        }
      },
      error: function (xhr) {
        // if error occurred
        // console.log('error', xhr);
      },
      complete: function () {
        // console.log('Coupon complete');
      },
    });
  })
  .on("click", ".payment_click", function (e) {
    e.preventDefault();
    var payment_click = $(".payment_click");
    var disabled = $(this).attr("disabled");
    if (disabled) {
      swal_alert_sad("", "This payment is allowed for COD");
    } else {
      payment_click.removeClass("active");
      $(this).addClass("active");
      var this_id = $(this).attr("data-id");
      $("#hidden_payment_status").val(this_id);
    }
  });

$(document)
  .on("click", ".paymentAccept", function () {
    var payment_terms = $("#accept_payment_terms");
    var payment_id = $("#hidden_payment_status").val();
    var accept = 0;
    var message = 0;

    if (payment_terms.is(":checked")) {
      accept += 1;
    } else {
      message = "Please accept terms and condition";
    }
    if (payment_id) {
      accept += 1;
    } else {
      message = "Please select one of payment option";
    }
    if (accept === 2) {
      $(this).addClass("placeOrderConfirm");
    } else {
      swal_alert_sad(message, message);
    }
  })
  .on("change", "#accept_payment_terms", function () {
    var payment_id = $("#hidden_payment_status").val();

    if ($(this).is(":checked") && payment_id) {
      $(".paymentAccept").addClass("placeOrderConfirm");
    } else {
      $(".paymentAccept").removeClass("placeOrderConfirm");
    }
  })
  .on("click", ".placeOrderConfirm", function (e) {
    e.preventDefault();
    $(this).removeClass("placeOrderConfirm");
    var payment_id = $("#hidden_payment_status").val();
    if (!payment_id) {
      var alert_txt_3 = $("#alert_txt_3").val();
      swal_alert_sad(hidden_alert, alert_txt_3);
      $(this).html("Confirm");
    } else {
      //for paypal payment
      if (parseInt(payment_id) === 6) {
        $.ajax({
          url: base_url + "Ajaxpublic/orderConfirm1",
          method: "POST",
          data: {
            payment_id: payment_id,
          },
          beforeSend: function () {
            $(".preloader").fadeIn();
          },
          success: function (data) {
            if (data.status === true) {
              if (data.order_number) {
                $("#hidden_order_id").val(data.order_number);
                $("#success_url_ssl").val(
                  base_url +
                    "paymentStatus?p_type=ssl&&msg=payment_success&&order_id=" +
                    data.order_number
                );
                $("#sslcommerz_form").trigger("submit");
                let status = facebook_pixel_purchase_event();
                if (status) {
                  Cart.destroy();
                }
              }
            } else {
              swal_alert_sad(hidden_alert, data.msg);
            }
          },
          complete: function (data) {
            $(".preloader").fadeOut();
          },
        });
      } else if (parseInt(payment_id) === 1) {
        $.ajax({
          url: base_url + "Ajaxpublic/orderConfirm",
          method: "POST",
          data: {
            payment_id: payment_id,
          },
          beforeSend: function () {
            $(".preloader").fadeIn();
          },
          success: function (data) {
            if (data.status === true) {
              Cart.destroy();
              swal_alert_happy(hidden_alert, "Your order placed successfully");
              window.location.href = "/my-orders";
            } else {
              swal_alert_sad(hidden_alert, data.msg);
            }
          },
          complete: function (data) {
            $(".paymentAccept")
              .addClass("placeOrderConfirm")
              .find(".buttonLoader")
              .text("");
            $(".preloader").fadeOut();
          },
        });
      }
    }
  });

function facebook_pixel_purchase_event() {
  var cartItems = Cart.list();
  if (cartItems.length) {
    let contents = [];
    let price = 0;
    let num_items = 0;
    cartItems.map((item) => {
      let quantity = parseInt(item.quantity);
      contents.push({ id: `SKU-${item.id}`, quantity: quantity });
      price += parseInt(item.sale_price);
      num_items += 1;
    });
    if (contents.length) {
      fb_pixel_Purchase(contents, price, num_items);
    }
  }
  return true;
}

function product_attributes() {
  var dom = $(document);
  var attributes = dom.find("#productAttributesData").text();
  if (attributes) {
    return JSON.parse(attributes);
  }
  return [];
}

function get_delivery_areas() {
  var districts = $("#delivery_districts").text();
  if (districts) {
    return JSON.parse(districts);
  }
  return [];
}

function load_customer_areas() {
  const cartTotal = Cart.total();
  //  let main_charge = getDeliveryCharge(cartTotal);
  let areas = get_delivery_areas();
  let option = "";
  if (areas.length) {
    areas.map((area, key) => {
      //  let area_rate = area.hasOwnProperty('delivery_charge') ? area.delivery_charge : 0;
      //  let charge_type = area.hasOwnProperty('charge_type') ? area.charge_type : '';
      //  let d_charge = 0;
      //  if (charge_type === 'avg_charge') {
      //     d_charge += main_charge + (parseInt(main_charge) * parseInt(area_rate) / 100);

      //  } else if (charge_type === 'flat_charge') {
      //     d_charge += (parseInt(main_charge) + parseInt(area_rate));
      //  }

      //  option += `<option value="${area.id}"  >${area.name} | ${d_charge === 0 ? numberWithCommas(main_charge) : numberWithCommas(d_charge)}</option>`;
      option += `<option value="${area.id}"  >${area.name}</option>`;
    });
    $("#district_name").html(option);
  }
}

dom
  .on("click", ".color-span", function () {
    dom.find(".color-span").removeClass("active");
    $(this).addClass("active");
    var attributes = product_attributes();
    var color_id = $(this).attr("data-id");
    var color_name = $(this).attr("data-name");
    var size_name = dom.find(".size-span.active").attr("data-name");
    var size_id = dom.find(".size-span.active").attr("data-id");

    if (attributes.length) {
      var findItem = attributes.find(
        (attr) => attr.color_id == color_id && attr.size_id == size_id
      );
      if (findItem) {
        var product_id = parseInt(findItem.product_id);
        var product_price = findItem.product_price;
        if (Cart.exists(product_id)) {
          Cart.update(product_id, "price", product_price);
          Cart.update(product_id, "color_id", color_id);
          Cart.update(product_id, "color_name", color_name);
          Cart.update(product_id, "size_id", size_id);
          Cart.update(product_id, "size_name", size_name);
        } else {
          $("#amount_d").text(Number(product_price).toFixed(2));
        }
        dom.find("#stock-status").text("In stock");
      } else {
        dom.find("#stock-status").text("Out of stock");
      }
    }
  })
  .on("click", ".size-span", function () {
    dom.find(".size-span").removeClass("active");
    $(this).addClass("active");
    var attributes = product_attributes();
    var size_id = $(this).attr("data-id");
    var size_name = $(this).attr("data-name");
    var color_id = dom.find(".color-span.active").attr("data-id");
    var color_name = dom.find(".color-span.active").attr("data-name");
    // console.log(attributes);
    if (attributes.length) {
      var findItem = attributes.find(
        (attr) => attr.color_id == color_id && attr.size_id == size_id
      );
      if (findItem) {
        var product_id = parseInt(findItem.product_id);
        var product_price = findItem.product_price;
        if (Cart.exists(product_id)) {
          Cart.update(product_id, "price", product_price);
          Cart.update(product_id, "color_id", color_id);
          Cart.update(product_id, "color_name", color_name);
          Cart.update(product_id, "size_id", size_id);
          Cart.update(product_id, "size_name", size_name);
        } else {
          $("#amount_d").text(Number(product_price).toFixed(2));
        }
        dom.find("#stock-status").text("In stock");
      } else {
        dom.find("#stock-status").text("Out of stock");
      }
    }
  })
  .on("change", "#district_name", function () {
    const area_id = $(this).val();
    const items = Cart.list();
    const cartTotal = Cart.total();
    let noDelivery = items.filter(
      (noDel) =>
        noDel.delivery_charge === null || parseInt(noDel.delivery_charge) === 0
    );
    let d_charge = noDelivery.length ? getDeliveryCharge(cartTotal) : 0;
    let areas = get_delivery_areas();
    if (areas.length) {
      let findArea = areas.find(
        (area) => parseInt(area.id) === parseInt(area_id)
      );
      if (findArea) {
        let area_rate = findArea.hasOwnProperty("delivery_charge")
          ? findArea.delivery_charge
          : 0;
        let charge_type = findArea.hasOwnProperty("charge_type")
          ? findArea.charge_type
          : "";

        let has_delivery = items.filter(
          (has_del) => parseInt(has_del.delivery_charge) > 0
        );

        if (has_delivery.length) {
          has_delivery.map((item) => {
            let delivery_charge = item.hasOwnProperty("delivery_charge")
              ? parseInt(item.delivery_charge)
              : 0;
            if (charge_type === "avg_charge") {
              delivery_charge += (delivery_charge * parseInt(area_rate)) / 100;
              Cart.update(item.id, "actual_del_charge", delivery_charge);
            } else if (charge_type === "flat_charge") {
              console.log(area_rate);
              delivery_charge = delivery_charge + parseInt(area_rate);
              Cart.update(item.id, "actual_del_charge", delivery_charge);
            }
          });
        } else {
          renderCart();
        }
      }
    }
  });

$(function () {
  var page = $("#single_page_name").text();
  if (page === "checkout") {
    load_customer_areas();
  }
});
