<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PermissionController extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Authentication_model');
    $this->load->model('Category_model');
    $this->load->model('AccessModels/User_model');
    $this->load->model('AccessModels/Role_model');
    $this->load->model('AccessModels/Access_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');
  }


  public function index()
  {
//    $perm = has_permission(['add_user', 'edit_user'], 'administrator');
//    dd($perm);

    $role = request_get('role');
    if (!$role) {
      redirect('admin/permission?role=admin');
    }
    $data['role'] = $role;
    $data['roles'] = $this->roles_array();
    $data['access'] = access_control();
    $data['main_content'] = $this->load->view('admin/accessControl/permission/index', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  public function roles_array()
  {
    $company_id = $this->session->userdata('company_id');
    $roles = $this->Role_model->getRolesByCompanyForOptions($company_id);
    $roleOptions = [];
    foreach ($roles as $role) {
      $roleOptions[$role->slug] = $role->name;
    }
    return $roleOptions;
  }


  public function store()
  {
    $role = request('role');
    $access = request('access');
    $json = json_encode($access, TRUE);
    $fp = fopen("./application/user_access/{$role}.json", 'w');
    fwrite($fp, $json);

    return json_encode(['status' => true, 'msg' => 'Permission updated successfully']);

  }


}
