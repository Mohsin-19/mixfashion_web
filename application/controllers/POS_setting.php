<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class POS_setting extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Outlet_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();


  }

  /**
   * setting view page
   * @access public
   * @return void
   */
  public function setting($id = '')
  {
    /*print("<pre>");
    print_r($this->session->userdata());exit;*/
    $encrypted_id = $id = $outlet_id = $this->session->userdata('outlet_id');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');


    if ($this->input->post('submit')) {
      // dd($this->input->post());
      $this->form_validation->set_rules('outlet_name', 'Outlet Name', 'required|max_length[50]');
      $this->form_validation->set_rules('address', 'Address', 'required|max_length[200]');
      $this->form_validation->set_rules('phone', 'Phone', 'required');
      $this->form_validation->set_rules('collect_tax', 'Collect Tax', 'required|max_length[10]');
      $this->form_validation->set_rules('invoice_logo', lang('invoice_logo'), 'callback_validate_invoice_logo|max_length[500]');
      /*if ($this->input->post('collect_tax') == "Yes") {
          $this->form_validation->set_rules('tax_registration_no', 'Tax Registration No', 'required|max_length[50]');
      }*/
      if ($this->input->post('collect_tax') == "Yes") {
        $this->form_validation->set_rules('tax_title', 'Tax Title', 'required|max_length[50]');
        $this->form_validation->set_rules('tax_registration_no', 'Tax Registration No', 'required|max_length[50]');
        $this->form_validation->set_rules('tax_is_gst', 'Tax is GST', 'required|max_length[50]');
        if ($this->input->post('tax_is_gst') == "Yes") {
          $this->form_validation->set_rules('state_code', 'State Code', 'required|max_length[50]');

        }
        $this->form_validation->set_rules('taxes[]', 'Taxes', 'required|max_length[10]');
      }

      $this->form_validation->set_rules('invoice_footer', 'Invoice Footer', 'max_length[500]');
      $this->form_validation->set_rules('print_format', 'Print Format', 'required|max_length[500]');
      if ($this->form_validation->run() == TRUE) {
        $outlet_info = array();
        $outlet_info['outlet_name'] = htmlspecialchars($this->input->post('outlet_name'));
        // $outlet_info['address'] = htmlspecialchars($this->input->post('address'));
        $c_address = htmlspecialchars($this->input->post('address')); #clean the address
        $outlet_info['address'] = preg_replace("/[\n\r]/", " ", $c_address); #remove new line from address

        $outlet_info['phone'] = htmlspecialchars($this->input->post('phone'));
        $outlet_info['collect_tax'] = htmlspecialchars($this->input->post('collect_tax'));

        if ($this->input->post('collect_tax') == "Yes") {
          $outlet_info['tax_title'] = htmlspecialchars($this->input->post('collect_tax'));
          $outlet_info['tax_registration_no'] = htmlspecialchars($this->input->post('collect_tax'));
          $outlet_info['tax_is_gst'] = htmlspecialchars($this->input->post('collect_tax'));
          if ($this->input->post('collect_tax') == "Yes") {
            $outlet_info['state_code'] = htmlspecialchars($this->input->post('state_code'));
          }
        }
        if ($_FILES['invoice_logo']['name'] != "") {
          $outlet_info['invoice_logo'] = $this->session->userdata('invoice_logo');
          $this->session->unset_userdata('invoice_logo');
        } else {
          $outlet_info['invoice_logo'] = $this->input->post('invoice_logo_p');
        }
        $outlet_info['tax_title'] = htmlspecialchars($this->input->post('tax_title'));
        $outlet_info['tax_registration_no'] = htmlspecialchars($this->input->post('tax_registration_no'));
        $outlet_info['tax_is_gst'] = htmlspecialchars($this->input->post('tax_is_gst'));
        $outlet_info['state_code'] = htmlspecialchars($this->input->post('state_code'));
        $outlet_info['invoice_footer'] = $this->input->post('invoice_footer');
        $outlet_info['print_format'] = htmlspecialchars($this->input->post('print_format'));
        $outlet_info['product_modal_status'] = htmlspecialchars($this->input->post('product_modal_status'));
        if ($id == "") {
          $outlet_info['starting_date'] = date("Y-m-d");
          $outlet_info['user_id'] = $this->session->userdata('user_id');
          $outlet_info['company_id'] = $this->session->userdata('company_id');
          $outlet_info['outlet_code'] = $this->Outlet_model->generateOutletCode();
        }

        if ($id == "") {

          $outlet_id = $this->Common_model->insertInformation($outlet_info, "tbl_outlets");
          if (!empty($_POST['taxes'])) {
            $this->saveOutletTaxes($_POST['taxes'], $outlet_id, 'tbl_outlet_taxes');
          }
          $this->session->set_flashdata('exception', 'Information has been added successfully!');
        } else {

          $this->Common_model->updateInformation($outlet_info, $id, "tbl_outlets");
          $this->Common_model->deletingMultipleFormData('outlet_id', $id, 'tbl_outlet_taxes');
          if (!empty($_POST['taxes'])) {
            $this->saveOutletTaxes($_POST['taxes'], $id, 'tbl_outlet_taxes');
          }
          $this->session->set_flashdata('exception', 'Information has been updated successfully!');
        }

        $outlet_id = $this->session->userdata('outlet_id');
        $outlet_details = $this->Common_model->getDataById($outlet_id, 'tbl_outlets');

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

        redirect('POS_setting/setting');
      } else {
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
        $data['outlet_taxes'] = $this->Outlet_model->getTaxesByOutletId($id);
        $data['main_content'] = $this->load->view('restaurant_setting/editOutlet', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
      $data['outlet_taxes'] = $this->Outlet_model->getTaxesByOutletId($id);
      $data['main_content'] = $this->load->view('restaurant_setting/editOutlet', $data, TRUE);
      $this->load->view('userHome', $data);
    }

  }

  /**
   * save outlet tax
   * @access public
   * @param array
   * @param int
   * @param string
   * @return void
   */
  public function saveOutletTaxes($outlet_taxes, $outlet_id, $table_name)
  {
    foreach ($outlet_taxes as $key => $single_tax) {
      $oti = array();
      if (isset($_POST['p_tax_id'][$key]) && $_POST['p_tax_id'][$key]) {
        $oti['id'] = $_POST['p_tax_id'][$key];
      }
      $oti['tax'] = $single_tax;
      $oti['outlet_id'] = $outlet_id;
      $oti['user_id'] = $this->session->userdata('user_id');
      $oti['company_id'] = $this->session->userdata('company_id');
      $this->Common_model->insertInformation($oti, "tbl_outlet_taxes");
    }
  }

  /**
   * validate check and upload image file
   * @access public
   * @return boolean
   */
  public function validate_invoice_logo()
  {

    if ($_FILES['invoice_logo']['name'] != "") {
      $config['upload_path'] = './images';
      $config['allowed_types'] = 'jpg|jpeg|png';
      $config['max_size'] = '1000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("invoice_logo")) {

        $upload_info = $this->upload->data();

        $file_name = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $file_name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 100;
        $config['height'] = 100;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('invoice_logo', $file_name);

      } else {
        $this->form_validation->set_message('validate_invoice_logo', $this->upload->display_errors());
        return FALSE;
      }
    }
  }
}
