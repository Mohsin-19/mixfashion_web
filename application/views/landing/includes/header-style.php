<style>
  footer * {
    color: white;
  }

  .productDetailsModal .productAllInfo .modalAmount .quantity button:hover {
    background-color: transparent !important;
  }

  .cartBtnBox .after-cart-show button {
    padding: 7px !important;
  }

  .uk-button-danger {
    background-color: #cb150f !important;
  }

  .uk-modal {
    z-index: 9999;
    padding: 1px 0px !important;
  }



  span.ripple {
    background-color: <?= escape_output($base_color) ?>;
  }

  /* for button focus color */
  .productDetailsModal .productAllInfo .modalAmount .quantity button:focus,
  #rightSidebarForAddToCart .content .showCartItem .productCartView li .right-item .innerCartBox .cartQuantityBox button:focus {
    box-shadow: 0 0 0 1px <?= escape_output($base_color) ?>;
    border-color: <?= escape_output($base_color) ?>;
  }

  /* for button hover color */
  .productDetailsModal .productAllInfo .modalAmount .quantity button:hover,
  #rightSidebarForAddToCart .content .showCartItem .productCartView li .right-item .innerCartBox .cartQuantityBox button:hover {
    background-color:
      <?= escape_output($base_color) ?>;
    border-color:
      <?= escape_output($base_color) ?>;
    box-shadow: 0 0 0 0.1rem <?= escape_output($base_color) ?>;
  }

  /*For Text Color*/
  .txtColor {
    color:
      <?php echo escape_output($base_color) ?>;
  }

  /*For Solid BG Color*/
  .bgColor {
    background-color:
      <?php echo escape_output($base_color) ?>;
  }

  /*For BG Color With Opacity*/
  .bgAlphaColor {
    background-color:
      <?php echo escape_output($base_color) ?>;
    opacity: 0.9;
  }

  .theme-background-color {
    background-color:
      <?php echo escape_output($base_color) ?> !important;
  }

  header.mainHeader ul>li .uk-dropdown-nav li a {
    color:
      <?php echo escape_output($base_color) ?> !important;
  }

  /*======== Sweet Alert ==========*/
  .sa-confirm-button-container .confirm {
    background-color:
      <?php echo escape_output($base_color) ?> !important;
  }

  .sweet-alert fieldset {
    display: none
  }

  .preloader .preloader-container .animated-preloader {
    background-color: "<?php echo escape_output($base_color) ?>" !important;
  }

  .preloader .preloader-container .animated-preloader:before {
    background-color:
      <?php echo escape_output($base_color) ?> !important;
    opacity: 0.6;
  }

  legend.panel-title.uk-legend {
    background-color:
      <?php echo escape_output($base_color) ?> !important;
  }

  @media (max-width: 640px) {
    #mainHomeContent #productPage .productItemContainer .itemWrapper .cartBtnBox .cardBtn {
      background-color:
        <?php echo escape_output($base_color) ?> !important;
    }
  }

  @media (min-width: 320px) and (max-width: 1024px) {
    .searchform {
      width: 300px;
      top: 49px;
      display: none;
      left: -111px;
    }
  }

  @media (min-width: 320px) and (max-width: 640px) {
    .product-overlay {
      z-index: 0 !important;
    }

    /* #mainHomeContent .tabSlider .itemWrapper .cartBtnBox{
        top: 192px!important;
        right: 79px!important;
      } */
    .overlay-txt p {
      padding-top: 20px;
      font-size: 18px !important;
      display: none;
    }

    .owl-nav {
      display: none;
    }

    .cartBtnBox {
      top: 10px !important;
    }
  }

  @media only screen and (max-width: 380px) {
    .navbar-nav .dropdown-menu.cart_box_search.show {
      right: -191px;
      width: 310px;
    }

    .header_wrap .navbar .navbar-nav.attr-nav {
      margin-left: 0px !important;
    }
  }



  .search_wrap {
    top: -277px;
    max-width: 459px !important;
  }

  .close-search {
    color: #ff0101 !important;
    top: 38% !important;
  }

  .search_wrap .form-control {
    background-color: #008614 !important;
    color: #ffffff !important;
  }

  .search_overlay.open {
    width: 0px !important;
  }

  /* zoom style */
  .zoomWindow {
    top: -9px !important;
    left: 400px !important;
    border: 2px solid rgb(68, 68, 68) !important;
  }

  .small-galary-img {
    width: 100px !important;
    border: 1px solid;
    float: left !important;
  }

  .searchform {
    position: absolute;
    width: 300px;
    top: 49px;
    display: none;
    right: 0px;

  }

  .cardlist {
    position: absolute;
    width: 322px;
    top: 49px;
    right: 0px;
    display: none;

  }

  .d-block {
    display: block !important;
  }

  .wilistmenu,
  .cmenu {
    width: 320px;
    background-color: #fff;
    box-shadow: 0 13px 42px 11px rgb(0 0 0 / 5%);
    opacity: 1;
    visibility: visible;
    margin-top: 0px;
    pointer-events: auto;
    position: absolute;
    padding: .5rem 0;
    display: none;
  }

  .cart_list {
    width: 100%;
    padding: 0 !important;
    max-height: 242px;
    overflow-y: auto;
  }
</style>