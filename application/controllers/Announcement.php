<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Announcement extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Announcement_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();
    check_permission(['add_announcement', 'show_announcement', 'edit_announcement', 'delete_announcement']);
  }

  /**
   * payment methods view page
   * @access public
   * @return void
   */
  public function index()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['announcements'] = $this->Announcement_model->getAllByCompanyId($company_id, "tbl_announcements");
    $data['main_content'] = $this->load->view('master/announcement/announcement', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  public function couponsCustomers()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['coupons'] = $this->Common_model->getCouponCustomers();

    $data['main_content'] = $this->load->view('master/couponsCustomers/couponsCustomers', $data, TRUE);

    $this->load->view('userHome', $data);
  }

  /**
   * delete payment method
   * @access public
   * @param int
   * @return void
   */
  public function deleteAnnouncement($id)
  {
    check_permission('delete_announcement');
    if ($id > 1) {
      $id = $this->custom->encrypt_decrypt($id, 'decrypt');
      $this->Announcement_model->deleteStatusChange($id, "tbl_announcements");
      $this->session->set_flashdata('exception', lang('delete_success'));
    }
    $this->session->set_flashdata('error', lang('Total Item greater than 1 for delete active '));
    redirect('announcement/index');
  }

  /**
   * add/edit payment method
   * @access public
   * @param int
   * @return void
   */
  public function addEditAnnouncement($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    if ($this->input->post('submit')) {

      check_permission(['add_announcement', 'edit_announcement']);

      $this->form_validation->set_rules('active', 'Active', 'max_length[50]');
      $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
      $this->form_validation->set_rules('description', 'Description', 'max_length[1600]');
      $this->form_validation->set_rules('upload_type', 'Upload Type', 'required|max_length[155]');
      $this->form_validation->set_rules('upload_content', 'Video link', 'max_length[155]');
      $this->form_validation->set_rules('end_date', lang('expired_date'), 'required|max_length[50]');

      if ($_FILES['image']['name'] != "") {
        $this->form_validation->set_rules('image', 'Image', 'callback_validate_announcement_image');
      }

      if ($this->form_validation->run() == TRUE) {
        $data = [
          'active' => $this->input->post('active'),
          'title' => $this->input->post('title'),
          'description' => $this->input->post('description'),
          'upload_type' => $this->input->post('upload_type'),
          'end_date' => $this->input->post('end_date'),
          'user_id' => $this->session->userdata('user_id'),
        ];

        if ($_FILES['image']['name'] != "") {
          $data['upload_content'] = $this->session->userdata('image');;
          $this->session->unset_userdata('image');
        } else {
          $data['upload_content'] = $this->input->post('upload_content');
        }

        if ($id == "") {
          check_permission('add_announcement');
          $this->Announcement_model->insertInformation($data, "tbl_announcements");
          $this->session->set_flashdata('exception', 'Announcement Create Successfully');
        } else {
          check_permission('edit_announcement');
          $this->Announcement_model->updateInformation($data, $id, "tbl_announcements");
          $this->session->set_flashdata('exception', 'Announcement Updated Successfully');
        }
        redirect('announcement/index');
      } else {
        if ($id == "") {
          $data = array();
          $data['main_content'] = $this->load->view('master/announcement/addAnnouncement', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = array();
          $data['encrypted_id'] = $encrypted_id;
          $data['announcement'] = $this->Announcement_model->getDataById($id, "tbl_announcements");
          $data['main_content'] = $this->load->view('master/announcement/editAnnouncement', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        check_permission('add_announcement');
        $data = array();
        $data['main_content'] = $this->load->view('master/announcement/addAnnouncement', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        check_permission('edit_announcement');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['announcement'] = $this->Announcement_model->getDataById($id, "tbl_announcements");
        $data['main_content'] = $this->load->view('master/announcement/editAnnouncement', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }


  public function validate_announcement_image()
  {
    if ($_FILES['image']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '500';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("image")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        /*$config['maintain_ratio'] = FALSE;
        $config['width'] = "230";
        $config['height'] = "50";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('image', $photo);
      } else {
        $this->form_validation->set_message('validate_announcement_image', $this->upload->display_errors());
        return FALSE;
      }
    }
  }
}
