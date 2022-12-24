<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route['default_controller'] = 'Landing';

$route['404_override'] = 'Landing/ErrorPage'; // 404 error page

$route['logout'] = 'Landing/logout';
$route['login'] = 'Landing/login';
$route['login-submit']['post'] = "Ajaxpublic/checkPhoneNumberForOTP";
$route['login-check-otp']['post'] = "Ajaxpublic/checkOTP";
$route['signup'] = 'Landing/signup';

$route['authentication'] = 'Authentication';
$route['payment'] = 'PaymentController/payment';
$route['sslcommerzPayment'] = 'PaymentController/sslcommerzPayment';
$route['googleLogin'] = 'Authentication/googleLogin';
$route['facebookLogin'] = 'Authentication/facebookLogin';
$route['stripePayment'] = 'PaymentController/stripePayment';
$route['paymentStatus'] = 'PaymentController/paymentStatus';
$route['translate_uri_dashes'] = FALSE;

$route['get-category-slug'] = 'FrontendController/getCategoryBySlug';
$route['get-sub-category'] = 'FrontendController/getSubCategory';
$route['get-sub-category-products'] = 'FrontendController/getSubCategoryProducts';
$route['products-searching'] = 'FrontendController/searchProducts';

$route['contact-us'] = 'Landing/contact_us';
$route['send-contact']['post'] = 'Landing/send_phone_number';
$route['search/(:any)'] = 'Landing/searchPage/$1';

// single page product
$route['product/(:num)'] = 'FrontendController/productDetails/$1';
$route['checkout'] = 'FrontendController/checkout';
$route['confirm-payment'] = 'FrontendController/payment';
$route['my-orders'] = 'FrontendController/myOrders';

$route['wishlist'] = 'WishListController/index';
$route['add-to-wishlist/(:num)']['post'] = 'WishListController/add_wishlist/$1';
$route['remove-wishlist/(:num)']['post'] = 'WishListController/remove_wishlist/$1';
$route['get-wishlist'] = 'WishListController/get_wishlist';


// product xml for pixel feed
$route['(?i)xml/products/feed'] = 'FrontendController/xmlProductsFeed';

// any page routes
$route['/?(:any)?'] = 'Landing/Pages/$1';
//$route['/?(:any)?//?(:any)?'] = 'Landing'; //this one passes 2 parameters


// ajax routes
$route['ajax/check-coupon']['post'] = 'Ajaxpublic/checkCoupon';
$route['ajax/checkout/cart-save-session']['post'] = 'Ajaxpublic/checkout_cart_save_to_session';

/**
 * admin routes
 */

// role control routes
$route['admin/role']['get'] = 'AccessController/User_role_controller/index';
$route['admin/role/create'] = 'AccessController/User_role_controller/create';
$route['admin/role']['post'] = 'AccessController/User_role_controller/store';
$route['admin/role/(:num)/edit'] = 'AccessController/User_role_controller/edit/$1';
$route['admin/role/(:num)/update']['post'] = 'AccessController/User_role_controller/update/$1';
$route['admin/role/(:num)/delete'] = 'AccessController/User_role_controller/delete/$1';


// manage color router
$route['admin/color'] = 'ColorController/index';
$route['admin/color/add-edit/?(:num)?'] = 'ColorController/addEditColor/$1';
$route['admin/color/delete/(:num)'] = 'ColorController/deleteUnit/$1';


// manage size router
$route['admin/size'] = 'SizeController/index';
$route['admin/size/add-edit/?(:num)?'] = 'SizeController/addEditSize/$1';
$route['admin/size/delete/(:num)'] = 'SizeController/deleteSize/$1';

// user control routes
$route['admin/user']['get'] = 'AccessController/UserController/index';
$route['admin/user/create'] = 'AccessController/UserController/create';
$route['admin/user']['post'] = 'AccessController/UserController/store';
$route['admin/user/(:num)/edit'] = 'AccessController/UserController/edit/$1';
$route['admin/user/(:num)/update']['post'] = 'AccessController/UserController/update/$1';
$route['admin/user/(:num)/delete'] = 'AccessController/UserController/delete/$1';

// user control routes
$route['admin/permission']['get'] = 'AccessController/PermissionController/index';
$route['admin/permission/create'] = 'AccessController/PermissionController/create';
$route['admin/permission']['post'] = 'AccessController/PermissionController/store';
$route['admin/permission/(:num)/edit'] = 'AccessController/PermissionController/edit/$1';
$route['admin/permission/(:num)/update']['post'] = 'AccessController/PermissionController/update/$1';
$route['admin/permission/(:num)/delete'] = 'AccessController/PermissionController/delete/$1';



//admin ajax model controller
$route['admin/ajax/get-order-edit-info']['post'] = 'AjaxOrderController/get_order_edit_modal';
$route['admin/ajax/update-order-quick-info']['post'] = 'AjaxOrderController/updateOrderQuickInfo';
$route['admin/ajax/order-mark-complete/(:num)']['post'] = 'AjaxOrderController/order_mark_complete/$1';
$route['admin/editor/image-upload'] = 'Page/editor_image_upload';
