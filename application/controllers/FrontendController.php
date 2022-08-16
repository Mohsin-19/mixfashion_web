<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class FrontendController extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Frontend');
    $this->load->model('Landing_model');
    $this->load->model('AttributeModel');
    $this->load->model('Announcement_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');
    check_remember_login(); // check remember me customer
  }


  public function getAllSubCategoryProducts($sub_cat_id, $type, $limit, $search = false, $offset = 0)
  {
    if ($search) {
      return $this->Frontend->getSearchProducts($limit, $search, $offset);
    } else {
      return $this->Frontend->getSubCategoryProducts($sub_cat_id, $type, $limit, $offset);
    }
  }

  // making ajax method
  function getSubCategory()
  {
    $id = $this->input->get_post('id');
    $type = $this->input->get_post('type');

    $data = [
      'category' => $this->Frontend->getCategoryById($id),
      'subCategories' => $this->Frontend->getSubCategoriesById($id),
    ];
    return $this->load->view('landing/ajax/subCategory', $data);
  }

  // making ajax method
  function getCategoryBySlug()
  {
    $slug = $this->input->get_post('slug');
    $category = $this->Frontend->getCategoryBySlug($slug, 1); // type 1 for category
    $subcategory = $this->Frontend->getCategoryBySlug($slug, 2); // type 2 for subcategory

    $data = [
      'child' => '',
      'category' => [],
      'slug' => $category,
    ];
    if ($category) {
      $cat_child = $this->Common_model->getCategorySubCategory($category->id);
      $data = [
        'category' => $category,
        'type' => 1,
        'child' => $cat_child ? true : '',
      ];
    }

    if ($subcategory) {
      $data = [
        'category' => $subcategory,
        'type' => 2,
        'child' => false,
      ];
    }
    return $this->responseJson($data);
  }



  // making ajax method
  function productDetails($id)
  {
    $product = $this->Landing_model->product_details($id);
    $data['product'] = $product;
    $data['related_products'] = $this->Landing_model->relatedProducts($product->category_id);

    $page['main_content'] = $this->load->view('landing/singleProducts', $data, true);
    $this->load->view('landing/landing_layout', $page);
  }

  function checkout()
  {
    $c_id = $this->session->userdata('c_id');
    if (!$c_id) {
      return redirect('login');
    }
    $data['districts'] = $this->Common_model->getAllByTable('tbl_areas');
    $page['main_content'] = $this->load->view('landing/checkout', $data, true);
    $this->load->view('landing/landing_layout', $page);
  }

  function payment()
  {
    $c_id = $this->session->userdata('c_id');
    if (!$c_id) {
      return redirect('login');
    }
    $cart = $this->session->userdata('cart');

    if (!$cart) {
      return redirect('checkout');
    }

    // dd($cart);

    $page['main_content'] = $this->load->view('landing/payment', [], true);
    $this->load->view('landing/landing_layout', $page);
  }


  function myOrders()
  {
    $c_id = $this->session->userdata('c_id');
    if (!$c_id) {
      return redirect('login');
    }

    $getSiteSetting = getSiteSetting();
    $currency = "$";
    if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
      $currency = $getSiteSetting->currency;
    }

    $orders = $this->Landing_model->getOrders();
    if ($orders && !empty($orders)) {
      $i = count($orders);
    }

    $data['currency'] = $currency;
    $data['orders'] = $this->Landing_model->getOrders();
    foreach ($data['orders'] as $ke => $val) {
      $data['orders'][$ke]->items = $this->Common_model->getDataCustomName("tbl_order_items", "order_id", $val->id);
    }

    $page['main_content'] = $this->load->view('landing/user/myOrders', $data, true);
    $this->load->view('landing/landing_layout', $page);
  }


  function getSubCategoryProducts()
  {
    $id = $this->input->post('id');
    $parent_id = $this->input->post('parent_id');
    $offset = $this->input->post('offset');
    $catData['status'] = false;
    $catData['landing'] = false;
    if ($parent_id) {
      $catData['category'] = $this->Frontend->getSubCategoryById($id);
      $catData['products'] = $this->getAllSubCategoryProducts($id, 2, 15, '', $offset);
      $catData['products'] = $this->load->view('landing/ajax/products', $catData, true);
      $catData['status'] = true;
    } else {
      $catData['category'] = $this->Frontend->getCategoryById($id);;
      $catData['products'] = $this->getAllSubCategoryProducts($id, 1, 15, '', $offset);
      $catData['products'] = $this->load->view('landing/ajax/products', $catData, true);
      $catData['status'] = true;
    }

    return responseJson($catData);
  }

  function searchProducts()
  {
    $string = $this->input->post('string');
    $offset = $this->input->post('offset');
    $scroll = $this->input->post('scroll');
    $data = [
      'search' => true,
      'landing' => false,
      'products' => $this->getAllSubCategoryProducts(0, 1, 15, $string, $offset),
    ];

    if ($scroll) {
      return responseJson([
        'status' => true,
        'products' => $this->load->view('landing/ajax/products', $data, true),
      ]);
    }
    return $this->load->view('landing/ajax/products', $data);
  }


  function searchPage($keywords)
  {
    echo $keywords;
  }


  function responseJson(array $array)
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($array));
  }


  public function xmlProductsFeed()
  {
    $data['products'] = $this->Frontend->get_product_xml();
    $this->load->view('landing/xml_products_feed', $data);
  }
}
