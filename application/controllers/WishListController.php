<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class WishListController extends Cl_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Landing_model');
    $this->load->library('form_validation');
  }

  /**
   * landing page view page
   * @access public
   * @return void
   */
  public function index()
  {
    $user_id = $this->session->userdata('c_id');
    $wishlists = [];
    if ($user_id) {
      $wishlists = $this->Common_model->get_wishlist($user_id);
    }
    $data['main_content'] = $this->load->view('landing/wishlist', ['wishlists' => $wishlists], true);
    $this->load->view('landing/landing_layout', $data);
  }


  public function add_wishlist($product_id)
  {
    $user_id = $this->session->userdata('c_id');
    if (!$user_id) {
      return responseJson([
        'status' => false,
        'msg' => 'Please login first',
        'wishlist' => [],
      ]);
    }
    if (!$product_id) {
      return responseJson([
        'status' => false,
        'msg' => 'Product not found for add to wishlist',
        'wishlist' => [],
      ]);
    }

    $results = $this->Common_model->updateOrInsertWishlist($product_id, $user_id);

    return responseJson([
      'status' => true,
      'msg' => 'Product add to wishlist successfully',
      'wishlist' => $results,
    ]);
  }


  public function remove_wishlist($product_id)
  {
    $user_id = $this->session->userdata('c_id');
    if (!$user_id) {
      return responseJson([
        'status' => false,
        'msg' => 'Please login first',
        'wishlist' => [],
      ]);
    }
    if (!$product_id) {
      return responseJson([
        'status' => false,
        'msg' => 'Product not found for add to wishlist',
        'wishlist' => [],
      ]);
    }

    $results = $this->Common_model->removeFromWishlist($product_id, $user_id);

    return responseJson([
      'status' => true,
      'msg' => 'Product remove successfully',
      'wishlist' => $results,
    ]);
  }

  public function get_wishlist()
  {
    $user_id = $this->session->userdata('c_id');
    $data['status'] = false;
    $data['wishlist'] = [];
    if ($user_id) {
      $wishlist = $this->Common_model->get_wishlist($user_id);
      if (count($wishlist)) {
        $data['status'] = true;
        $data['wishlist'] = $wishlist;
      }
    }
    return responseJson($data);
  }
}
