<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class BulkPriceUpdate extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Landing_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

    check_permission(['show_bulk_price', 'update_bulk_price']);
  }

  /**
   * product bulk upload view
   * @access public
   * @return void
   */
  public function index()
  {
    if ($this->input->post('submit')) {
      check_permission('update_bulk_price');
      $product_id = $this->input->post('product_id');
      $arr = array();
      for ($i = 0; $i < sizeof($product_id); $i++) {
        $txt = "sale_price" . $product_id[$i];
        $txt2 = "delivery_charge" . $product_id[$i];
        $sale_price = $_POST[$txt];
        $delivery_charge = $_POST[$txt2];
        $data['sale_price'] = $sale_price;
        $data['delivery_charge'] = $delivery_charge;
        $this->Common_model->updateInformation($data, $product_id[$i], "tbl_products");
      }
      redirect('bulkPriceUpdate/index');

    } else {
      check_permission('show_bulk_price');
      $data = array();
      $data['products'] = $this->Common_model->getAllCustomData("tbl_products", "name", "ASC", '', '');
      $data['main_content'] = $this->load->view('master/product/bulk_price_upload', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

}
