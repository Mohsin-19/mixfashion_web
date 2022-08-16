<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Authentication_model');
    $this->load->model('AccessModels/User_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }

  }

  /**
   * users view page
   * @access public
   * @return void
   */
  public function users()
  {
    $company_id = $this->session->userdata('company_id');

    $data = array();
    $data['users'] = $this->User_model->getUsersByCompanyId($company_id, "tbl_users");
    $data['main_content'] = $this->load->view('user/users', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete user
   * @access public
   * @param int
   * @return void
   */
  public function deleteUser($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');

    $this->Common_model->deleteStatusChange($id, "tbl_users");

    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('User/users');
  }

  /**
   * add/edit unit
   * @access public
   * @param int
   * @return void
   */
  public function addEditUser($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $company_id = $this->session->has_userdata('company_id');
    $outlet_id = $this->session->has_userdata('outlet_id');
    if ($id != '') {
      $user_details = $this->Common_model->getDataById($id, "tbl_users");
    }


    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('full_name', lang('name'), 'required|max_length[50]');
      $this->form_validation->set_rules('salary', lang('salary'), 'required|max_length[50]');
      //$this->form_validation->set_rules('email_address', "Email Address", "valid_email|max_length[50]|is_unique[tbl_users.email_address]");

      if ($id != '') {
        $email_address = htmlspecialchars($this->input->post('email_address'));
        $existing_email = $user_details->email_address;
        if ($email_address != $existing_email) {
          $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email|is_unique[tbl_users.email_address]");
        } else {
          $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email");
        }
      } else {
        $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email|is_unique[tbl_users.email_address]");
      }

      $this->form_validation->set_rules('phone', lang('phone'), "required|numeric");
      $this->form_validation->set_rules('designation', lang('designation'), "required|max_length[50]|min_length[3]");

      $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo|max_length[500]');

      if ($this->input->post($this->security->xss_clean('will_login')) == 'Yes') {
        if ($id == '') {
          $this->form_validation->set_rules('password', lang('password'), "required|max_length[50]|min_length[6]");
          $this->form_validation->set_rules('confirm_password', lang('confirm_password'), "required|max_length[50]|min_length[6]|matches[password]");
        }

      }


      /* $this->form_validation->set_rules('menu_id', 'Menu Access', 'trim'); */
      if ($this->form_validation->run() == TRUE) {

        $user_info = array();
        $user_info['full_name'] = htmlspecialchars($this->input->post('full_name'));
        $user_info['email_address'] = htmlspecialchars($this->input->post('email_address'));
        $user_info['phone'] = htmlspecialchars($this->input->post('phone'));
        $user_info['designation'] = htmlspecialchars($this->input->post('designation'));
        $user_info['commission'] = htmlspecialchars($this->input->post('commission'));
        $user_info['salary'] = htmlspecialchars($this->input->post('salary'));
        if ($_FILES['photo']['name'] != "") {
          $user_info['photo'] = $this->session->userdata('photo');
          $this->session->unset_userdata('photo');
        }
        $user_info['will_login'] = htmlspecialchars($this->input->post('will_login'));
        $user_info['role'] = (is_null($this->input->post('is_delivery_person')) || $this->input->post('is_delivery_person') == "") ? 'User' : $this->input->post('is_delivery_person');
        $user_info['outlet_id'] = $outlet_id;
        $user_info['company_id'] = $this->session->userdata('company_id');

        if ($id == "") {
          if ($this->input->post($this->security->xss_clean('will_login')) == 'Yes') {
            $user_info['password'] = md5($this->input->post('password'));
          }
          $user_id = $this->Common_model->insertInformation($user_info, "tbl_users");


          $access_id = $this->input->post('access_id');
          if ($access_id) {
            //data insert in role access table
            for ($i = 0; $i < sizeof($access_id); $i++) {
              $original_value = explode('|', $access_id[$i]);
              $data = array();
              $data['user_id'] = $user_id;
              $data['access_parent_id'] = $original_value[0];
              $data['access_child_id'] = $original_value[1];
              $this->Common_model->insertInformation($data, "tbl_user_access");
            }
            //end data insert in role access table
          }
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          if ($this->input->post($this->security->xss_clean('will_login')) == 'Yes') {
            if ($this->input->post($this->security->xss_clean('password'))) {
              $user_info['password'] = md5($this->input->post('password'));
            }
          }
          $this->Common_model->updateInformation($user_info, $id, "tbl_users");

          $access_id = $this->input->post('access_id');
          $this->Common_model->deleteCustomRow($id, "user_id", "tbl_user_access");
          if ($access_id) {
            //delete previous access before add
            //end delete previous access before add
            //data insert in role access table
            for ($i = 0; $i < sizeof($access_id); $i++) {
              $original_value = explode('|', $access_id[$i]);
              $data = array();
              $data['user_id'] = $id;
              $data['access_parent_id'] = $original_value[0];
              $data['access_child_id'] = $original_value[1];
              $this->Common_model->insertInformation($data, "tbl_user_access");
            }
            //end data update in role access table
          }
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('User/users');
      } else {

        if ($id == "") {
          $data = array();
          $data['user_menus'] = $this->Common_model->getAllByTable("tbl_admin_user_menus");
          $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
          $data['access_modules'] = $this->Common_model->getAllCustomData("tbl_access", 'main_module_id', 'asc', 'parent_id', '0');
          foreach ($data['access_modules'] as $key => $value) {
            $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access", 'label_name', 'asc', 'parent_id', $value->id);
          }
          $data['main_content'] = $this->load->view('user/addUser', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = array();
          $data['encrypted_id'] = $encrypted_id;
          $data['user_details'] = $this->Common_model->getDataById($id, "tbl_users");
          $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
          $data['user_menus'] = $this->Common_model->getAllByTable("tbl_admin_user_menus");

          $data['access_modules'] = $this->Common_model->getAllCustomData("tbl_access", 'main_module_id', 'asc', 'parent_id', '0');
          foreach ($data['access_modules'] as $key => $value) {
            $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access", 'label_name', 'asc', 'parent_id', $value->id);
          }

          $selected_modules = $this->Common_model->getAllByCustomId($id, 'user_id', 'tbl_user_access');
          $selected_modules_arr = array();
          foreach ($selected_modules as $value) {
            $selected_modules_arr[] = $value->access_child_id;
          }
          $data['selected_modules_arr'] = $selected_modules_arr;
          $data['main_content'] = $this->load->view('user/editUser', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        $data = array();
        $data['user_menus'] = $this->Common_model->getAllByTable("tbl_admin_user_menus");
        $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");

        $data['access_modules'] = $this->Common_model->getAllCustomData("tbl_access", 'main_module_id', 'asc', 'parent_id', '0');
        foreach ($data['access_modules'] as $key => $value) {
          $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access", 'label_name', 'asc', 'parent_id', $value->id);
        }
        $data['main_content'] = $this->load->view('user/addUser', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['user_details'] = $this->Common_model->getDataById($id, "tbl_users");
        $data['user_menus'] = $this->Common_model->getAllByTable("tbl_admin_user_menus");
        $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
        $data['access_modules'] = $this->Common_model->getAllCustomData("tbl_access", 'main_module_id', 'asc', 'parent_id', '0');
        foreach ($data['access_modules'] as $key => $value) {
          $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access", 'label_name', 'asc', 'parent_id', $value->id);
        }
        $selected_modules = $this->Common_model->getAllByCustomId($id, 'user_id', 'tbl_user_access');

        $selected_modules_arr = array();
        foreach ($selected_modules as $value) {
          $selected_modules_arr[] = $value->access_child_id;
        }
        $data['selected_modules_arr'] = $selected_modules_arr;

        $data['main_content'] = $this->load->view('user/editUser', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }

  /**
   * check user access menu list
   * @access public
   * @return void
   */
  public function check_menu_access()
  {
    $menu_id = $this->input->post('menu_id');

    if (count($menu_id) <= 0) {
      $this->form_validation->set_message('check_menu_access', 'At least 1 menu access should be selected');
      return false;
    } else {
      return true;
    }
  }

  /**
   * deactive user
   * @access public
   * @param int
   * @return void
   */
  public function deactivateUser($encrypted_id)
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $user_info = array();
    $user_info['active_status'] = 'Inactive';
    $this->Common_model->updateInformation($user_info, $id, "tbl_users");
    $this->session->set_flashdata('exception', lang('user_deactivate'));
    redirect('User/users');
  }

  /**
   * active user
   * @access public
   * @param int
   * @return void
   */
  public function activateUser($encrypted_id)
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $user_info = array();
    $user_info['active_status'] = 'Active';
    $this->Common_model->updateInformation($user_info, $id, "tbl_users");
    $this->session->set_flashdata('exception', lang('user_activate'));
    redirect('User/users');
  }

  /**
   * check validation and upload image file
   * @access public
   * @return boolean
   */
  public function validate_photo()
  {

    if ($_FILES['photo']['name'] != "") {
      $config['upload_path'] = './images';
      $config['allowed_types'] = 'jpg|jpeg|png';
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

  /* ----------------------User End-------------------------- */
}
