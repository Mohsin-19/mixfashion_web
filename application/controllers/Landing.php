<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends Cl_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('text');
    $this->load->helper('cookie');
    $this->load->model('Common_model');
    $this->load->model('Landing_model');
    $this->load->model('Frontend');
    $this->load->model('Announcement_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

    check_remember_login(); // check remember me customer
  }

  /**
   * landing page view page
   * @access public
   * @return void
   */
  public function index()
  {
    $data = $this->initialization_data();
    $data['main_content'] = $this->load->view('landing/index', $data, true);
    $this->load->view('landing/landing_layout', $data);
  }

  public function login()
  {
    $c_id = $this->session->userdata('c_id');
    if ($c_id) {
      return redirect('/');
    }

    $data['google_auth_url'] = $this->google_authenticate_url();
    $data['facebook_auth_url'] = $this->facebook_authenticate_url();
    $data['social_login_msg'] = $this->social_login_msg();

    $page['main_content'] = $this->load->view('landing/login', $data, true);
    $this->load->view('landing/landing_layout', $page);
  }


  public function signup()
  {
    $data['all_categories'] = $this->Landing_model->getCategories();
    $data['special_categories'] = $this->Landing_model->specialCategories();
    $data['search_page'] = 1;
    $data['pages'] = $this->Landing_model->pages();
    $data['google_auth_url'] = $this->google_authenticate_url();
    $data['facebook_auth_url'] = $this->facebook_authenticate_url();
    $data['social_login_msg'] = $this->social_login_msg();
    $this->load->view('landing/signup', $data);
  }

  /**
   * Contact form Send email
   */
  public function send_phone_number()
  {
    $name = $this->input->post('name');
    $phone = $this->input->post('phone');
    $email = $this->input->post('email');
    $message = $this->input->post('message');


    $table = '
   <table style="width: 100%;
   border-collapse: collapse;border:1px solid gray;">
 <thead>
   <tr style="border:1px solid gray;">
     <th scope="col" style="border:1px solid gray;">Name</th>
     <th scope="col" style="border:1px solid gray;">Phone Number</th>
     <th scope="col" style="border:1px solid gray;">Email</th>
     <th scope="col" style="border:1px solid gray;">Message</th>
   </tr>
 </thead>
 <tbody>
   <tr style="border:1px solid gray;">
     <th scope="row" style="border:1px solid gray;">' . $name . '</th>
     <th scope="row" style="border:1px solid gray;">' . $phone . '</th>
     <th scope="row" style="border:1px solid gray;">' . $email . '</th>
     <th scope="row" style="border:1px solid gray;">' . $message . '</th>
   </tr>
 </tbody>
</table>    
   ';
    //  dd($table);
    sendEmailWithPhoneNumber($table, 'sumon4skf@gmail.com', "", 1);

    return responseJson(['type' => true, 'msg' => 'Your contact submit successfully']);
  }



  public function test_atachmentDoc()
  {
    // only for testing
    $data['order'] = $this->Common_model->getOrderData(225);
    $data['items'] = $this->Common_model->getOrderItems(225);
    $data['outlet_information'] = $this->Common_model->getDataById($this->session->userdata('outlet_id'), "tbl_outlets");
    $this->load->library('pdf');
    $html = $this->load->view('order_management/pdf_invoice.php', $data, true);
    //    $attach = $this->pdf->createPDF($html, 225, false);
    //    $attach = $this->pdf->createPDF_forAttachemnt($html, 232, false);

    sendEmail($html, 'sumon4skf@gmail.com', '', 1);


    dd('ok');
  }

  public function initialization_data()
  {
    $data['announcement'] = $this->Announcement_model->getAnnouncement();
    $data['offer_products'] = $this->Landing_model->getOfferProductsWithStock();
    $data['category_new_products'] = $this->Landing_model->categoryNewProduct();

    $data['category_men']['category'] = $this->Landing_model->category_details(44);
    $data['category_men']['products'] = $this->Landing_model->categoryProducts(44);

    $data['category_women']['category'] = $this->Landing_model->category_details(45);
    $data['category_women']['products'] = $this->Landing_model->categoryProducts(45);

    $data['category_jewellery']['category'] = $this->Landing_model->category_details(47);
    $data['category_jewellery']['products'] = $this->Landing_model->categoryProducts(47);


    $data['all_slides'] = $this->Landing_model->getActiveSlides();
    $data['all_categories'] = $this->Landing_model->getCategories();
    $data['all_special_categories'] = $this->Landing_model->getSpecialCategories();
    $data['special_categories'] = $this->Landing_model->specialCategories();
    foreach ($data['all_categories'] as $key => $value) {
      $data['all_categories'][$key]->all_products = $this->Landing_model->getCatItems($value->id);
    }
    $data['subcats'] = $this->Common_model->getAllByTable("tbl_product_sub_categories");
    $data['arees'] = $this->Common_model->getAllByTable("tbl_areas");

    foreach ($data['all_categories'] as $key => $value) {
      $data['all_categories'][$key]->subcategories = $this->Common_model->getDataCustomName("tbl_product_sub_categories", "cat_id", $value->id);
    }
    foreach ($data['all_special_categories'] as $key => $value) {
      $data['all_special_categories'][$key]->subcategories = $this->Common_model->getDataCustomName("tbl_product_sub_categories", "cat_id", $value->id);
    }

    return $data;
  }

  public function google_authenticate_url()
  {
    //for google login
    include_once APPPATH . "libraries/vendor/autoload.php";
    $google_client = new Google_Client();
    $google_client->setClientId('878263952891-q67rikl2aao26q7vd2rg0rld9r5e9982.apps.googleusercontent.com'); //Define your ClientID
    $google_client->setClientSecret('sMMVnsxnGaeRdCk5N3tzHJ7r'); //Define your Client Secret Key
    $google_client->setRedirectUri(site_url('googleLogin')); //Define your Redirect Uri
    $google_client->addScope('email');
    $google_client->addScope('profile');
    return $google_client->createAuthUrl();
  }

  public function facebook_authenticate_url()
  {
    // Load facebook oauth library
    $this->load->library('facebook');
    /*  $this->facebook->destroy_session();*/
    return $this->facebook->login_url();
  }

  public function social_login_msg()
  {
    $c_login_type_message = $this->session->userdata('c_login_type_message');
    $this->session->unset_userdata('c_login_type_message');
    return isset($c_login_type_message) && $c_login_type_message ? $c_login_type_message : '';
  }



  public function Pages($slug)
  {
    $category = $this->Common_model->getCategoryBySlug($slug, 1); // type = 1 for category

    if ($category) {
      $subcategory = $this->Common_model->getCategorySubCategory($category->id);
      $catData['category'] = $category;
      if ($subcategory) {
        $catData['subcategory'] = $this->Common_model->getCategorySubCategory($category->id);
        $catData['products'] = $this->Common_model->getSubCategoryProducts($category->id, 1, 15);
        $data['main_content'] = $this->load->view('landing/category', $catData, true);
        return $this->load->view('landing/landing_layout', $data);
      } else {
        $catData['products'] = $this->Common_model->getSubCategoryProducts($category->id, 1, 15);
        $data['main_content'] = $this->load->view('landing/products', $catData, true);
        return $this->load->view('landing/landing_layout', $data);
      }
    } else {
      $subcategory = $this->Common_model->getCategoryBySlug($slug, 2); // type = 1 for category

      if ($subcategory) {
        $catData['category'] = $subcategory;
        $catData['products'] = $this->Common_model->getSubCategoryProducts($subcategory->id, 2, 15);
        $data['main_content'] = $this->load->view('landing/products', $catData, true);
        return $this->load->view('landing/landing_layout', $data);
      } else {
        $page = $this->Common_model->getSinglePage($slug);
        if ($page) {
          $data['main_content'] = $this->load->view('landing/page', ['page' => $page], true);
          return $this->load->view('landing/landing_layout', $data);
        }
      }
    }

    $data['main_content'] = $this->load->view('landing/404', [], true);
    $this->load->view('landing/landing_layout', $data);
  }


  public function contact_us()
  {
    $page = $this->Common_model->getSinglePage('contact-us');
    $data['main_content'] = $this->load->view('landing/contact_us', ['page' => $page], true);
    $this->load->view('landing/landing_layout', $data);
  }


  public function searchPage($string)
  {
    $data['search_products'] = $this->Frontend->getSearchProducts(15, $string, 0);
    $data['landing'] = false;
    $data['search'] = 'search';
    $this->load->view('landing/landing_layout', $data);
  }



  public function ErrorPage()
  {
    $data['refresh'] = 'error';
    $data['main_content'] = $this->load->view('landing/404', $data, true);
    $this->load->view('landing/landing_layout', $data);
  }


  /**
   * frontend customer logout function
   * @access public
   * @return void
   */
  public function logout()
  {
    $this->session->unset_userdata('c_id');
    $this->session->unset_userdata('c_name');
    $this->session->unset_userdata('c_photo');
    $this->session->unset_userdata('c_phone');
    $this->session->unset_userdata('c_address');
    $this->session->unset_userdata('c_email');
    $this->session->unset_userdata('c_status');
    $this->session->unset_userdata('is_otp_verified');
    $this->session->unset_userdata('cart');
    delete_cookie('_token');
    redirect("/");
  }




  public function add_wishlist()
  {
    $uid = $this->session->userdata('c_id');
    $data = array(
      'product_id' => $this->input->post('product_id'),
      'user_id' => $uid,
      'is_purchase' => null
    );

    $this->db->where('product_id', $this->input->post('product_id'));
    $this->db->where('user_id', $uid);
    $this->db->where('is_purchase', null);
    $query = $this->db->get('tbl_wishlists');
    $wishlists = $query->result();
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      echo 'already added';
    } else {
      $this->load->model('Common_model');
      $result = $this->Common_model->wishlist_datas($data);
      if ($result) {
        echo  true;
      } else {
        echo  0;
      }
    }
  }
  public function delete_wishlist()
  {
    $pid = $this->input->post('product_id');
    $uid = $this->session->userdata('c_id');
    $this->Common_model->delwlist($pid, $uid);
  }

  public function get_wishlist()
  {
    $user_id = $this->session->userdata('c_id');
    $wishlist = $this->Common_model->get_wishlist($user_id);
    $data['status'] = false;
    if (count($wishlist)) {
      $data['status'] = true;
      $data['wishlist'] = $wishlist;
    }
    return responseJson($data);
  }
}
