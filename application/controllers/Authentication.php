<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('cookie');
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Site_setting_model');
    $this->load->library('form_validation');
    check_remember_login_for_admin();
  }

  /**
   * login index view
   * @access public
   * @return void
   */
  public function index()
  {
    if ($this->session->userdata('user_id')) {
      //If the user is Super Admin
      if ($this->session->userdata('role') == 'Super Admin') {
        redirect("Admin/adminProfile");
      } elseif ($this->session->userdata('role') == 'Admin') {
        redirect("Authentication/userProfile");
      } else {
        redirect("Authentication/userProfile");
      }
    } else {
      $this->load->view('authentication/login');
    }
  }

  public function no_permission()
  {
    $data = array();
    $data['main_content'] = $this->load->view('authentication/no-permission', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * download file
   * @access public
   * @param string
   * @return void
   */
  public function downloadPDF($file = "")
  {
    // load ci download helder
    $this->load->helper('download');
    $data = file_get_contents("asset/sample/" . $file); // Read the file's
    $name = $file;
    force_download($name, $data);
  }

  /**
   * check login data
   * @access public
   * @return void
   */
  public function loginCheck()
  {
    if ($this->input->post('submit') != 'submit') {
      redirect("Authentication/index");
    }

    $this->form_validation->set_rules('email', lang('email'), 'required|valid_email|max_length[50]');
    $this->form_validation->set_rules('password', lang('password'), "required|max_length[25]");
    if ($this->form_validation->run() == TRUE) {
      $email = htmlspecialchars($this->input->post('email'));
      $password = htmlspecialchars($this->input->post('password'));
      $remember_me = htmlspecialchars($this->input->post('remember_me'));
      $user_information = $this->Authentication_model->getUserInformation($email, $password);

      //If user exists
      if ($user_information) {
        //If the user is Active
        if ($user_information->active_status == 'Active') {

          if ($remember_me) {
            $data['remember_me'] = md5(remember_me_generate('_token2'));
            $this->Common_model->updateInformation($data, $user_information->id, "tbl_users");
          }

          $company_info = $this->Authentication_model->getCompanyInformation($user_information->company_id);
          $setting_info = getSiteSetting();

          //User Information
          $login_session = [
            'user_id' => $user_information->id,
            'language' => $user_information->language,
            'full_name' => $user_information->full_name,
            'phone' => $user_information->phone,
            'email_address' => $user_information->email_address,
            'role_name' => $user_information->role_name,
            'role_slug' => $user_information->role_slug,
            'photo' => $user_information->photo,
            'company_id' => $user_information->company_id,
            'outlet_id' => $company_info->outlet_id,
            'currency' => $setting_info->currency,
            'time_zone' => $setting_info->time_zone,
            'date_format' => $setting_info->date_format,
          ];
          //Set session
          $this->session->set_userdata($login_session);
          $outlet_details = $this->Common_model->getDataById($company_info->outlet_id, 'tbl_outlets');

          $outlet_id = $company_info->outlet_id;
          $outlet_session = array();
          $outlet_session['outlet_id'] = $company_info->outlet_id;
          $outlet_session['tax_is_gst'] = $outlet_details->tax_is_gst;
          $outlet_session['gst_state_code'] = $outlet_details->state_code;
          $outlet_session['outlet_name'] = $outlet_details->outlet_name;
          $outlet_session['address'] = $outlet_details->address;
          $outlet_session['phone'] = $outlet_details->phone;
          $outlet_session['collect_tax'] = $outlet_details->collect_tax;
          $outlet_session['tax_registration_no'] = $outlet_details->tax_registration_no;
          $outlet_session['invoice_print'] = $outlet_details->invoice_print;
          $outlet_session['print_format'] = $outlet_details->print_format;
          $outlet_session['invoice_footer'] = $outlet_details->invoice_footer;
          $outlet_session['pre_or_post_payment'] = $outlet_details->pre_or_post_payment;
          $outlet_session['sms_setting_check'] = $outlet_details->sms_setting_check;
          $outlet_session['qty_setting_check'] = $outlet_details->qty_setting_check;
          $outlet_session['invoice_logo'] = $outlet_details->invoice_logo;
          $outlet_session['product_modal_status'] = $outlet_details->product_modal_status;
          $this->session->set_userdata($outlet_session);

          redirect("Authentication/userProfile");
        } else {
          $this->session->set_flashdata('exception_1', lang('user_not_active'));
          redirect('Authentication/index');
        }
      } else {
        $this->session->set_flashdata('exception_1', lang('incorrect_email_password'));
        redirect('Authentication/index');
      }
    } else {
      $this->load->view('authentication/login');
    }
  }

  /**
   * payment not clear
   * @access public
   * @return void
   */
  public function paymentNotClear()
  {
    if (!$this->session->has_userdata('customer_id')) {
      redirect('Authentication/index');
    }
    $this->load->view('authentication/paymentNotClear');
  }

  /**
   * user profile view
   * @access public
   * @return void
   */
  public function userProfile()
  {
    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }

    //        sendEmail('abcd', 'sumon4skf@gmail.com', '', 1);

    //        $profile = $this->session->get_userdata('function_access');
    //        echo '<pre>';
    //        var_dump($profile['function_access']);
    //        echo '</pre>';
    //        die();

    $data = array();
    $data['main_content'] = $this->load->view('authentication/userProfile', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * company profile view
   * @access public
   * @return void
   */
  public function companyProfile()
  {
    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }
    $data = array();
    $company_id = $this->session->userdata('company_id');
    $data['company_information'] = $this->Common_model->getDataById($company_id, 'tbl_companies');
    $data['main_content'] = $this->load->view('authentication/updateCompanyProfile', $data, TRUE);
    $this->load->view('outlet/outletHome', $data);
  }

  /**
   * change password
   * @access public
   * @return void
   */
  public function changePassword()
  {
    //start check access function
    $segment_2 = $this->uri->segment(2);
    $segment_3 = $this->uri->segment(3);

    $controller = "24";
    $function = "";
    if ($segment_2 == "changePassword") {
      $function = "changePassword";
    } else {
      redirect('Authentication/userProfile');
    }

    if (!checkAccess($controller, $function)) {
      redirect('Authentication/userProfile');
    }
    //end check access function


    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }
    if ($this->input->post('submit') == 'submit') {
      $this->form_validation->set_rules('old_password', lang('old_password'), 'required|max_length[50]');
      $this->form_validation->set_rules('new_password', lang('new_password'), 'required|max_length[50]|min_length[6]');
      if ($this->form_validation->run() == TRUE) {
        $old_password = htmlspecialchars($this->input->post('old_password'));
        $user_id = $this->session->userdata('user_id');

        $password_check = $this->Authentication_model->passwordCheck(md5($old_password), $user_id);

        if ($password_check) {
          $new_password = md5($this->input->post($this->security->xss_clean('new_password')));

          $this->Authentication_model->updatePassword($new_password, $user_id);

          //send email
          $emailSetting = getSMTPSetting();
          $getSiteSetting = getSiteSetting();
          $txt = "Your new password is : " . $new_password;
          if ($emailSetting->enable_status == 1) {
            sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $this->session->userdata('email_address'), $attached = '', $getSiteSetting->email, "Changed Password");
          }
          //send sms
          $smsSetting = getSMSSetting();
          if ($smsSetting->enable_status == 1) {
            $status = mim_sms($txt, $this->session->userdata('phone'));
          } elseif ($smsSetting->enable_status == 2) {
            $status = mim_sms($txt, $this->session->userdata('phone'));
          }


          $this->session->set_flashdata('exception', lang('password_changed'));
          redirect('Authentication/changePassword');
        } else {
          $this->session->set_flashdata('exception_1', lang('old_password_not_match'));
          redirect('Authentication/changePassword');
        }
      } else {
        $data = array();
        $data['main_content'] = $this->load->view('authentication/changePassword', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['main_content'] = $this->load->view('authentication/changePassword', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * password change
   * @access public
   * @return void
   */
  public function passwordChange()
  {

    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }
    if ($this->input->post('submit') == 'submit') {
      $this->form_validation->set_rules('old_password', lang('old_password'), 'required|max_length[50]');
      $this->form_validation->set_rules('new_password', lang('new_password'), 'required|max_length[50]|min_length[6]');
      if ($this->form_validation->run() == TRUE) {
        $old_password = htmlspecialchars($this->input->post('old_password'));
        $user_id = $this->session->userdata('user_id');

        $password_check = $this->Authentication_model->passwordCheck($old_password, $user_id);

        if ($password_check) {
          $new_password = htmlspecialchars($this->input->post('new_password'));

          $this->Authentication_model->updatePassword($new_password, $user_id);

          $this->session->set_flashdata('exception', lang('password_changed'));
          redirect('Authentication/passwordChange');
        } else {
          $this->session->set_flashdata('exception_1', lang('old_password_not_match'));
          redirect('Authentication/passwordChange');
        }
      } else {
        $data = array();
        $data['main_content'] = $this->load->view('authentication/passwordChange', $data, TRUE);
        $this->load->view('outlet/outletHome', $data);
      }
    } else {
      $data = array();
      $data['main_content'] = $this->load->view('authentication/passwordChange', $data, TRUE);
      $this->load->view('outlet/outletHome', $data);
    }
  }

  /**
   * forgot password
   * @access public
   * @return void
   */
  public function forgotPassword()
  {
    $this->load->view('authentication/forgotPassword');
  }

  /**
   * send auto password
   * @access public
   * @return void
   */
  public function sendAutoPassword()
  {
    if ($this->input->post('submit') == 'submit') {
      $this->form_validation->set_rules('email_address', lang('email_address'), 'required|valid_email|callback_checkEmailAddressExistance');
      if ($this->form_validation->run() == TRUE) {
        $email_address = htmlspecialchars($this->input->post('email_address'));
        $user_details = $this->Authentication_model->getAccountByMobileNo($email_address);
        if ($user_details) {
          $user_id = $user_details->id;
          $auto_generated_password = mt_rand(100000, 999999);
          $this->Authentication_model->updatePassword(md5($auto_generated_password), $user_id);

          //send email
          $emailSetting = getSMTPSetting();
          $getSiteSetting = getSiteSetting();
          $txt = "Your new password is : " . $auto_generated_password;
          if ($emailSetting->enable_status == 1) {
            sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email_address, $attached = '', $getSiteSetting->email, "Changed Password");
          }
          //send sms
          $smsSetting = getSMSSetting();
          if ($smsSetting->enable_status == 1) {
            $status = mim_sms($txt, $user_details->phone);
          } elseif ($smsSetting->enable_status == 2) {
            $status = mim_sms($txt, $user_details->phone);
          }
        }


        $this->load->view('authentication/forgotPasswordSuccess');
      } else {
        $this->load->view('authentication/forgotPassword');
      }
    } else {
      $this->load->view('authentication/forgotPassword');
    }
  }

  /**
   * check email before add data
   * @access public
   * @return boolean
   */
  public function checkEmailAddressExistance()
  {
    $email_address = htmlspecialchars($this->input->post('email_address'));

    $checkEmailAddressExistance = $this->Authentication_model->getAccountByMobileNo($email_address);

    if (isset($checkEmailAddressExistance) && $checkEmailAddressExistance) {
      return true;
    } else {
      $this->form_validation->set_message('checkEmailAddressExistance', 'Email Address does not exist');
      return false;
    }
  }

  /**
   * add/edit Organization
   * @access public
   * @return void
   */
  public function logOut()
  {
    //User Information
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('full_name');
    $this->session->unset_userdata('phone');
    $this->session->unset_userdata('email_address');
    $this->session->unset_userdata('role');
    $this->session->unset_userdata('customer_id');
    $this->session->unset_userdata('company_id');
    $this->session->unset_userdata('is_otp_verified');

    //Shop Information
    $this->session->unset_userdata('outlet_id');
    $this->session->unset_userdata('outlet_name');
    $this->session->unset_userdata('address');
    $this->session->unset_userdata('phone');
    $this->session->unset_userdata('collect_tax');
    $this->session->unset_userdata('tax_registration_no');
    $this->session->unset_userdata('invoice_print');
    $this->session->unset_userdata('print_select');
    $this->session->unset_userdata('kot_print');
    $this->session->unset_userdata('qty_setting_check');
    $this->session->unset_userdata('product_modal_status');
    $this->session->unset_userdata('sms_setting_check');


    //company Information
    $this->session->unset_userdata('currency');
    $this->session->unset_userdata('time_zone');
    $this->session->unset_userdata('date_format');
    $this->session->unset_userdata('function_access');
    $this->session->unset_userdata('customer');

    delete_cookie('_token2');

    redirect('Authentication/index');
  }

  /**
   * setting view
   * @access public
   * @param int
   * @return void
   */
  public function setting($id = '')
  {
    if ($this->session->userdata('role') == 'Admin') {
    } else {
      redirect("Authentication/userProfile");
    }


    $company_id = $this->session->userdata('company_id');

    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('date_format', lang('date_format'), "required|max_length[50]");
      $this->form_validation->set_rules('time_zone', lang('country_time_zone'), "required|max_length[50]");
      $this->form_validation->set_rules('currency', lang('currency'), "required|max_length[3]");
      if ($this->form_validation->run() == TRUE) {
        $org_information = array();
        $org_information['date_format'] = htmlspecialchars($this->input->post('date_format'));
        $org_information['time_zone'] = htmlspecialchars($this->input->post('time_zone'));
        $org_information['currency'] = htmlspecialchars($this->input->post('currency'));
        $org_information['white_label_status'] = htmlspecialchars($this->input->post('white_label_status'));
        $org_information['company_id'] = $this->session->userdata('company_id');

        $this->Common_model->updateInformation($org_information, $id, "tbl_settings");
        $this->session->set_flashdata('exception', lang('update_success'));
        //set session on update
        $this->session->set_userdata('currency', $org_information['currency']);
        $this->session->set_userdata('time_zone', $org_information['time_zone']);
        $this->session->set_userdata('date_format', $org_information['date_format']);
        redirect('Authentication/setting/' . $org_information['company_id']);
      } else {
        $data = array();
        $data['setting_information'] = $this->Authentication_model->getSettingInformation($company_id);
        $data['time_zones'] = $this->Common_model->getAllForDropdown("tbl_time_zone");
        $data['main_content'] = $this->load->view('authentication/setting', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['setting_information'] = $this->Authentication_model->getSettingInformation($company_id);
      $data['time_zones'] = $this->Common_model->getAllForDropdown("tbl_time_zone");
      $data['main_content'] = $this->load->view('authentication/setting', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * site setting view
   * @access public
   * @param int
   * @return void
   */
  public function siteSetting($id = '')
  {
    $company_id = $this->session->userdata('company_id');
    $id = htmlspecialchars($this->input->post('id'));

    if ($this->input->post('submit')) {

      check_permission('edit_setting');

      $this->form_validation->set_rules('site_title', lang('site_title'), 'required|max_length[300]');
      $this->form_validation->set_rules('footer', lang('footer'), 'required|max_length[300]');
      $this->form_validation->set_rules('base_color', lang('base_color'), 'required|max_length[100]');
      $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[100]');
      $this->form_validation->set_rules('email', lang('email'), 'required|valid_email|max_length[100]');
      $this->form_validation->set_rules('address', lang('address'), 'required|max_length[300]');
      $this->form_validation->set_rules('currency', lang('currency'), 'required|max_length[300]');
      $this->form_validation->set_rules('date_format', lang('date_format'), 'required|max_length[300]');
      $this->form_validation->set_rules('time_zone', lang('country_time_zone'), 'required|max_length[300]');
      $this->form_validation->set_rules('vat', lang('vat'));
      $this->form_validation->set_rules('site_languages_h', lang('site_languages'), 'required|max_length[300]');
      $this->form_validation->set_rules('default_language_frontend', lang('defaultLanguageforFrontend'), 'required|max_length[300]');

      if ($_FILES['site_logo']['name'] != "") {
        $this->form_validation->set_rules('site_logo', lang('site_logo'), 'callback_validate_site_logo');
      }
      if ($_FILES['favicon']['name'] != "") {
        $this->form_validation->set_rules('favicon', lang('favicon'), 'callback_validate_favicon');
      }
      if ($_FILES['login_page_bg']['name'] != "") {
        $this->form_validation->set_rules('login_page_bg', lang('login_page_bg'), 'callback_validate_login_page_bg');
      }

      if ($_FILES['frontend_offer_banner_image']['name'] != "") {
        $this->form_validation->set_rules('frontend_offer_banner_image', lang('frontend_offer_banner_image'), 'callback_validate_frontend_offer_banner_image');
      }

      if ($_FILES['frontend_middle_image_1']['name'] != "") {
        $this->form_validation->set_rules('frontend_middle_image_1', lang('frontend_middle_image_1'), 'callback_validate_frontend_middle_image_1');
      }
      if ($_FILES['frontend_middle_image_2']['name'] != "") {
        $this->form_validation->set_rules('frontend_middle_image_2', lang('frontend_middle_image_2'), 'callback_validate_frontend_middle_image_2');
      }
      if ($_FILES['frontend_middle_image_3']['name'] != "") {
        $this->form_validation->set_rules('frontend_middle_image_3', lang('frontend_middle_image_3'), 'callback_validate_frontend_middle_image_3');
      }

      if ($this->form_validation->run() == TRUE) {
        $data = array();
        $data['site_title'] = htmlspecialchars($this->input->post('site_title'));
        $data['footer'] = htmlspecialchars($this->input->post('footer'));
        $data['base_color'] = htmlspecialchars($this->input->post('base_color'));
        $data['phone'] = htmlspecialchars($this->input->post('phone'));
        $data['email'] = htmlspecialchars($this->input->post('email'));
        $data['address'] = htmlspecialchars($this->input->post('address'));
        $data['currency'] = htmlspecialchars($this->input->post('currency'));
        $data['date_format'] = htmlspecialchars($this->input->post('date_format'));
        $data['time_zone'] = htmlspecialchars($this->input->post('time_zone'));
        $data['vat'] = htmlspecialchars($this->input->post('vat'));
        $data['facebook_link'] = htmlspecialchars($this->input->post('facebook_link'));
        $data['default_language_frontend'] = htmlspecialchars($this->input->post('default_language_frontend'));
        $data['product_hover_effect'] = htmlspecialchars($this->input->post('product_hover_effect'));
        $data['twitter_link'] = htmlspecialchars($this->input->post('twitter_link'));
        $data['pinterest_link'] = htmlspecialchars($this->input->post('pinterest_link'));
        $data['frontend_offer_banner_url'] = htmlspecialchars($this->input->post('frontend_offer_banner_url'));
        $site_languages = $this->input->post('site_languages');
        $arr = array();
        foreach ($site_languages as $value) {
          $data1['value'] = $value;
          $arr[] = $data1;
        }
        $data['site_languages'] = json_encode($arr);

        if ($_FILES['site_logo']['name'] != "") {
          $data['site_logo'] = $this->session->userdata('site_logo');;
          $this->session->unset_userdata('site_logo');
          @unlink("./assets/images/" . $this->input->post('old_site_logo'));
        } else {
          $data['site_logo'] = $this->input->post('old_site_logo');
        }

        if ($_FILES['favicon']['name'] != "") {
          $data['favicon'] = $this->session->userdata('favicon');;
          $this->session->unset_userdata('favicon');
          @unlink("./assets/images/" . $this->input->post('old_favicon'));
        } else {
          $data['favicon'] = $this->input->post('old_favicon');
        }

        if ($_FILES['login_page_bg']['name'] != "") {
          $data['login_page_bg'] = $this->session->userdata('login_page_bg');;
          $this->session->unset_userdata('login_page_bg');
          @unlink("./assets/images/" . $this->input->post('old_login_page_bg'));
        } else {
          $data['login_page_bg'] = $this->input->post('old_login_page_bg');
        }

        if ($_FILES['frontend_offer_banner_image']['name'] != "") {
          $data['frontend_offer_banner_image'] = $this->session->userdata('frontend_offer_banner_image');;
          $this->session->unset_userdata('frontend_offer_banner_image');
          @unlink("./assets/images/" . $this->input->post('old_frontend_offer_banner_image'));
        } else {
          $data['frontend_offer_banner_image'] = $this->input->post('frontend_offer_banner_image');
        }

        if ($_FILES['frontend_middle_image_1']['name'] != "") {
          $data['frontend_middle_image_1'] = $this->session->userdata('frontend_middle_image_1');;
          $this->session->unset_userdata('frontend_middle_image_1');
          @unlink("./assets/images/" . $this->input->post('old_frontend_middle_image_1'));
        } else {
          $data['frontend_middle_image_1'] = $this->input->post('old_frontend_middle_image_1');
        }

        if ($_FILES['frontend_middle_image_2']['name'] != "") {
          $data['frontend_middle_image_2'] = $this->session->userdata('frontend_middle_image_2');;
          $this->session->unset_userdata('frontend_middle_image_2');
          @unlink("./assets/images/" . $this->input->post('old_frontend_middle_image_2'));
        } else {
          $data['frontend_middle_image_2'] = $this->input->post('old_frontend_middle_image_2');
        }

        if ($_FILES['frontend_middle_image_3']['name'] != "") {
          $data['frontend_middle_image_3'] = $this->session->userdata('frontend_middle_image_3');;
          $this->session->unset_userdata('frontend_middle_image_3');
          @unlink("./assets/images/" . $this->input->post('old_frontend_middle_image_3'));
        } else {
          $data['frontend_middle_image_3'] = $this->input->post('old_frontend_middle_image_3');
        }

        if ($id == "") {
          $this->Common_model->insertInformation($data, "tbl_site_setting");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($data, $id, "tbl_site_setting");
          $this->session->set_flashdata('exception', lang('update_success'));

          $session_update['currency'] = htmlspecialchars($this->input->post('currency'));
          $session_update['date_format'] = htmlspecialchars($this->input->post('date_format'));
          $session_update['time_zone'] = htmlspecialchars($this->input->post('time_zone'));
          $this->session->set_userdata($session_update);
        }
        redirect('Authentication/siteSetting');
      } else {
        $data = array();
        $data['getSiteSetting'] = getSiteSetting();
        $data['currencies'] = $this->Common_model->getAllByTable("tbl_admin_currencies");
        $data['time_zones'] = $this->Common_model->getAllByTable("tbl_time_zone");
        $data['main_content'] = $this->load->view('authentication/siteSetting', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      check_permission(['site_setting', 'edit_setting']);
      $data = array();
      $data['getSiteSetting'] = getSiteSetting();
      $data['currencies'] = $this->Common_model->getAllByTable("tbl_admin_currencies");
      $data['time_zones'] = $this->Common_model->getAllByTable("tbl_time_zone");
      $data['main_content'] = $this->load->view('authentication/siteSetting', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * delivery time range view
   * @access public
   * @param int
   * @return void
   */
  public function deliveryTimeRange($id = '')
  {

    if ($this->input->post('submit')) {

      $date_name = $this->input->post('date_name');
      $s_time = $this->input->post('s_time');
      $e_time = $this->input->post('e_time');
      $r_arr = array();
      $i = 1;
      foreach ($date_name as $key => $value) {
        $status = "status_" . $i;
        $status = isset($_POST[$status]) && $_POST[$status] ? $_POST[$status] : '0';
        $data = array();
        $data['date_name'] = $value;
        $data['s_time'] = $s_time[$key];
        $data['e_time'] = $e_time[$key];
        $data['status'] = $status;
        $r_arr[] = $data;
        $i++;
      }
      $data = array();
      $data['deliverytimerange'] = json_encode($r_arr);
      if ($id == "") {
        $this->Common_model->insertInformation($data, "tbl_site_setting");
        $this->session->set_flashdata('exception', lang('insertion_success'));
      } else {
        $this->Common_model->updateInformation($data, $id, "tbl_site_setting");
        $this->session->set_flashdata('exception', lang('update_success'));
      }
      redirect('Authentication/deliveryTimeRange');
    } else {
      $data = array();
      $data['getSiteSetting'] = getSiteSetting();
      $data['main_content'] = $this->load->view('authentication/deliveryTimeRange', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * smtp email setting
   * @access public
   * @param int
   * @return void
   */
  public function smtpEmailSetting($id = '')
  {

    if ($this->input->post('submit')) {
      $enable_status = htmlspecialchars($this->input->post('enable_status'));
      $field_1 = htmlspecialchars($this->input->post('field_1'));
      $field_2 = htmlspecialchars($this->input->post('field_2'));
      $field_3 = htmlspecialchars($this->input->post('field_3'));
      $field_4 = htmlspecialchars($this->input->post('field_4'));
      $field_5 = htmlspecialchars($this->input->post('field_5'));
      $field_6 = htmlspecialchars($this->input->post('field_6'));
      $field_1_v = htmlspecialchars($this->input->post('field_1_v'));
      $field_2_v = htmlspecialchars($this->input->post('field_2_v'));
      $field_3_v = htmlspecialchars($this->input->post('field_3_v'));
      $field_4_v = htmlspecialchars($this->input->post('field_4_v'));
      $field_5_v = htmlspecialchars($this->input->post('field_5_v'));
      $field_6_v = htmlspecialchars($this->input->post('field_6_v'));
      $this->form_validation->set_rules('enable_status', "Enable Status", "max_length[50]");

      if ($enable_status == 1) {
        $this->form_validation->set_rules('host_name', "Host Name", "required|max_length[300]");
        $this->form_validation->set_rules('port_address', "Port Address", "required|max_length[300]");
        $this->form_validation->set_rules('user_name', "Username", "required|max_length[300]");
        $this->form_validation->set_rules('password', "Password", "required|max_length[300]");
      }

      if ($this->form_validation->run() == TRUE) {
        $data = array();
        $data['enable_status'] = htmlspecialchars($this->input->post('enable_status'));;
        $data['host_name'] = htmlspecialchars($this->input->post('host_name'));;
        $data['port_address'] = htmlspecialchars($this->input->post('port_address'));;
        $data['user_name'] = htmlspecialchars($this->input->post('user_name'));;
        $data['password'] = htmlspecialchars($this->input->post('password'));;

        $data['field_1'] = $field_1;
        $data['field_2'] = $field_2;
        $data['field_3'] = $field_3;
        $data['field_4'] = $field_4;
        $data['field_5'] = $field_5;
        $data['field_6'] = $field_6;

        $data['field_1_v'] = $field_1_v;
        $data['field_2_v'] = $field_2_v;
        $data['field_3_v'] = $field_3_v;
        $data['field_4_v'] = $field_4_v;
        $data['field_5_v'] = $field_5_v;
        $data['field_6_v'] = $field_6_v;

        if ($id == "") {
          $this->Common_model->insertInformation($data, "tbl_smtp_setting");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($data, $id, "tbl_smtp_setting");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Authentication/smtpEmailSetting');
      } else {
        $data = array();
        $data['smtEmail'] = getSMTPSetting();
        $data['users'] = $this->Common_model->getAllByTable("tbl_users");
        $data['main_content'] = $this->load->view('authentication/smtpEmailSetting', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['smtEmail'] = getSMTPSetting();
      $data['users'] = $this->Common_model->getAllByTable("tbl_users");
      $data['main_content'] = $this->load->view('authentication/smtpEmailSetting', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * payment setting
   * @access public
   * @param int
   * @return void
   */
  public function paymentSetting($id = '')
  {

    if ($this->input->post('submit')) {
      $field_1 = htmlspecialchars($this->input->post('field_1'));
      $field_2 = htmlspecialchars($this->input->post('field_2'));
      $field_3 = htmlspecialchars($this->input->post('field_3'));
      $field_4 = htmlspecialchars($this->input->post('field_4'));
      $field_5 = htmlspecialchars($this->input->post('field_5'));
      $field_1_v = htmlspecialchars($this->input->post('field_1_v'));
      $field_2_v = htmlspecialchars($this->input->post('field_2_v'));
      $field_3_v = htmlspecialchars($this->input->post('field_3_v'));
      $field_4_v = htmlspecialchars($this->input->post('field_4_v'));

      if ($field_1 == 1) {
        $this->form_validation->set_rules('field_1_key_1', "Store ID", "required");
        $this->form_validation->set_rules('field_1_key_2', "Signature Key", "required");
      }
      if ($field_2 == 1) {
        $this->form_validation->set_rules('field_2_key_1', "Client ID", "required");
        $this->form_validation->set_rules('field_2_key_2', "Secret Key", "required");
      }
      if ($field_3 == 1) {
        $this->form_validation->set_rules('field_3_key_1', "Stripe API Key", "required");
        $this->form_validation->set_rules('field_3_key_2', "Stripe Publishable Key", "required");
      }
      if ($field_4 == 1) {
        $this->form_validation->set_rules('field_4_key_1', "Store Key", "required");
        $this->form_validation->set_rules('field_4_key_2', "Store Password", "required");
      }

      if ($this->form_validation->run() == TRUE) {
        $data = array();
        $data['field_1'] = $field_1;
        $data['field_2'] = $field_2;
        $data['field_3'] = $field_3;
        $data['field_4'] = $field_4;
        $data['field_5'] = $field_5;

        $data['field_1_v'] = $field_1_v;
        $data['field_2_v'] = $field_2_v;
        $data['field_3_v'] = $field_3_v;
        $data['field_4_v'] = $field_4_v;

        $data['field_1_key_1'] = htmlspecialchars($this->input->post('field_1_key_1'));
        $data['field_1_key_2'] = htmlspecialchars($this->input->post('field_1_key_2'));
        $data['field_2_key_1'] = htmlspecialchars($this->input->post('field_2_key_1'));
        $data['field_2_key_2'] = htmlspecialchars($this->input->post('field_2_key_2'));
        $data['field_3_key_1'] = htmlspecialchars($this->input->post('field_3_key_1'));
        $data['field_3_key_2'] = htmlspecialchars($this->input->post('field_3_key_2'));
        $data['field_4_key_1'] = htmlspecialchars($this->input->post('field_4_key_1'));
        $data['field_4_key_2'] = htmlspecialchars($this->input->post('field_4_key_2'));


        if ($id == "") {
          $this->Common_model->insertInformation($data, "tbl_payment_setting");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($data, $id, "tbl_payment_setting");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Authentication/paymentSetting');
      } else {
        $data = array();
        $data['paymentSetting'] = paymentSetting();
        $data['main_content'] = $this->load->view('authentication/paymentSetting', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['paymentSetting'] = paymentSetting();
      $data['main_content'] = $this->load->view('authentication/paymentSetting', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * payment setting
   * @access public
   * @param int
   * @return void
   */

  public function googleLogin()
  {
    include_once APPPATH . "libraries/vendor/autoload.php";
    $google_client = new Google_Client();
    $google_client->setClientId('878263952891-q67rikl2aao26q7vd2rg0rld9r5e9982.apps.googleusercontent.com'); //Define your ClientID
    $google_client->setClientSecret('sMMVnsxnGaeRdCk5N3tzHJ7r'); //Define your Client Secret Key
    $google_client->setRedirectUri(site_url('googleLogin')); //Define your Redirect Uri

    $google_client->addScope('email');
    $google_client->addScope('profile');

    if (isset($_GET["code"])) {
      $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

      if (!isset($token["error"])) {
        $google_client->setAccessToken($token['access_token']);
        $this->session->set_userdata('access_token', $token['access_token']);
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        $data_db = array();
        $data_db['name'] = $data['name'];
        $data_db['email'] = $data['email'];
        $data_db['otp_code'] = 'google';
        $data_db['is_otp_verified'] = 1;
        $data_db['remember_token'] = md5(remember_me_generate());

        $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($data['email']);

        if ($checkExistingAccount) {
          $id = $checkExistingAccount->id;
          $return_data = array();
          $return_data['c_id'] = $checkExistingAccount->id;
          $return_data['c_name'] = $checkExistingAccount->name;
          $return_data['c_phone'] = $checkExistingAccount->phone;
          $return_data['c_address'] = $checkExistingAccount->address;
          $return_data['c_email'] = $checkExistingAccount->email;
          $return_data['c_login_type'] = "social_media";
          $return_data['c_login_type_message'] = "Successfully login with google account";
          $this->session->set_userdata($return_data);
          $token = [
            'remember_token' => $data_db['remember_token'],
          ];
          $this->Common_model->updateInformation($token, $id, "tbl_customers");
        } else {
          $id = $this->Common_model->insertInformation($data_db, "tbl_customers");
          $return_data = array();
          $return_data['c_id'] = $id;
          $return_data['c_name'] = $data['name'];
          $return_data['c_phone'] = '';
          $return_data['c_address'] = '';
          $return_data['c_email'] = $data['email'];
          $return_data['c_login_type'] = "social_media";
          $return_data['c_login_type_message'] = "Successfully Sign up and login with google account";
          $this->session->set_userdata($return_data);
        }

        $this->session->set_userdata(['customer' => getCustomerData($id)]);
      }
    }
    redirect('/');
  }

  /**
   * @return object
   */
  public function facebookLogin()
  {
    $this->load->library('facebook');
    $userData = array();

    // Authenticate user with facebook
    if ($this->facebook->is_authenticated()) {
      // Get user info from facebook
      $fbUser = $this->facebook->request('get', '/me?fields=first_name,last_name,email');

      // Preparing data for database insertion
      $userData['first_name'] = !empty($fbUser['first_name']) ? $fbUser['first_name'] : '';
      $userData['last_name'] = !empty($fbUser['last_name']) ? $fbUser['last_name'] : '';
      $userData['email'] = !empty($fbUser['email']) ? $fbUser['email'] : '';
      $data_db = array();
      $data_db['name'] = $userData['first_name'] . " " . $userData['last_name'];
      $data_db['email'] = $userData['email'];
      $data_db['otp_code'] = 'facebook';
      $data_db['is_otp_verified'] = 1;
      $data_db['remember_token'] = md5(remember_me_generate());

      if ($userData['email']) {
        $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($userData['email']);
        if ($checkExistingAccount) {
          $id = $checkExistingAccount->id;
          $return_data = array();
          $return_data['c_id'] = $checkExistingAccount->id;
          $return_data['c_name'] = $checkExistingAccount->name;
          $return_data['c_phone'] = $checkExistingAccount->phone;
          $return_data['c_address'] = $checkExistingAccount->address;
          $return_data['c_email'] = $checkExistingAccount->email;
          $return_data['c_login_type'] = "social_media";
          $return_data['c_login_type_message'] = "Successfully login with facebook account";
          $this->session->set_userdata($return_data);
          $token = [
            'remember_token' => $data_db['remember_token'],
          ];
          $this->Common_model->updateInformation($token, $id, "tbl_customers");
        } else {
          $id = $this->Common_model->insertInformation($data_db, "tbl_customers");
          $return_data = array();
          $return_data['c_id'] = $id;
          $return_data['c_name'] = $userData['first_name'] . " " . $userData['last_name'];
          $return_data['c_phone'] = '';
          $return_data['c_address'] = '';
          $return_data['c_email'] = $userData['email'];
          $return_data['c_login_type'] = "social_media";
          $return_data['c_login_type_message'] = "Successfully sing up and login with facebook account";
          $this->session->set_userdata($return_data);
          $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($userData['email']);
          $this->session->set_userdata(['customer' => $checkExistingAccount]);
        }

        $this->session->set_userdata(['customer' => getCustomerData($id)]);
      } else {
        $return_data['c_login_type_message'] = "No email address found following the facebook account";
        $this->session->set_userdata($return_data);
      }
    }
    redirect('/');
  }

  public function dummyData($action = '')
  {
    //start check access function
    $segment_2 = $this->uri->segment(2);
    $segment_3 = $this->uri->segment(3);

    $controller = "106";
    $function = "";

    if ($segment_2 == "dummyData") {
      $function = "view";
    } elseif ($segment_2 == "dummyData" && $segment_3) {
      $function = "edit";
    } else {
      redirect('Authentication/userProfile');
    }

    if (!checkAccess($controller, $function)) {
      redirect('Authentication/userProfile');
    }
    //end check access function

    if ($this->session->userdata('role') == 'Super Admin') {
    } elseif ($this->session->userdata('role') == 'Admin') {
    } else {
      redirect("Authentication/userProfile");
    }
    if ($action == "add") {
      $installer = json_decode(file_get_contents('asset/sample/dummy_data.json'), true);
      //before add the dummy data we need to truncate the tbl_products,tbl_product_categories,tbl_product_sub_categories
      $this->db->query("TRUNCATE tbl_products");
      $this->db->query("TRUNCATE tbl_product_categories");
      $this->db->query("TRUNCATE tbl_product_sub_categories");
      //add products
      foreach ($installer[2]['data'] as $key => $value) {
        $this->Common_model->insertInformation($installer[2]['data'][$key], "tbl_products");
      }
      //add categories
      foreach ($installer[3]['data'] as $key => $value) {
        $this->Common_model->insertInformation($installer[3]['data'][$key], "tbl_product_categories");
      }
      //add sub categories
      foreach ($installer[4]['data'] as $key => $value) {
        $this->Common_model->insertInformation($installer[4]['data'][$key], "tbl_product_sub_categories");
      }
      $this->session->set_flashdata('exception', lang('insertion_success'));
      redirect('Item/products');
    } else if ($action == "delete") {
      //Truncate the tbl_products,tbl_product_categories,tbl_product_sub_categories
      $this->db->query("TRUNCATE tbl_products");
      $this->db->query("TRUNCATE tbl_product_categories");
      $this->db->query("TRUNCATE tbl_product_sub_categories");
      $this->session->set_flashdata('exception', lang('delete_success'));
      redirect('authentication/dummyData');
    } else {
      $data = array();
      $data['main_content'] = $this->load->view('authentication/dummyData', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * sms setting
   * @access public
   * @param int
   * @return void
   */
  public function smsSetting($id = '')
  {


    if ($this->input->post('submit')) {
      $enable_status = htmlspecialchars($this->input->post('enable_status'));
      $field_1 = htmlspecialchars($this->input->post('field_1'));
      $field_2 = htmlspecialchars($this->input->post('field_2'));
      $field_3 = htmlspecialchars($this->input->post('field_3'));
      $field_4 = htmlspecialchars($this->input->post('field_4'));
      $field_5 = htmlspecialchars($this->input->post('field_5'));
      $field_6 = htmlspecialchars($this->input->post('field_6'));
      $field_1_v = htmlspecialchars($this->input->post('field_1_v'));
      $field_2_v = htmlspecialchars($this->input->post('field_2_v'));
      $field_3_v = htmlspecialchars($this->input->post('field_3_v'));
      $field_4_v = htmlspecialchars($this->input->post('field_4_v'));
      $field_5_v = htmlspecialchars($this->input->post('field_5_v'));
      $field_6_v = htmlspecialchars($this->input->post('field_6_v'));
      $this->form_validation->set_rules('enable_status', "Enable Status", "max_length[50]");

      if ($enable_status == 1) {
        $this->form_validation->set_rules('user_name', "User Name", "required|max_length[300]");
        $this->form_validation->set_rules('password', "Password", "required|max_length[300]");
      } else if ($enable_status == 2) {
        $this->form_validation->set_rules('user_name1', "User Name", "required|max_length[300]");
        $this->form_validation->set_rules('password1', "Password", "required|max_length[300]");
        $this->form_validation->set_rules('apikey', "APIKey", "required|max_length[300]");
      }

      if ($this->form_validation->run() == TRUE) {
        $data = array();
        $data['enable_status'] = htmlspecialchars($this->input->post('enable_status'));;
        $data['user_name1'] = htmlspecialchars($this->input->post('user_name1'));;
        $data['password1'] = htmlspecialchars($this->input->post('password1'));;
        $data['apikey'] = htmlspecialchars($this->input->post('apikey'));;
        $data['user_name'] = htmlspecialchars($this->input->post('user_name'));;
        $data['password'] = htmlspecialchars($this->input->post('password'));;

        $data['field_1'] = $field_1;
        $data['field_2'] = $field_2;
        $data['field_3'] = $field_3;
        $data['field_4'] = $field_4;
        $data['field_5'] = $field_5;
        $data['field_6'] = $field_6;

        $data['field_1_v'] = $field_1_v;
        $data['field_2_v'] = $field_2_v;
        $data['field_3_v'] = $field_3_v;
        $data['field_4_v'] = $field_4_v;
        $data['field_5_v'] = $field_5_v;
        $data['field_6_v'] = $field_6_v;

        if ($id == "") {
          $this->Common_model->insertInformation($data, "tbl_sms_setting");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($data, $id, "tbl_sms_setting");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Authentication/smsSetting');
      } else {
        $data = array();
        $data['smsSetting'] = getSMSSetting();
        $data['users'] = $this->Common_model->getAllByTable("tbl_users");
        $data['main_content'] = $this->load->view('authentication/smsSetting', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['smsSetting'] = getSMSSetting();
      $data['users'] = $this->Common_model->getAllByTable("tbl_users");
      $data['main_content'] = $this->load->view('authentication/smsSetting', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * delivery charge setup
   * @access public
   * @param int
   * @return void
   */
  public function deliveryChargeSetup($id = '')
  {

    if ($this->input->post('submit')) {

      $s_amount = $this->input->post('s_amount');
      $e_amount = $this->input->post('e_amount');
      $c_amount = $this->input->post('c_amount');
      $r_arr = array();
      $i = 1;
      foreach ($s_amount as $key => $value) {
        $data = array();
        $data['s_amount'] = $value;
        $data['e_amount'] = $e_amount[$key];
        $data['c_amount'] = $c_amount[$key];
        $r_arr[] = $data;
        $i++;
      }
      $data = array();
      $data['deliveryChargeSetup'] = json_encode($r_arr);
      if ($id == "") {
        $this->Common_model->insertInformation($data, "tbl_site_setting");
        $this->session->set_flashdata('exception', lang('insertion_success'));
      } else {
        $this->Common_model->updateInformation($data, $id, "tbl_site_setting");
        $this->session->set_flashdata('exception', lang('update_success'));
      }
      redirect('Authentication/deliveryChargeSetup');
    } else {
      $data = array();
      $data['getSiteSetting'] = getSiteSetting();
      $data['main_content'] = $this->load->view('authentication/deliveryChargeSetup', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * sms setting old
   * @access public
   * @param int
   * @return void
   */
  public function smsSettingOld($id = '')
  {
    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }
    if ($this->session->userdata('role') == 'Super Admin') {
    } elseif ($this->session->userdata('role') == 'Admin') {
    } else {
      redirect("Authentication/userProfile");
    }

    $company_id = $this->session->userdata('company_id');

    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('sms_username', lang('sms_username'), "required|max_length[50]");
      $this->form_validation->set_rules('password', lang('password'), "required|max_length[50]");
      if ($this->form_validation->run() == TRUE) {
        $sms_info = array();
        $sms_info['sms_username'] = htmlspecialchars($this->input->post('sms_username'));
        $sms_info['password'] = htmlspecialchars($this->input->post('password'));
        $sms_info['company_id'] = $this->session->userdata('company_id');

        $this->Common_model->updateInformation($sms_info, $id, "tbl_sms_settings");
        $this->session->set_flashdata('exception', lang('update_success'));
        redirect('Authentication/SMSSetting/' . $sms_info['company_id']);
      } else {
        $data = array();
        $data['sms_information'] = $this->Authentication_model->getSMSInformation($company_id);
        $data['main_content'] = $this->load->view('authentication/sms_setting', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['sms_information'] = $this->Authentication_model->getSMSInformation($company_id);
      $data['main_content'] = $this->load->view('authentication/sms_setting', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * change profile
   * @access public
   * @param int
   * @return void
   */
  public function changeProfile($id = '')
  {
    //start check access function
    $segment_2 = $this->uri->segment(2);
    $segment_3 = $this->uri->segment(3);

    $controller = "23";
    $function = "";
    if ($segment_2 == "changeProfile") {
      $function = "changeProfile";
    } else {
      redirect('Authentication/userProfile');
    }

    if (!checkAccess($controller, $function)) {
      redirect('Authentication/userProfile');
    }
    //end check access function


    $id = $this->session->userdata('user_id');
    $company_id = $this->session->userdata('company_id');
    $user_details = $this->Common_model->getDataById($id, "tbl_users");

    if ($this->input->post('submit')) {
      $post_email_address = htmlspecialchars($this->input->post('email_address'));
      $existing_email_address = $user_details->email_address;
      if ($post_email_address != $existing_email_address) {
        $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email|max_length[50]|is_unique[tbl_users.email_address]");
      } else {
        $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email|max_length[50]");
      }
      $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo|max_length[500]');

      if ($this->form_validation->run() == TRUE) {
        $user_info = array();
        $user_info['full_name'] = htmlspecialchars($this->input->post('full_name'));
        $user_info['email_address'] = htmlspecialchars($this->input->post('email_address'));
        $user_info['phone'] = htmlspecialchars($this->input->post('phone'));
        if ($_FILES['photo']['name'] != "") {
          $user_info['photo'] = $this->session->userdata('photo');
          $this->session->unset_userdata('photo');
        }
        $this->Common_model->updateInformation($user_info, $id, "tbl_users");
        $this->session->set_flashdata('exception', lang('update_success'));

        $this->session->set_userdata('full_name', $user_info['full_name']);
        $this->session->set_userdata('phone', $user_info['phone']);
        $this->session->set_userdata('email_address', $user_info['email_address']);
        $this->session->set_userdata('photo', $user_info['photo']);


        redirect('Authentication/changeProfile');
      } else {
        if ($id == "") {
          $data = array();
          $data['profile_info'] = $this->Authentication_model->getProfileInformation();
          $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = array();
          $data['profile_info'] = $this->Authentication_model->getProfileInformation();
          $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        $data = array();
        $data['profile_info'] = $this->Authentication_model->getProfileInformation();
        $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['profile_info'] = $this->Authentication_model->getProfileInformation();
        $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }

  /**
   * change language action
   * @access public
   * @return void
   */
  public function setlanguage()
  {
    $id = $this->session->userdata('user_id');
    $language = $this->input->post('language');
    if ($language == "") {
      $language = "english";
    }
    $data['language'] = $language;
    $this->session->set_userdata('language', $language);
    $this->db->WHERE('id', $id);
    $this->db->update('tbl_users', $data);
    redirect($_SERVER["HTTP_REFERER"]);
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_logo()
  {
    if ($_FILES['logo']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("logo")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = "230";
        $config['height'] = "50";
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('logo', $photo);
      } else {
        $this->form_validation->set_message('validate_logo', $this->upload->display_errors());
        return FALSE;
      }
    } else {
      $this->form_validation->set_message('validate_logo', lang('logo_msg'));
      return FALSE;
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_site_logo()
  {
    if ($_FILES['site_logo']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("site_logo")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        $config['maintain_ratio'] = FALSE;
        // $config['width'] = "230";
        // $config['height'] = "50";
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('site_logo', $photo);
      } else {
        $this->form_validation->set_message('validate_site_logo', $this->upload->display_errors());
        return FALSE;
      }
    } else {
      $this->form_validation->set_message('validate_site_logo', lang('site_logo_msg'));
      return FALSE;
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_favicon()
  {
    if ($_FILES['favicon']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|ico|webp';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("favicon")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
                $config['width'] = "128";
                $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('favicon', $photo);
      } else {
        $this->form_validation->set_message('validate_favicon', $this->upload->display_errors());
        return FALSE;
      }
    } else {
      $this->form_validation->set_message('validate_favicon', lang('favicon_msg'));
      return FALSE;
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_login_page_bg()
  {
    if ($_FILES['login_page_bg']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("login_page_bg")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
                $config['width'] = "128";
                $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('login_page_bg', $photo);
      } else {
        $this->form_validation->set_message('validate_login_page_bg', $this->upload->display_errors());
        return FALSE;
      }
    } else {
      $this->form_validation->set_message('validate_login_page_bg', lang('login_page_bg_msg'));
      return FALSE;
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_frontend_offer_banner_image()
  {
    if ($_FILES['frontend_offer_banner_image']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("frontend_offer_banner_image")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
                $config['width'] = "128";
                $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('frontend_offer_banner_image', $photo);
      } else {
        $this->form_validation->set_message('validate_frontend_offer_banner_image', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_frontend_middle_image_1()
  {
    if ($_FILES['frontend_middle_image_1']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("frontend_middle_image_1")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
                $config['width'] = "128";
                $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('frontend_middle_image_1', $photo);
      } else {
        $this->form_validation->set_message('validate_frontend_middle_image_1', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_frontend_middle_image_2()
  {
    if ($_FILES['frontend_middle_image_2']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("frontend_middle_image_2")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
                $config['width'] = "128";
                $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('frontend_middle_image_2', $photo);
      } else {
        $this->form_validation->set_message('validate_frontend_middle_image_2', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_frontend_middle_image_3()
  {
    if ($_FILES['frontend_middle_image_3']['name'] != "") {
      $config['upload_path'] = './assets/images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("frontend_middle_image_3")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
                $config['width'] = "128";
                $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('frontend_middle_image_3', $photo);
      } else {
        $this->form_validation->set_message('validate_frontend_middle_image_3', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * database backup
   * @access public
   * @return boolean
   */
  public function databaseBackup()
  {

    // Load the DB utility class
    $this->load->dbutil();
    // Backup your entire database and assign it to a variable
    $backup = $this->dbutil->backup();

    $file_name = date("Y_m_d_h_i_s") . "_pos.sql.zip";

    // Load the file helper and write the file to your server
    $this->load->helper('file');
    write_file('database_backup/' . $file_name, $backup);

    // Load the download helper and send the file to your desktop
    $this->load->helper('download');
    force_download($file_name, $backup);
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_photo()
  {

    if ($_FILES['photo']['name'] != "") {
      $config['upload_path'] = './images';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '1000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("photo")) {

        $upload_info = $this->upload->data();

        $file_name = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $file_name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        $config['height'] = 350;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('photo', $file_name);
      } else {
        $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
        return FALSE;
      }
    }
  }
}
