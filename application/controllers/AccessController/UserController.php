<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Authentication_model');
    $this->load->model('Category_model');
    $this->load->model('AccessModels/User_model');
    $this->load->model('AccessModels/Role_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');
  }


  public function index()
  {
    $company_id = $this->session->userdata('company_id');
    $data['users'] = $this->User_model->getUsersByCompanyId($company_id);
    $data['main_content'] = $this->load->view('admin/accessControl/user/index', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  public function roles_array()
  {
    $company_id = $this->session->userdata('company_id');
    $roles = $this->Role_model->getRolesByCompanyForOptions($company_id);
    $roleOptions = [];
    foreach ($roles as $role) {
      $roleOptions[$role->id] = $role->name;
    }
    return $roleOptions;
  }


  public function create()
  {
    $data['roles'] = $this->roles_array();
    $data['main_content'] = $this->load->view('admin/accessControl/user/create', $data, true);
    $this->load->view('userHome', $data);
  }


  public function store()
  {
    $validation = $this->checkValidation();
    $company_id = $this->session->has_userdata('company_id');
    $outlet_id = $this->session->has_userdata('outlet_id');
    if ($validation) {
      $user_info['full_name'] = htmlspecialchars($this->input->post('full_name'));
      $user_info['email_address'] = htmlspecialchars($this->input->post('email_address'));
      $user_info['phone'] = htmlspecialchars($this->input->post('phone'));
      if ($_FILES['photo']['name'] != "") {
        $user_info['photo'] = $this->session->userdata('photo');
        $this->session->unset_userdata('photo');
      }
      $user_info['will_login'] = htmlspecialchars($this->input->post('will_login'));
      $user_info['active_status'] = htmlspecialchars($this->input->post('active_status'));
      $user_info['role'] = $this->input->post('role');
      $user_info['outlet_id'] = $outlet_id;
      $user_info['company_id'] = $company_id;
      $user_info['password'] = md5($this->input->post('password'));

      $user_id = $this->Common_model->insertInformation($user_info, "tbl_users");

      $this->session->set_flashdata('exception', lang('update_success'));
      redirect('admin/user');
    }
    $this->session->set_flashdata('error', lang('validation_error'));
    redirect("admin/user/create");
  }

  public function edit($id)
  {
    $data['roles'] = $this->roles_array();
    $data['user'] = $this->Common_model->getDataById($id, "tbl_users");
    $data['main_content'] = $this->load->view('admin/accessControl/user/edit', $data, true);
    $this->load->view('userHome', $data);
  }

  public function update($id)
  {
    $validation = $this->checkValidation($id);


    $company_id = $this->session->has_userdata('company_id');
    $outlet_id = $this->session->has_userdata('outlet_id');
    $change_password = $this->input->post('change_password');
    $password = ($change_password && $id) || !$id ? true : false;

    if ($validation) {
      $user_info['full_name'] = htmlspecialchars($this->input->post('full_name'));
      $user_info['email_address'] = htmlspecialchars($this->input->post('email_address'));
      $user_info['phone'] = htmlspecialchars($this->input->post('phone'));
      if ($_FILES['photo']['name'] != "") {
        $user_info['photo'] = $this->session->userdata('photo');
        $this->session->unset_userdata('photo');
      }
      $user_info['will_login'] = htmlspecialchars($this->input->post('will_login'));
      $user_info['active_status'] = htmlspecialchars($this->input->post('active_status'));
      $user_info['role'] = $this->input->post('role');
      $user_info['outlet_id'] = $outlet_id;
      $user_info['company_id'] = $company_id;
      if ($password) {
        $user_info['password'] = md5($this->input->post('password'));
      }
      $this->Common_model->updateInformation($user_info, $id, "tbl_users");
      $this->session->set_flashdata('exception', lang('update_success'));
      redirect('admin/user');
    }
    $this->session->set_flashdata('error', lang('validation_error'));
    redirect("admin/user/{$id}/edit");
  }


  public function checkValidation($id = '')
  {
    $is_email = $is_phone = '';
    $change_password = $this->input->post('change_password');
    $password = ($change_password && $id) || !$id ? true : false;

    if ($id) {
      $phone = $this->input->post($this->security->xss_clean('phone'));
      $email_address = $this->input->post($this->security->xss_clean('email_address'));
      $email = $this->User_model->check_user_exist($id, ['email_address' => trim($email_address)]);
      $phone_exists = $this->User_model->check_user_exist($id, ['phone' => trim($phone)]);

      if ($email) {
        $this->session->set_flashdata('flashExists', $email_address . ' already exists on the database');
        return false;
      } elseif ($phone_exists) {
        $this->session->set_flashdata('flashExists', $phone . ' already exists on the database');
        return false;
      }
    } else {
      $is_email = '|is_unique[tbl_users.email_address]';
      $is_phone = '|is_unique[tbl_users.phone]';
    }

    $this->form_validation->set_rules('full_name', lang('name'), 'required|max_length[155]');
    $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email" . $is_email);
    $this->form_validation->set_rules('phone', lang('phone'), "required|numeric" . $is_phone);

    if ($password) {
      $this->form_validation->set_rules('password', lang('password'), "required|max_length[50]|min_length[6]");
      $this->form_validation->set_rules('confirm_password', lang('confirm_password'), "required|max_length[50]|min_length[6]|matches[password]");
    }

    $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo|max_length[500]');

    return $this->form_validation->run();
  }


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


  public function delete($id)
  {
    $this->Common_model->permanentDelete($id, "tbl_roles");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('admin/role');
  }


}
