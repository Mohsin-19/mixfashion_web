<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_payment_model extends CI_Model {

    /**
     * return supplier due amount
     * @access public
     * @param int
     */
    public function getSupplierDue($supplier_id) {

        $outlet_id = $this->session->userdata('outlet_id');

        $supplier = $this->db->query("SELECT * FROM tbl_suppliers WHERE id=$supplier_id")->row();
        $supplier_due = $this->db->query("SELECT SUM(due) as due FROM tbl_purchase WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();

        $supplier_payment = $this->db->query("SELECT SUM(amount) as amount FROM tbl_supplier_payments WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();

        $remaining_due = $supplier_due->due - $supplier_payment->amount;

        return $remaining_due+$supplier->previous_due;
    }

    /**
     * return supplier due amount
     * @access public
     * @param int
     */
    public function getSupplierOpeningDueByDate($supplier_id,$date) {

        $outlet_id = $this->session->userdata('outlet_id');

        $supplier = $this->db->query("SELECT * FROM tbl_suppliers WHERE id=$supplier_id")->row();
        $supplier_due = $this->db->query("SELECT SUM(due) as due FROM tbl_purchase WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live' and date<'$date' ")->row();

        $supplier_payment = $this->db->query("SELECT SUM(amount) as amount FROM tbl_supplier_payments WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live' and date<'$date'")->row();

        $remaining_due = $supplier_due->due - $supplier_payment->amount;

        return $remaining_due+$supplier->previous_due;
    }

    /**
     * return supplier grand total amount
     * @access public
     * @param int
     * @param string
     */
    public function getSupplierGrantTotalByDate($supplier_id,$date) {

        $outlet_id = $this->session->userdata('outlet_id');
        $purchase_info= $this->db->query("SELECT SUM(grand_total) as total,SUM(paid) as paid,SUM(due) as due FROM tbl_purchase WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live' and date='$date' ")->row();

        return $purchase_info;
    }
    /**
     * return supplier due total payment amount
     * @access public
     * @param int
     */
    public function getSupplierDuePaymentByDate($supplier_id,$date) {

        $outlet_id = $this->session->userdata('outlet_id');

      
        $supplier_payment = $this->db->query("SELECT SUM(amount) as amount FROM tbl_supplier_payments WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live' and date='$date'")->row();

        $due_payment =$supplier_payment->amount;

        return $due_payment;
    }

}

