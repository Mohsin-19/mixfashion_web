<?php
/**
 * Developed by sumon4skf@gmail.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Area extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
         $this->load->model('Authentication_model');
        $this->load->model('Area_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');



    }

    /**
     * area list
     * @access public
     * @return void
     */
    public function area() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['area'] = $this->Common_model->getByCompanyId($company_id,"tbl_areas");
        $data['main_content'] = $this->load->view('area/areas', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * delete area
     * @access public
     * @return void
     * @param int
     */
    public function deleteArea($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_areas");
        $this->session->set_flashdata('exception',  lang('delete_success'));
        redirect('area/area');
    }
    /**
     * add/edit area
     * @access public
     * @return void
     * @param int
     */
    public function addEditArea($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name',  "Area Name", 'required|max_length[300]');
            $this->form_validation->set_rules('delivery_charge',  "Delivery Charge", 'required|max_length[300]');
            if ($this->form_validation->run() == TRUE) {

                $data= array();
                $data['name'] = htmlspecialchars($this->input->post('name'));
                $data['delivery_charge'] = htmlspecialchars($this->input->post('delivery_charge'));
                $data['charge_type'] = htmlspecialchars($this->input->post('charge_type'));
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($data, "tbl_areas");
                    $this->session->set_flashdata('exception',  lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_areas");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('area/area');
            } else {

                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('area/addArea', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['area'] = $this->Common_model->getDataById($id, "tbl_areas");
                    $data['main_content'] = $this->load->view('area/editArea', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('area/addArea', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['area'] = $this->Common_model->getDataById($id, "tbl_areas");
                $data['main_content'] = $this->load->view('area/editArea', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
}
