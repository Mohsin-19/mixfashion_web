<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends Cl_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('excel'); //load PHPExcel library 
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }


        /*-------------Protect Delete and Edit for other users than Admin------------------*/

        if ($this->session->has_userdata('role') != 'Admin') { 
        
            $get_second_uri = $this->uri->segment(2); 
            $first_six_letter = substr($get_second_uri, 0, 6); 
            if ($first_six_letter == "delete") { 
                echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>Deleting is allowed only for admin!</h2>";
                echo "<p style='color: red; text-align: center;'><a href='".base_url()."Authentication/userProfile'</a>Click to Return</p>";
                exit; 
            } 

            $get_third_uri = $this->uri->segment(3); 
            $first_seven_letter = substr($get_second_uri, 0, 7); 
            $last_four_letter = substr($first_seven_letter, 3);
            if ($last_four_letter == "Edit" && $get_third_uri != '') { 
                echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>Modifying is allowed only for admin!</h2>";
                echo "<p style='color: red; text-align: center;'><a href='".base_url()."Authentication/userProfile'</a>Click to Return</p>";
                exit; 
            }

        }
        /*-------------Protect Delete and Edit for other users than Admin------------------*/
    }
    /**
     * get total purchase amount
     * @access public
     * @return void
     */
    public function getAllPurchasesOfCurrentDate()
    {
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');

        $total_purchase_amount_of_this_user = $this->Common_model->getPurchaseAmountByUserAndOutletId($user_id,$outlet_id);
        return $total_purchase_amount_of_this_user->total_purchase_amount;
    } 
     
}
