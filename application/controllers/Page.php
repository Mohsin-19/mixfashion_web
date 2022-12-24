<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Authentication_model');
    $this->load->model('Page_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');
  }

  /**
   * page view
   * @access public
   * @return void
   */
  public function pages()
  {
    $company_id = $this->session->userdata('company_id');

    $data = array();
    $data['pages'] = $this->Page_model->getPageByCompanyId($company_id);
    $data['main_content'] = $this->load->view('page/pages', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * sorting page
   * @access public
   * @return void
   */
  public function orderPage()
  {
    $company_id = $this->session->userdata('company_id');

    $data = array();
    $data['pages'] = $this->Page_model->getPageByOrder($company_id);
    $data['main_content'] = $this->load->view('page/orderPage', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete page
   * @access public
   * @param int
   * @return void
   */
  public function deletePage($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_pages");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('page/pages');
  }

  /**
   * add/edit page
   * @access public
   * @param int
   * @return void
   */
  public function addEditPage($encrypted_id = "")
  {

    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $company_id = $this->session->has_userdata('company_id');
    $outlet_id = $this->session->has_userdata('outlet_id');

    if ($this->input->post('submit')) {
      $this->form_validation->set_rules('menu_name', "Menu Name", 'required|max_length[255]');
      $this->form_validation->set_rules('menu_content', "Menu Content", 'required');
      if ($this->form_validation->run() == TRUE) {
        $data = array();
        $data['menu_name'] = htmlspecialchars($this->input->post('menu_name'));
        $data['slug'] = str_slug($data['menu_name']);
        $data['menu_content'] = $this->input->post('menu_content');
        $data['outlet_id'] = $outlet_id;
        $data['company_id'] = $this->session->userdata('company_id');
        if ($id == "") {
          $this->Common_model->insertInformation($data, "tbl_pages");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($data, $id, "tbl_pages");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('page/pages');
      } else {

        if ($id == "") {
          $data = array();
          $data['main_content'] = $this->load->view('page/addPage', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = array();
          $data['encrypted_id'] = $encrypted_id;
          $data['page'] = $this->Common_model->getDataById($id, "tbl_pages");
          $data['main_content'] = $this->load->view('page/editPage', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        $data = array();
        $data['main_content'] = $this->load->view('page/addPage', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['page'] = $this->Common_model->getDataById($id, "tbl_pages");
        $data['main_content'] = $this->load->view('page/editPage', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }
  /* ----------------------Page End-------------------------- */





  public function editor_image_upload()
  {
    $this->form_validation->set_rules('file', 'Image', 'callback_validate_file');
    $editor['location'] = '';
    if ($this->form_validation->run()) {
      $editor['location'] = $this->session->userdata('editor_validate_file');
    }
    // dd($editor);
    return responseJson($editor);
  }

  public function validate_file()
  {
    if ($_FILES['file']['name'] != "") {
      $config['upload_path'] = './images/editor';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '8048';
      $config['maintain_ratio'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("file")) {
        $upload_info = $this->upload->data();

        $photo = $upload_info['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/editor/' . $photo;
        $config['maintain_ratio'] = FALSE;

        $this->load->library('image_lib', $config);
        // $this->image_lib->resize();
        $this->session->set_userdata('editor_validate_file', base_url('/images/editor/' . $photo));
        return true;
      } else {
        $this->form_validation->set_message('validate_file', $this->upload->display_errors());
        return FALSE;
      }
    } else {
      $this->form_validation->set_message('validate_file', lang('img_select_error_msg'));
      return FALSE;
    }
  }
}
