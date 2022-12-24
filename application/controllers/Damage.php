<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Damage extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Inventory_model');
        $this->load->model('Damage_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        

    }
    /**
     * damage list
     * @access public
     * @return void
     */
    public function damages() {
        $outlet_id = $this->session->userdata('outlet_id');

        $data = array();
        $data['damages'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_damages");
        $data['main_content'] = $this->load->view('damage/damages', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * delete damage
     * @access public
     * @return void
     * @param int
     */
    public function deleteDamage($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_damages", "tbl_damage_details", 'id', 'damage_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Damage/damages');
    }
    /**
     * add/edit damage
     * @access public
     * @return void
     * @param int
     */
    public function addEditDamage($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('total_loss', lang('total_loss'), 'required|numeric|max_length[50]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
            $this->form_validation->set_rules('employee_id',lang('responsible_person'), 'required|numeric|max_length[50]');
            if ($this->form_validation->run() == TRUE) {

                $damage_info = array();
                //$damage_info['date'] = $this->input->post('date');
                //$damage_info['date'] = date('Y-m-d', strtotime('12/01/2018'));
                //$damage_info['date'] = date('Y-m-d', strtotime($this->input->post('date')));
                //$damage_info['date'] = date('Y-m-d', strtotime($this->input->post('date')));
                $damage_info['reference_no'] = $this->input->post('reference_no');
                $damage_info['date'] = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('date'))));
                $damage_info['total_loss'] = htmlspecialchars($this->input->post('total_loss'));
                $damage_info['note'] = htmlspecialchars($this->input->post('note'));
                $damage_info['employee_id'] = htmlspecialchars($this->input->post('employee_id'));
                $damage_info['user_id'] = $this->session->userdata('user_id');
                $damage_info['outlet_id'] = $this->session->userdata('outlet_id'); 

                if ($id == "") {
                    $damage_id = $this->Common_model->insertInformation($damage_info, "tbl_damages");
                    $this->saveDamageDetails($_POST['product_id'], $damage_id, 'tbl_damage_details');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($damage_info, $id, "tbl_damages");

                    $this->Common_model->deletingMultipleFormData('damage_id', $id, 'tbl_damage_details');
                    $this->saveDamageDetails($_POST['product_id'], $id, 'tbl_damage_details');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }

                redirect('Damage/damages');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['pur_ref_no'] = $this->Damage_model->generateDamageRefNo($outlet_id);
                    $data['products'] = $this->Damage_model->getItemList($outlet_id);
                    $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                    $data['main_content'] = $this->load->view('damage/addDamage', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['products'] = $this->Damage_model->getItemList($outlet_id);

                    $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                    $data['damage_details'] = $this->Common_model->getDataById($id, "tbl_damages");
                    $data['damage_products'] = $this->Damage_model->getDamageItems($id);
                    $data['main_content'] = $this->load->view('damage/editDamage', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['pur_ref_no'] = $this->Damage_model->generateDamageRefNo($outlet_id);
                $data['products'] = $this->Damage_model->getItemList($outlet_id);
                $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                $data['main_content'] = $this->load->view('damage/addDamage', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['products'] = $this->Damage_model->getItemList($outlet_id);
                $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                $data['damage_details'] = $this->Common_model->getDataById($id, "tbl_damages");
                $data['damage_products'] = $this->Damage_model->getDamageItems($id);
                $data['main_content'] = $this->load->view('damage/editDamage', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * save damage details data
     * @access public
     * @return null
     */
    public function saveDamageDetails($damage_products, $damage_id, $table_name) {
        foreach ($damage_products as $row => $product_id):
            $fmi = array();
            $fmi['product_id'] = $product_id;
            $fmi['damage_amount'] = $_POST['damage_amount'][$row];
            $fmi['last_purchase_price'] = $_POST['last_purchase_price'][$row];
            $fmi['loss_amount'] = $_POST['loss_amount'][$row];
            $fmi['damage_id'] = $damage_id;
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $this->Common_model->insertInformation($fmi, "tbl_damage_details");
        endforeach;
    }
    /**
     * damage details
     * @access public
     * @return void
     * @param int
     */
    public function DamageDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['damage_details'] = $this->Common_model->getDataById($id, "tbl_damages");
        $data['damage_products'] = $this->Damage_model->getDamageItems($id);
        $data['main_content'] = $this->load->view('damage/damageDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }
 

    /* ----------------------Damage Menu End-------------------------- */
}
