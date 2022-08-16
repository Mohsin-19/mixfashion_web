<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model'); 
        $this->load->model('Attendance_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();


        

    }
    /**
     * attendances list
     * @access public
     * @return void
     */
    public function attendances() { 
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['attendances'] = $this->db->query("select * from tbl_attendance where company_id=$company_id and del_status='Live' order by id desc")->result(); 
        $data['main_content'] = $this->load->view('attendance/attendances', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * delete attendance
     * @access public
     * @return void
     * @param int
     */
    public function deleteAttendance($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_attendance");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Attendance/attendances');
    }
    /**
     * add/edit attendance
     * @access public
     * @return void
     * @param int
     */
    public function addEditAttendance($encrypted_id='') { 
        $encrypted_id = $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt'); 

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('reference_no',lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('employee_id', lang('employee'), 'required|max_length[50]');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('in_time',lang('in_time'), 'required|max_length[50]');

            if ($encrypted_id != '') {
               $this->form_validation->set_rules('out_time', lang('out_time'), 'required|max_length[10]');
            } 

            $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
            if ($this->form_validation->run() == TRUE) {
                $information = array();
                $information['reference_no'] = htmlspecialchars($this->input->post('reference_no'));
                $information['date'] = date("Y-m-d", strtotime(htmlspecialchars($this->input->post('date'))));
                $information['employee_id'] = htmlspecialchars($this->input->post('employee_id')); 
                $information['in_time'] = htmlspecialchars($this->input->post('in_time')); 
                $information['out_time'] = htmlspecialchars($this->input->post('out_time')); 
                $information['note'] = htmlspecialchars($this->input->post('note'));
                $information['user_id'] = $this->session->userdata('user_id'); 
                $information['company_id'] = $this->session->userdata('company_id'); 

                /*
                $this->Common_model->insertInformation($information, "tbl_attendance");
                $this->session->set_flashdata('exception', 'Information has been added successfully!');

                redirect('Attendance/attendances');
                */
                if ($id == "") {
                    $this->Common_model->insertInformation($information, "tbl_attendance");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($information, $id, "tbl_attendance");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Attendance/attendances');

            } else {
                if ($id=='') {
                    $data = array();
                    $data['encrypted_id'] = '';
                    $data['reference_no'] = $this->Attendance_model->generateReferenceNo();
                    $data['customers'] = $this->Common_model->getAllByTable("tbl_users");
                    $data['employees'] = $this->Common_model->getAllByTable("tbl_users");
                    $data['main_content'] = $this->load->view('attendance/addEditAttendance', $data, TRUE);
                    $this->load->view('userHome', $data);
                }else{

                }
                
            }
        } else {
            if ($id=='') { 
                $data = array();
                $data['encrypted_id'] = '';
                $data['reference_no'] = $this->Attendance_model->generateReferenceNo(); 
                $data['employees'] = $this->Common_model->getAllByTable("tbl_users");
                $data['main_content'] = $this->load->view('attendance/addEditAttendance', $data, TRUE); 
                $this->load->view('userHome', $data);
            }else{
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['reference_no'] = $this->Common_model->getDataById($id, 'tbl_attendance')->reference_no;
                $data['attendance_details'] = $this->Common_model->getDataById($id, 'tbl_attendance');
                $data['employees'] = $this->Common_model->getAllByTable("tbl_users");
                $data['main_content'] = $this->load->view('attendance/addEditAttendance', $data, TRUE); 
                $this->load->view('userHome', $data);
            }
            
        }
    }

    /**
     * employee in or out
     * @access public
     * @return string
     */
    public function inOrOut(){
        $employee_id = $_GET['employee_id']; 
        $date = $_GET['date'];  

        $in_or_out = $this->db->query("select * from tbl_attendance where date=$date and employee_id=$employee_id and del_status='Live'")->row(); 

        if (!empty($in_or_out)) {
            echo "Out";
        }else{
            echo "In";
        }
    }
}
