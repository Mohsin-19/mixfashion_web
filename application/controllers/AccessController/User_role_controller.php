<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_role_controller extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Authentication_model');
    $this->load->model('Category_model');
    $this->load->model('AccessModels/Role_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

  }

  public function index()
  {
    $company_id = $this->session->userdata('company_id');
    $data['roles'] = $this->Role_model->getRolesByCompanyId($company_id);
    $data['main_content'] = $this->load->view('admin/accessControl/role/index', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  public function create()
  {
    $data = array();
    $data['main_content'] = $this->load->view('admin/accessControl/role/create', $data, true);
    $this->load->view('userHome', $data);
  }


  public function store()
  {
    $validation = $this->checkValidation();

    if ($validation) {
      $data['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
      $data['slug'] = str_slug($data['name']);
      $data['description'] = htmlspecialchars($this->input->post('description'));
      $data['user_id'] = $this->session->userdata('user_id');
      $data['company_id'] = $this->session->userdata('company_id');
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');

      $this->Common_model->insertInformation($data, "tbl_roles");
      $this->session->set_flashdata('exception', lang('insertion_success'));
      redirect('admin/role');
    }
    $this->session->set_flashdata('error', 'Found some validation error');
    redirect('admin/role/create');

  }

  public function edit($id)
  {
    $data['role'] = $this->Common_model->getDataById($id, "tbl_roles");
    $data['main_content'] = $this->load->view('admin/accessControl/role/edit', $data, true);
    $this->load->view('userHome', $data);
  }

  public function update($id)
  {
    $validation = $this->checkValidation($id);

    if ($validation) {
      $data['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
      $data['slug'] = str_slug($data['name']);
      $data['description'] = htmlspecialchars($this->input->post('description'));
      $data['user_id'] = $this->session->userdata('user_id');
      $data['company_id'] = $this->session->userdata('company_id');
      $data['updated_at'] = date('Y-m-d H:i:s');
      $this->Common_model->updateInformation($data, $id, "tbl_roles");
      $this->session->set_flashdata('exception', lang('update_success'));
    } else {
      $this->session->set_flashdata('exception', 'Found some validation error');
    }
    redirect('admin/role');
  }


  public function checkValidation($id = '')
  {
    $is_unique = '';
    if ($id) {
      $name = $this->input->post($this->security->xss_clean('name'));
      $check = $this->Category_model->check_for_update($id, trim($name), 'tbl_roles');
      if ($check) {
        $this->session->set_flashdata('flashExists', $name . ' already exists on the database');
        return false;
      }
    } else {
      $is_unique = '|is_unique[tbl_roles.name]';
    }

    $this->form_validation->set_rules('name', lang('name'), 'required|max_length[255]' . $is_unique);
    $this->form_validation->set_rules('description', lang('description'), 'max_length[800]');

    return $this->form_validation->run();
  }


  public function delete($id)
  {
    $this->Common_model->permanentDelete($id, "tbl_roles");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('admin/role');
  }

}
