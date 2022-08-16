<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Slideshow extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Authentication_model');
    $this->load->model('Slideshow_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');
  }

  /**
   * slide shows view
   * @access public
   * @return void
   */
  public function slideshows()
  {
    $company_id = $this->session->userdata('company_id');

    $data = array();
    $data['slideshows'] = $this->Slideshow_model->getSlideshowByCompanyId($company_id, "tbl_slideshows");
    $data['main_content'] = $this->load->view('slideshow/slideshows', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete slide shows
   * @access public
   * @param int
   * @return void
   */
  public function deleteSlideshow($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_slideshows");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('slideshow/slideshows');
  }

  /**
   * add/edit/ slide shows
   * @access public
   * @param int
   * @return void
   */
  public function addEditSlideshow($encrypted_id = "")
  {

    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $company_id = $this->session->has_userdata('company_id');
    $outlet_id = $this->session->has_userdata('outlet_id');

    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('title', lang('title'), 'required|max_length[200]');
      // $this->form_validation->set_rules('btn_url', 'btn_url', 'required|max_length[200]');
      if ($encrypted_id == '') {
        $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo|max_length[500]');
      } else {
        if ($_FILES['photo']['name'] != "") {
          $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo|max_length[500]');
        }
      }

      if ($this->form_validation->run() == TRUE) {

        $user_info = array();
        $user_info['title'] = htmlspecialchars($this->input->post('title'));
        $user_info['btn_url'] = htmlspecialchars($this->input->post('btn_url'));
        $user_info['active_status'] = htmlspecialchars($this->input->post('active_status'));

        if ($_FILES['photo']['name'] != "") {
          $user_info['photo'] = $this->session->userdata('photo');
          $this->session->unset_userdata('photo');
        } else {
          $user_info['photo'] = htmlspecialchars($this->input->post('old_photo'));
        }
        $user_info['outlet_id'] = $outlet_id;
        $user_info['company_id'] = $this->session->userdata('company_id');

        // $checktotal = $this->Slideshow_model->checkActive();
        // $active_status = htmlspecialchars($this->input->post('active_status'));

        // if ($checktotal && $active_status == "Active") {
        //   $this->session->set_flashdata('exception_r', lang('not_add_more_4'));
        //   redirect('slideshow/slideshows');
        // }


        if ($id == "") {
          $this->Common_model->insertInformation($user_info, "tbl_slideshows");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($user_info, $id, "tbl_slideshows");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('slideshow/slideshows');
      } else {

        if ($id == "") {
          $data = array();
          $data['main_content'] = $this->load->view('slideshow/addSlideshow', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = array();
          $data['encrypted_id'] = $encrypted_id;
          $data['slide'] = $this->Common_model->getDataById($id, "tbl_slideshows");
          $data['main_content'] = $this->load->view('slideshow/editSlideshow', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        $data = array();
        $data['main_content'] = $this->load->view('slideshow/addSlideshow', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['slide'] = $this->Common_model->getDataById($id, "tbl_slideshows");
        $data['main_content'] = $this->load->view('slideshow/editSlideshow', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }

  /**
   * check image validation and upload image file
   * @access public
   * @param int
   * @return void
   */
  public function validate_photo()
  {
    if ($_FILES['photo']['name'] != "") {
      $config['upload_path'] = './slide-images';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '1000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("photo")) {

        $upload_info = $this->upload->data();

        $file_name = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './slide-images/' . $file_name;
        // $config['maintain_ratio'] = TRUE;
        //$config['width'] = 200;
        //$config['height'] = 350;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('photo', $file_name);
      } else {
        $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
        return FALSE;
      }
    } else {
      $this->form_validation->set_message('validate_photo', lang('select_slide_image'));
      return FALSE;
    }
  }

  /* ----------------------Slideshow End-------------------------- */
}
