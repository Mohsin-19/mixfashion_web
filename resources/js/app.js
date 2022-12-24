try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');
  window.swal = require('../plugins/sweetalert2/dist/sweetalert.min');
  require('bootstrap');

} catch (e) {
  console.log(e)
}


window.swal_alert_happy = function (title = '', msg = '') {
  swal({
    imageUrl: base_url + "assets/images/happy.png",
    imageHeight: 1500,
    imageAlt: msg,
    title: title,
    text: msg,
    confirmButtonText: hidden_ok,
    confirmButtonColor: "#3c8dbc",
  });
}

window.swal_alert_sad = function (title = '', msg = '') {
  swal({
    imageUrl: base_url + "assets/images/sad.png",
    imageHeight: 1500,
    title: title,
    text: msg,
    confirmButtonText: hidden_ok,
    confirmButtonColor: "#3c8dbc",
  });
}


require('./source/loginRegistration');
require('./source/searching');
require('./source/cart');
require('./source/wishlist');
require('./source/customerAddress');
require('./source/orders');
require('./source/scriptHelpers');
require('./source/sidebar');

// import '../plugins/wickedpicker/src/wickedpicker.js';
// import '../plugins/jqueryScrollbar/jquery.scrollbar';
// import '../plugins/mark/jquery.mark';
// import './souce/main';
// import './souce/custom_script_layout';
// import './souce/custom';