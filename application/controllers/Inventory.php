<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends Cl_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Inventory_model');

    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

    check_permission(['show_stock', 'alert_stock_list']);

  }

  /**
   * inventory/stock list
   * @access public
   * @return void
   */
  public function inventory()
  {
    check_permission('show_stock');
    $data = array();
    $product_id = $this->input->post('product_id');
    $category_id = $this->input->post('category_id');
    /*$supplier_id = $this->input->post('supplier_id');*/
    $data['product_id'] = $product_id;
    $company_id = $this->session->userdata('company_id');
    $data['product_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_product_categories");
    $data['products'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_products");
    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
    $data['inventory'] = $this->Inventory_model->getInventory($category_id, $product_id, '');
    $data['main_content'] = $this->load->view('inventory/inventory', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * inventory/stock alert list
   * @access public
   * @return void
   */
  public function getInventoryAlertList()
  {
    check_permission('alert_stock_list');
    $data = array();
    $data['inventory'] = $this->Inventory_model->getInventoryAlertList();
    $data['main_content'] = $this->load->view('inventory/inventoryAlertList', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * inventory/stock alert list for purchase by ajax
   * @access public
   * @return void
   */
  public function getInventoryAlertListForPurchase()
  {
    $supplier_id = $_POST['supplier_id'];
    $inventory = $this->Inventory_model->getInventoryAlertListForPurchase($supplier_id);

    $totalStock = 0;
    $grandTotal = 0;
    $i = 1;
    $table_row = '';
    $total_ = '';
    if (!empty($inventory) && isset($inventory)) {
      foreach ($inventory as $key => $value) {
        $totalStock = $value->total_purchase - $value->total_damage;
        if ($totalStock <= $value->alert_quantity) {
          $table_row .= '<tr class="rowCount"  data-id="' . $i . '" id="row_' . $i . '">' .
            '<td style="padding-left: 10px;"><p id="sl_' . $i . '">' . $i . '</p></td>' .
            '<td><span style="padding-bottom: 5px;">' . $value->name . '</span></td>' .
            '<input type="hidden" id="product_id_' . $i . '" name="product_id[]" value="' . $value->id . '"/>' .
            '<td><input type="text" id="unit_price_' . $i . '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="Unit Price" value="' . $value->purchase_price . '" onkeyup="return calculateAll();"/><span class="label_aligning">' . $this->session->userdata('currency') . '</span></td>' .
            '<td><input type="text" data-countID="' . $i . '" id="quantity_amount_' . $i . '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID" style="width: 85%;" placeholder="Qty/Amount" value="' . abs($totalStock) . '"  onkeyup="return calculateAll();" ><span class="label_aligning">' . $value->unit_name . '</span></td>' .
            '<td><input type="text" id="total_' . $i . '" name="total[]" class="form-control integerchk aligning" placeholder="Total" value="' . $value->purchase_price * abs($totalStock) . '" readonly/><span class="label_aligning">' . $this->session->userdata('currency') . '</span></td>' .
            '<td><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' . $i . ',' . $value->id . ');" ><i style="color:white"  class="fa fa-trash"></i> </a></td>' .
            '</tr>';
          $i++;
        }
      }
    }

    echo escape_output($table_row);
  }

  /**
   * ingredient info ajax
   * @access public
   * @return json
   */
  public function getIngredientInfoAjax()
  {
    $cat_id = $_GET['category_id'];
    $outlet_id = $this->session->userdata('outlet_id');
    if ($cat_id) {
      $results = $this->Inventory_model->getDataByCatId($cat_id, "tbl_products");
    } else {
      $results = $this->Inventory_model->getAllByOutletIdForDropdown($outlet_id, "tbl_products");
    }
    echo json_encode($results);
  }
}
