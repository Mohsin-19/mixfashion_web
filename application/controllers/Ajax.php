<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends Cl_Controller
{
  /**
   * load constructor
   * @access public
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Ajax_model');
    $this->load->model('Inventory_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }
  }

  /**
   * add customer by ajax
   * @access public
   * @return json
   */
  public function addNewCustomerByAjax()
  {
    $data['name'] = $_GET['customer_name'];
    $data['phone'] = $_GET['mobile_no'];
    $data['email'] = $_GET['customerEmail'];
    $data['user_id'] = $this->session->userdata('user_id');
    $data['company_id'] = $this->session->userdata('company_id');
    $this->db->insert('tbl_customers', $data);
    $customer_id = $this->db->insert_id();
    $data1 = array('customer_id' => $customer_id);
    echo json_encode($data1);
  }

  /**
   * add supplier by ajax
   * @access public
   * @return json
   */
  public function addSupplierByAjax()
  {
    $fmc_info['name'] = htmlspecialchars($this->input->get($this->security->xss_clean('name')));
    $fmc_info['contact_person'] = $this->input->get($this->security->xss_clean('contact_person'));
    $fmc_info['phone'] = $this->input->get($this->security->xss_clean('phone'));

    $fmc_info['user_id'] = $this->session->userdata('user_id');
    $fmc_info['company_id'] = $company_id = $this->session->userdata('company_id');
    $id = $this->Common_model->insertInformation($fmc_info, "tbl_suppliers");
    if ($id) {
      $return_data['id'] = $id;
      $return_data['supplier'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
    }
    echo json_encode($return_data);
  }

  /**
   * add category by ajax
   * @access public
   * @return json
   */
  public function addCategoryByAjax()
  {
    $data = array();
    $data['name'] = $this->input->get($this->security->xss_clean('name'));
    $data['description'] = $this->input->get($this->security->xss_clean('description'));
    $data['user_id'] = $this->session->userdata('user_id');
    $data['company_id'] = $this->session->userdata('company_id');
    $id = $this->Common_model->insertInformation($data, "tbl_product_categories");

    $return_data = array();
    if ($id) {
      $return_data['id'] = $id;
      $return_data['categories'] = $this->Common_model->getItemCategories($this->session->userdata('company_id'));
    }
    echo json_encode($return_data);
  }

  /**
   * get comparison sale report by ajax
   * @access public
   * @return json
   */
  public function comparison_sale_report_ajax_get()
  {
    $selectedMonth = $_GET['months'];
    $finalOutput = array();
    for ($i = $selectedMonth - 1; $i >= 0; $i--) {
      $dateCalculate = $i > 0 ? '-' . $i : $i;
      $sqlStartDate = date('Y-m-01', strtotime($dateCalculate . ' month'));
      $sqlEndDate = date('Y-m-31', strtotime($dateCalculate . ' month'));
      $saleAmount = $this->Common_model->comparison_sale_report($sqlStartDate, $sqlEndDate);

      $finalOutput[] = array(
        'month' => date('M-y', strtotime($dateCalculate . ' month')),
        'saleAmount' => ($saleAmount) ? ($saleAmount) : 0.0,
      );
    }
    echo json_encode($finalOutput);
  }

  /**
   * add unit by ajax
   * @access public
   * @return json
   */
  public function addUnitByAjax()
  {
    $data = array();
    $data['unit_name'] = $this->input->get($this->security->xss_clean('unit_name'));
    $data['description'] = $this->input->get($this->security->xss_clean('description'));
    $data['company_id'] = $this->session->userdata('company_id');
    $id = $this->Common_model->insertInformation($data, "tbl_units");

    $return_data = array();
    if ($id) {
      $return_data['id'] = $id;
      $return_data['units'] = $this->Common_model->getAllByCompanyId($this->session->userdata('company_id'), 'tbl_units');
    }
    echo json_encode($return_data);
  }

  /**
   * add sub category by ajx
   * @access public
   * @return json
   */
  public function getSubcategory()
  {
    $category_id = $_GET['category_id'];
    $product_id = $_GET['product_id'];
    $sub_categories = $this->Common_model->getAllByCustomId($category_id, "cat_id", "tbl_product_sub_categories", "DESC");
    $output['status'] = false;
    if ($sub_categories) {
      $output['status'] = true;
      $var_html = "<option value=''>" . lang('select') . "</option>";
      foreach ($sub_categories as $value) {
        $checkExisting = getSubCatRow($product_id, $category_id, $value->id);
        $select = "";
        if ($checkExisting) {
          $select = "selected";
        }
        $var_html .= "<option " . $select . " value='" . $value->id . "'>" . $value->name . "</option>";
      }

      $output['html_o'] = $var_html;
    }

    echo json_encode($output);
  }

  /**
   * save item image by ajax from add/edit item form
   * @access public
   * @return json
   */
  public function saveItemImage()
  {
    $data = $_POST['image'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    $imageName = time() . '.png';
    file_put_contents('images/' . $imageName, $data);
    $data_return['image_name'] = $imageName;
    echo json_encode($data_return);
  }

  /**
   * change status notification from notification bar its contains delete or seen action
   * @access public
   * @return string
   */
  public function change_status_notification()
  {
    $id = $this->input->get('id');
    $value = $this->input->get('value');
    $this->Common_model->change_status_notification($id, $value);
  }

  /**
   * sorting category table by ajax
   * @access public
   * @return json
   */
  public function sortingCategory()
  {
    $cats = $this->input->get('cats');
    $i = 1;
    foreach ($cats as $key => $value) {
      $data = array();
      $data['order_b'] = $i;
      $this->Common_model->updateInformation($data, $cats[$key], "tbl_product_categories");
      $i++;
    }
    echo json_encode('success');
  }

  /**
   * sorting page table
   * @access public
   * @return json
   */
  public function sortingPage()
  {
    $pages = $this->input->get('pages');
    $i = 1;
    foreach ($pages as $key => $value) {
      $data = array();
      $data['order_by'] = $i;
      $this->Common_model->updateInformation($data, $pages[$key], "tbl_pages");
      $i++;
    }
    echo json_encode('success');
  }

  /**
   * delete notification from top right header notification bar
   * @access public
   * @return json
   */
  public function delete_row_notification()
  {
    $id = $this->input->get('id');
    $this->Common_model->deleteStatusChange($id, "tbl_notifications");
    $notifications_read_count = $this->db->where('del_status', 'Live')->where('visible_status', '1')->get('tbl_notifications')->result();
    $total = sizeof($notifications_read_count);
    $data['total_unread'] = $total;
    echo json_encode($data);
  }

  /**
   * set setting
   * @access public
   * @return json
   */
  public function putSetting()
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $outlet_info = array();
    $outlet_info['sms_setting_check'] = $this->input->get($this->security->xss_clean('sms_setting_check'));
    $outlet_info['qty_setting_check'] = $this->input->get($this->security->xss_clean('qty_setting_check'));
    $this->Common_model->updateInformation($outlet_info, $outlet_id, "tbl_outlets");

    $outlet_session['sms_setting_check'] = $this->input->get($this->security->xss_clean('sms_setting_check'));
    $outlet_session['qty_setting_check'] = $this->input->get($this->security->xss_clean('qty_setting_check'));
    $this->session->set_userdata($outlet_session);

    echo json_encode("Success");
  }

  /**
   * check product quantity by ajax
   * @access public
   * @return json
   */
  public function checkQty()
  {
    $curr_qty = htmlspecialchars($this->input->post('curr_qty'));
    $product_id = htmlspecialchars($this->input->post('item_id'));
    $value = $this->Inventory_model->getInventoryByItem($product_id);
    $totalStock = ($value->total_purchase * $value->conversion_rate) - $value->total_damage - $value->total_order + $value->opening_stock;
    if ($curr_qty < $totalStock) {
      echo json_encode('available');
    } else {
      echo json_encode('');
    }
  }

  /**
   * change order status by ajax
   * @access public
   * @return json
   */
  public function changeStatus()
  {
    $status = $this->input->get($this->security->xss_clean('status'));
    $id = $this->input->get($this->security->xss_clean('id'));
    $return_arr = array();
    $return_arr['status'] = true;

    $getOrderDetails = $this->Common_model->getOrderDetails($id);

    $s_value = 0;
    if ($getOrderDetails->status == "New") {
      $s_value = 1;
    } else if ($getOrderDetails->status == "Cancel") {
      $s_value = 2;
    } else if ($getOrderDetails->status == "In Progress") {
      $s_value = 3;
    } else if ($getOrderDetails->status == "Dispatch") {
      $s_value = 4;
    } else if ($getOrderDetails->status == "Delivered") {
      $s_value = 5;
    } else if ($getOrderDetails->status == "Return") {
      $s_value = 6;
    }
    $s_value_1 = 0;
    if ($status == "New") {
      $s_value_1 = 1;
    } else if ($status == "Cancel") {
      $s_value_1 = 2;
    } else if ($status == "In Progress") {
      $s_value_1 = 3;
    } else if ($status == "Dispatch") {
      $s_value_1 = 4;
    } else if ($status == "Delivered") {
      $s_value_1 = 5;
    } else if ($status == "Return") {
      $s_value_1 = 6;
    }

    if ($s_value_1 >= $s_value) {
      if ($status == "Cancel") {
        check_permission('cancel_order');
        $data['status'] = $status;
        $this->update_order_information($data, $id);
        $data = [];
        $data['order_status'] = "c";
        $this->Common_model->updateInformationByCustom($data, $id, "order_id", "tbl_order_items");
        $txt = "Order has been canceled. Order Number is: " . $getOrderDetails->order_number . " Customer Name: " . $getOrderDetails->customer_name . " Customer Phone No: " . $getOrderDetails->phone;
        $data = [];
        $data['notifications_details'] = $txt;
        $data['order_id'] = $id;
        $data['outlet_id'] = 1;
        $data['date'] = date("Y-m-d");
        $this->Common_model->insertInformation($data, "tbl_notifications");
        //send email
        smsSend($txt, $getOrderDetails->phone, 2);
        sendEmail($txt, $getOrderDetails->email, '', 2);
      } elseif ($status == "In Progress") {
        check_permission('process_order');
        $data = [];
        $data['status'] = $status;
        $this->update_order_information($data, $id);
        $data = [];
        $data['order_status'] = $status;
        $this->Common_model->updateInformationByCustom($data, $id, "order_id", "tbl_order_items");
        $txt = "Order has been in progress. Order Number is: " . $getOrderDetails->order_number . " Customer Name: " . $getOrderDetails->customer_name . " Customer Phone No: " . $getOrderDetails->phone;
        smsSend($txt, $getOrderDetails->phone, 3);
        sendEmail($txt, $getOrderDetails->email, '', 3);
      } elseif ($status == "Delivered") {
        check_permission('complete_order');
        $data = [];
        $data['status'] = $status;
        $data['paid'] = $getOrderDetails->total_amount;
        $data['delivery_date'] = date("Y-m-d");
        $this->update_order_information($data, $id);
        $data = [];
        $data['order_status'] = $status;
        $this->Common_model->updateInformationByCustom($data, $id, "order_id", "tbl_order_items");

        $txt = "Order has been in delivered. Order Number is: " . $getOrderDetails->order_number . " Customer Name: " . $getOrderDetails->customer_name . " Customer Phone No: " . $getOrderDetails->phone;
        //send email
        smsSend($txt, $getOrderDetails->phone, 4);
        sendEmail($txt, $getOrderDetails->email, '', 4);
      } elseif ($status == "Dispatch") {
        check_permission('dispatch_order');
        $data = [];
        $data['status'] = $status;
        $this->update_order_information($data, $id);
        $data = [];
        $data['order_status'] = $status;
        $this->Common_model->updateInformationByCustom($data, $id, "order_id", "tbl_order_items");
      } elseif ($status == "Return") {
        check_permission('return_order');
        $data = [];
        $data['status'] = $status;
        $this->update_order_information($data, $id);
        $data = [];
        $data['order_status'] = $status;
        $this->Common_model->updateInformationByCustom($data, $id, "order_id", "tbl_order_items");
      }
    } else {
      $return_arr['status'] = false;
      $return_arr['msg'] = "You can't decrease the status. Please contact with Admin.";
    }

    echo json_encode($return_arr);
  }

  function update_order_information($data, $id)
  {
    $this->Common_model->updateInformation($data, $id, "tbl_orders");
  }

  /**
   * return customer list
   * @access public
   */
  public function getCustomerList()
  {
    $company_id = $this->session->userdata('company_id');
    $data1 = $this->db->query("SELECT * FROM tbl_customers
                  WHERE company_id=$company_id")->result();
    foreach ($data1 as $value) {
      if ($value->name == "Walk-in Customer") {
        echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
      }
    }
    foreach ($data1 as $value) {
      if ($value->name != "Walk-in Customer") {
        echo '<option value="' . $value->id . '" >' . $value->name . ' (' . $value->phone . ')' . '</option>';
      }
    }
    exit;
  }

  /**
   * assign delivery person by ajax
   * @access public
   * @return json
   */
  public function assignDeliveryPerson()
  {
    $id = $this->input->get($this->security->xss_clean('id'));
    $employee_id = $this->input->get($this->security->xss_clean('employee_id'));
    $data['delivery_person_id'] = $employee_id;
    $this->Common_model->updateInformation($data, $id, "tbl_orders");
    echo json_encode('success');
  }

  /**
   * add note for every order by ajax
   * @access public
   * @return json
   */
  public function addNote()
  {
    $id = $this->input->get($this->security->xss_clean('id'));
    $note = $this->input->get($this->security->xss_clean('note'));
    $data['note'] = $note;
    $this->Common_model->updateInformation($data, $id, "tbl_orders");
    echo json_encode('success');
  }

  /**
   * return notification list with total unread and total new notification by ajax
   * @access public
   * @return json
   */
  public function getNotifications()
  {
    $notifications = $this->db->where('del_status', 'Live')->limit(50)->order_by('id', 'DESC')->get('tbl_notifications')->result();
    $notifications_read_count = $this->db->where('del_status', 'Live')->where('visible_status', '1')->get('tbl_notifications')->result();
    $notifications_sound_count = $this->db->where('del_status', 'Live')->where('sound_status', '0')->get('tbl_notifications')->result();

    $html = '';
    foreach ($notifications as $value) {
      $html .= '<tr id="id_' . $value->id . '" class="delete_background" style="width:100%;border-bottom: 1px solid rgb(210, 202, 202);' . (isset($value->visible_status) && $value->visible_status == "1" ? 'border-left: 10px solid #e74c3c;' : '') . '">
                                               <td style="width: 91%;padding: 7px;"><a style="padding-left: 10px;cursor: pointer" >' . $value->notifications_details . '</a></td>
                                               <td style="width: 1%" class="td"><button  class="changeStatus txt-uh-2" title="' . lang('Mark as read') . '" value="' . $value->id . '"   data-id="' . $value->id . '" data-value="4"><i class="fa fa-eye"></i> </button> <button class="txt-uh-1"  data-id="' . $value->id . '"  title="' . lang('Delete Notification') . '" value="' . $value->id . '"><i  class="delete_notification fa fa-trash"></i> </button></td>
                                           </tr>';
    }

    setAllSoundSleepNotification();
    $return['html'] = $html;
    $return['total_unread'] = sizeof($notifications_read_count);
    $return['total_new'] = sizeof($notifications_sound_count);
    echo json_encode($return);
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
