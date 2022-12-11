<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Item extends Cl_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('AttributeModel');
    // $this->load->library('excel'); //load PHPExcel library
    // dd('sadf');
    $this->load->model('Master_model');
    $this->load->model('Outlet_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_product', 'show_product', 'edit_product', 'sort_product', 'upload_product', 'delete_product']);
  }

  /**
   * products
   * @access public
   * @return void
   */
  public function products()
  {
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $this->form_validation->set_rules('category_id', lang('category'), 'max_length[50]');
      if ($this->form_validation->run() == TRUE) {
        $category_id = htmlspecialchars($this->input->post('category_id'));
        $subcategory_id = htmlspecialchars($this->input->post('subcategory_id'));
        $supplier_id = htmlspecialchars($this->input->post('supplier_id'));
        $data = array();
        $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
        $data['products'] = $this->Common_model->getAllItemsByCategorySubcategory($category_id, $subcategory_id, $supplier_id, "tbl_products");
        $data['productCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_product_categories");
        $data['subcategories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_product_sub_categories');
        $data['main_content'] = $this->load->view('master/product/products', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
        $data['products'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_products");
        $data['productCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_product_categories");
        $data['subcategories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_product_sub_categories');
        $data['main_content'] = $this->load->view('master/product/products', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['products'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_products");
      $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
      $data['productCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_product_categories");
      $data['subcategories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_product_sub_categories');
      $data['main_content'] = $this->load->view('master/product/products', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * product barcode generator
   * @access public
   * @return void
   */
  public function productBarcodeGenerator()
  {
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $product_id = $this->input->post('product_id');
      $qty = $this->input->post('qty');
      $arr = array();
      for ($i = 0; $i < sizeof($product_id); $i++) {
        $value = explode("|", $product_id[$i]);
        $arr[] = array(
          'id' => $value[0],
          'product_name' => $value[1],
          'code' => $value[2],
          'sale_price' => $value[3],
          'qty' => $qty[$i]
        );
      }
      $data = array();
      $data['products'] = $arr;
      $data['main_content'] = $this->load->view('master/product/productBarcodeGenerator', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      $data = array();
      $data['products'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_products");
      $data['main_content'] = $this->load->view('master/product/productBarcodes', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * delete item
   * @access public
   * @param int
   * @return void
   */
  public function deleteItem($id)
  {
    check_permission('delete_product');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->permanentDelete($id, "tbl_products");
    //        $this->Common_model->deleteStatusChange($id, "tbl_products"); // for temporary delete
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Item/products');
  }

  public function initial_data($id = null)
  {
    $company_id = $this->session->userdata('company_id');
    $outlet_id = $this->session->userdata('outlet_id');

    $data['encrypted_id'] = $id;
    $data['units'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_units');
    $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_product_categories');
    $data['subcategories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_product_sub_categories');
    $data['colors'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_colors');
    $data['sizes'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_sizes');
    $data['tax_fields'] = $this->Common_model->getAllByOutletId($outlet_id, 'tbl_outlet_taxes');
    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');

    $data['autoCode'] = $this->Master_model->generateItemCode();
    if ($id) {
      $data['product_details'] = $this->Common_model->getDataById($id, "tbl_products");
    }
    return $data;
  }

  /**
   * add/edit item
   * @access public
   * @param int
   * @return void
   */
  public function addEditItem($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');

    $company_id = $this->session->userdata('company_id');
    $outlet_id = $this->session->userdata('outlet_id');

    if ($this->input->post('submit')) {
      check_permission(['add_product', 'edit_product']);

      if ($id == "") {
        $code = escapeQuot($this->input->post('code'));
        $status = checkItemUnique($code);
        if ($status == "Yes") {
          $this->session->set_flashdata('exception_error', lang('duplicate_code'));
          redirect('Item/products');
        }
      }
      $tax_information = array();
      if (!empty($_POST['tax_field_percentage'])) {
        foreach ($this->input->post('tax_field_percentage') as $key => $value) {
          $single_info = array(
            'tax_field_id' => $this->input->post('tax_field_id')[$key],
            'tax_field_outlet_id' => $this->input->post('tax_field_outlet_id')[$key],
            'tax_field_company_id' => $this->input->post('tax_field_company_id')[$key],
            'tax_field_name' => $this->input->post('tax_field_name')[$key],
            'tax_field_percentage' => ($this->input->post('tax_field_percentage')[$key] == "") ? 0 : $this->input->post('tax_field_percentage')[$key]
          );
          array_push($tax_information, $single_info);
        }
      }
      $tax_information = json_encode($tax_information);
      $type = $this->input->post('type');
      $validate = $this->validateProducts($id);

      if ($validate) {
        $product_info = array();
        $product_info['name'] = escapeQuot(htmlspecialchars($this->input->post('name')));
        $product_info['name_for_your'] = escapeQuot(htmlspecialchars($this->input->post('name_for_your')));
        $product_info['name_for_people'] = escapeQuot(htmlspecialchars($this->input->post('name_for_people')));
        $product_info['type'] = escapeQuot(htmlspecialchars($this->input->post('type')));
        //Default category
        if ($this->input->post($this->security->xss_clean('category_id'))) {
          $product_info['category_id'] = htmlspecialchars($this->input->post('category_id'));
        } else {
          $default_cat_id = $this->Master_model->getCategoryId("N/A");
          $product_info['category_id'] = $default_cat_id;
        }
        $product_info['code'] = $this->input->post('code');
        $product_info['subcategory_id'] = $this->input->post('subcategory_id');
        $product_info['alert_quantity'] = $this->input->post('alert_quantity');
        $product_info['purchase_unit_id'] = $this->input->post('purchase_unit_id');
        $product_info['sale_unit_id'] = $this->input->post('sale_unit_id');
        $product_info['opening_stock'] = $this->input->post('opening_stock');
        $product_info['supplier_id'] = $this->input->post('supplier_id');
        $product_info['purchase_price'] = $this->input->post('purchase_price');
        if ((int)($this->input->post($this->security->xss_clean('conversion_rate')))) {
          $product_info['conversion_rate'] = $this->input->post('conversion_rate');
        } else {
          $product_info['conversion_rate'] = 1;
        }
        // if product type products then insert this value

        // $product_info['description'] = escapeQuot(htmlspecialchars($this->input->post('description')));
        $product_info['description'] = $this->input->post('description');

        //end
        $product_info['tax_information'] = $tax_information;
        $product_info['sale_price'] = $this->input->post('sale_price');
        $product_info['available'] = $this->input->post('available');
        $product_info['discount_price'] = $this->input->post('discount_price');
        $product_info['has_offer'] = $this->input->post('has_offer');
        $product_info['offer'] = htmlspecialchars($this->input->post('offer'));
        $product_info['full_description'] = $this->input->post('full_description');
        $product_info['specification'] = $this->input->post('specification');

        $details_modal_image = $this->session->userdata('details_modal_image');
        if ($id == '') {
          $product_info['details_modal_image'] = $details_modal_image;
        } else {
          $details_modal_image_old = $this->input->post('details_modal_image_old');
          if (isset($details_modal_image) && $details_modal_image) {
            $product_info['details_modal_image'] = $details_modal_image;
          } else {
            $product_info['details_modal_image'] = $details_modal_image_old;
          }
        }
        $this->session->unset_userdata('details_modal_image');

        // for photo
        $photo = $this->session->userdata('photo');
        if ($id == '') {
          $product_info['photo'] = $photo;
        } else {
          $photo_old = $this->input->post('photo_old');
          if ($photo) {
            $product_info['photo'] = $photo;
          } else {
            $product_info['photo'] = $photo_old;
          }
        }
        $this->session->unset_userdata('photo');

        // for galary_image_1
        $galary_image_1 = $this->session->userdata('galary_image_1');
        if ($id == '') {
          $product_info['galary_image_1'] = $galary_image_1;
        } else {
          $galary_image_1_old = $this->input->post('galary_image_1_old');
          if ($galary_image_1) {
            $product_info['galary_image_1'] = $galary_image_1;
          } else {
            $product_info['galary_image_1'] = $galary_image_1_old;
          }
        }
        $this->session->unset_userdata('galary_image_1');

        // for galary_image_2
        $galary_image_2 = $this->session->userdata('galary_image_2');
        if ($id == '') {
          $product_info['galary_image_2'] = $galary_image_2;
        } else {
          $galary_image_2_old = $this->input->post('galary_image_2_old');
          if ($galary_image_2) {
            $product_info['galary_image_2'] = $galary_image_2;
          } else {
            $product_info['galary_image_2'] = $galary_image_2_old;
          }
        }
        $this->session->unset_userdata('galary_image_2');

        // for galary_image_3
        $galary_image_3 = $this->session->userdata('galary_image_3');
        if ($id == '') {
          $product_info['galary_image_3'] = $galary_image_3;
        } else {
          $galary_image_3_old = $this->input->post('galary_image_3_old');
          if ($galary_image_3) {
            $product_info['galary_image_3'] = $galary_image_3;
          } else {
            $product_info['galary_image_3'] = $galary_image_3_old;
          }
        }
        $this->session->unset_userdata('galary_image_3');

        // for galary_image_4
        $galary_image_4 = $this->session->userdata('galary_image_4');
        if ($id == '') {
          $product_info['galary_image_4'] = $galary_image_4;
        } else {
          $galary_image_4_old = $this->input->post('galary_image_4_old');
          if ($galary_image_4) {
            $product_info['galary_image_4'] = $galary_image_4;
          } else {
            $product_info['galary_image_4'] = $galary_image_4_old;
          }
        }
        $this->session->unset_userdata('galary_image_4');

        $product_info['manage_stock'] = $this->input->post('manage_stock');
        $product_info['order_limit'] = $this->input->post('order_limit');
        // $product_info['photo'] = $this->input->post('image_url');
        $product_info['user_id'] = $this->session->userdata('user_id');
        $product_info['company_id'] = $this->session->userdata('company_id');

        $attributes = $this->input->post('attribute') != null ? $this->input->post('attribute') : [] ;

        if ($id == "") {
          check_permission('add_product');
          $product_id = $this->Common_model->insertInformation($product_info, "tbl_products");
          $data['autoCode'] = $this->Master_model->generateItemCode();
          $this->session->set_flashdata('exception', lang('insertion_success'));
          $this->AttributeModel->updateOrInsertAttributes($attributes, $product_id);
        } else {
          check_permission('edit_product');
          $this->Common_model->updateInformation($product_info, $id, "tbl_products");
          $data['autoCode'] = $this->Master_model->generateItemCode();
          $this->session->set_flashdata('exception', lang('update_success'));
          $this->AttributeModel->updateOrInsertAttributes($attributes, $id);
        }
        return redirect('Item/products');
      } else {

        if ($id) {
          $data = $this->initial_data($id);
          $data['main_content'] = $this->load->view('master/product/editItem', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = $this->initial_data();
          $data['main_content'] = $this->load->view('master/product/addItem', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id) {
        $data = $this->initial_data($id);
        $data['main_content'] = $this->load->view('master/product/editItem', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = $this->initial_data();
        $data['main_content'] = $this->load->view('master/product/addItem', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }


  public function validateProducts($id = '')
  {
    $is_unique = '';
    if ($id) {
      $code = htmlspecialchars($this->input->post('code'));
      $check = $this->Common_model->check_for_update($id, trim($code), 'tbl_products');
      if ($check) {
        $name = htmlspecialchars($this->input->post('name'));
        $this->session->set_flashdata('flashExists', $name . ' already exists on the database');
        return false;
      }
    } else {
      $is_unique = '|is_unique[tbl_products.name]';
    }

    $this->form_validation->set_rules('name', lang('name'), 'required|max_length[255]' . $is_unique);
    $this->form_validation->set_rules('name_for_your', lang('Name in Your Language'), 'max_length[100]');
    $this->form_validation->set_rules('name_for_people', lang('Name in People Language'), 'max_length[100]');
    $this->form_validation->set_rules('sale_price', lang('sale_price'), 'required|numeric|max_length[50]');
    $this->form_validation->set_rules('purchase_price', lang('purchase_price'), 'required|numeric|max_length[50]');
    $this->form_validation->set_rules('description', lang('description'), 'max_length[1800]');
    $this->form_validation->set_rules('code', lang('code'), 'required');
    $this->form_validation->set_rules('category_id', lang('category'), 'required');
    $this->form_validation->set_rules('sale_unit_id', lang('sale_unit'), 'required');
    $this->form_validation->set_rules('purchase_unit_id', lang('purchase_unit'), 'required');
    $this->form_validation->set_rules('conversion_rate', lang('conversion_rate'), 'required');
    $manage_stock = $this->input->post('manage_stock');
    $this->form_validation->set_rules('order_limit', 'Product Order Limit', 'required');
    if ($manage_stock == "Yes") {
      $this->form_validation->set_rules('alert_quantity', lang('alert_quantity'), 'required');
    }
    $has_offer = $this->input->post('has_offer');
    $details_modal_image_old = $this->input->post('details_modal_image_old');
    if ($has_offer == "Yes") {
      $this->form_validation->set_rules('offer', lang('offer'), 'max_length[200]');
      if ($id == '' || $details_modal_image_old == '') {
        $this->form_validation->set_rules('details_modal_image', lang('img_select_error_msg'), 'callback_validate_details_modal_image');
      } else {
        if ($_FILES['details_modal_image']['name'] != "") {
          $this->form_validation->set_rules('details_modal_image', lang('img_select_error_msg'), 'callback_validate_details_modal_image');
        }
      }
    }

    // for photo
    $photo_old = $this->input->post('photo_old');
    if ($id == '' || $photo_old == '') {
      $this->form_validation->set_rules('photo', lang('img_select_error_msg'), 'callback_validate_photo');
    } else {
      if ($_FILES['photo']['name'] != "") {
        $this->form_validation->set_rules('photo', lang('img_select_error_msg'), 'callback_validate_photo');
      }
    }

    // for galary_image_1
    $galary_image_1_old = $this->input->post('galary_image_1_old');
    if ($id == '' || $galary_image_1_old == '') {
      $this->form_validation->set_rules('galary_image_1', lang('img_select_error_msg'), 'callback_validate_galary_image_1');
    } else {
      if ($_FILES['galary_image_1']['name'] != "") {
        $this->form_validation->set_rules('galary_image_1', lang('img_select_error_msg'), 'callback_validate_galary_image_1');
      }
    }
    // for galary_image_2
    $galary_image_2_old = $this->input->post('galary_image_2_old');
    if ($id == '' || $galary_image_2_old == '') {
      $this->form_validation->set_rules('galary_image_2', lang('img_select_error_msg'), 'callback_validate_galary_image_2');
    } else {
      if ($_FILES['galary_image_2']['name'] != "") {
        $this->form_validation->set_rules('galary_image_2', lang('img_select_error_msg'), 'callback_validate_galary_image_2');
      }
    }
    // for galary_image_3
    $galary_image_3_old = $this->input->post('galary_image_3_old');
    if ($id == '' || $galary_image_3_old == '') {
      $this->form_validation->set_rules('galary_image_3', lang('img_select_error_msg'), 'callback_validate_galary_image_3');
    } else {
      if ($_FILES['galary_image_3']['name'] != "") {
        $this->form_validation->set_rules('galary_image_3', lang('img_select_error_msg'), 'callback_validate_galary_image_3');
      }
    }
    // for galary_image_4
    $galary_image_4_old = $this->input->post('galary_image_4_old');
    if ($id == '' || $galary_image_4_old == '') {
      $this->form_validation->set_rules('galary_image_4', lang('img_select_error_msg'), 'callback_validate_galary_image_4');
    } else {
      if ($_FILES['galary_image_4']['name'] != "") {
        $this->form_validation->set_rules('galary_image_4', lang('img_select_error_msg'), 'callback_validate_galary_image_4');
      }
    }
    return $this->form_validation->run();
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_photo()
  {
    if ($_FILES['photo']['name'] != "") {
      $config['upload_path'] = './images/product';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '2048';
      $config['maintain_ratio'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("photo")) {

        $upload_info = $this->upload->data();

        $photo = $upload_info['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/product/' . $photo;
        $config['maintain_ratio'] = FALSE;
        // $config['width'] = 563;
        // $config['height'] = 564;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
        $this->session->set_userdata('photo', $upload_info['file_name']);
      } else {
        $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
        return FALSE;
      }
    } else {
      $this->form_validation->set_message('validate_photo', lang('img_select_error_msg'));
      return FALSE;
    }
  }

  public function validate_details_modal_image()
  {
    if ($_FILES['details_modal_image']['name'] != "") {
      $config['upload_path'] = './images';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '2048';
      $config['maintain_ratio'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("details_modal_image")) {

        $upload_info = $this->upload->data();

        $photo = $upload_info['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        $config['maintain_ratio'] = FALSE;
        // $config['width'] = 563;
        // $config['height'] = 564;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
        $this->session->set_userdata('details_modal_image', $upload_info['file_name']);
      } else {
        $this->form_validation->set_message('validate_details_modal_image', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  // validation for galary_image_1
  public function validate_galary_image_1()
  {
    if ($_FILES['galary_image_1']['name'] != "") {
      $config['upload_path'] = './images/product';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['maintain_ratio'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("galary_image_1")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/product/' . $photo;
        $config['maintain_ratio'] = FALSE;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('galary_image_1', $upload_info['file_name']);
      } else {
        $this->form_validation->set_message('validate_galary_image_1', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  // validation for galary_image_2
  public function validate_galary_image_2()
  {
    if ($_FILES['galary_image_2']['name'] != "") {
      $config['upload_path'] = './images/product';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['maintain_ratio'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("galary_image_2")) {

        $upload_info = $this->upload->data();

        $photo = $upload_info['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/product/' . $photo;
        $config['maintain_ratio'] = FALSE;
        // $config['width'] = 563;
        // $config['height'] = 564;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
        $this->session->set_userdata('galary_image_2', $upload_info['file_name']);
      } else {
        $this->form_validation->set_message('validate_galary_image_2', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  // validation for galary_image_3
  public function validate_galary_image_3()
  {
    if ($_FILES['galary_image_3']['name'] != "") {
      $config['upload_path'] = './images/product';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['maintain_ratio'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("galary_image_3")) {

        $upload_info = $this->upload->data();

        $photo = $upload_info['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/product/' . $photo;
        $config['maintain_ratio'] = FALSE;
        // $config['width'] = 563;
        // $config['height'] = 564;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
        $this->session->set_userdata('galary_image_3', $upload_info['file_name']);
      } else {
        $this->form_validation->set_message('validate_galary_image_3', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  // validation for galary_image_4
  public function validate_galary_image_4()
  {
    if ($_FILES['galary_image_4']['name'] != "") {
      $config['upload_path'] = './images/product';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['maintain_ratio'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("galary_image_4")) {

        $upload_info = $this->upload->data();

        $photo = $upload_info['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/product/' . $photo;
        $config['maintain_ratio'] = FALSE;
        // $config['width'] = 563;
        // $config['height'] = 564;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
        $this->session->set_userdata('galary_image_4', $upload_info['file_name']);
      } else {
        $this->form_validation->set_message('validate_galary_image_4', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * product details
   * @access public
   * @param int
   * @return void
   */
  public function productDetails($id)
  {
    check_permission('show_product');
    $encrypted_id = $id;
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $outlet_id = $this->session->userdata('outlet_id');
    $data = array();
    $data['encrypted_id'] = $encrypted_id;
    $data['tax_fields'] = $this->Common_model->getAllByOutletId($outlet_id, 'tbl_outlet_taxes');
    $data['product_details'] = $this->Common_model->getDataById($id, "tbl_products");
    $data['main_content'] = $this->load->view('master/product/productDetails', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * category details by category id
   * @access public
   * @param int
   * @return void
   */
  public function get_cat_id($category)
  {
    $category = $this->Master_model->getCategoryId($category);
    return $category;
  }

  /**
   * sub category details by category id
   * @access public
   * @param int
   * @return void
   */
  public function get_subcat_id($cat_id, $category)
  {
    $category = $this->Master_model->getSubCategoryId($cat_id, $category);
    return $category;
  }

  /**
   * bulk upload item
   * @access public
   * @return void
   * @throws PHPExcel_Exception
   * @throws PHPExcel_Reader_Exception
   */
  public function uploadItem()
  {
    check_permission('upload_product');

    if ($this->input->post('submit')) {
      if ($_FILES['userfile']['name'] != "") {
        if ($_FILES['userfile']['name'] == "Item_Upload.xlsx") {
          //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)
          $configUpload['upload_path'] = FCPATH . 'asset/excel/';
          $configUpload['allowed_types'] = 'xls|xlsx';
          $configUpload['max_size'] = '5000';
          $configUpload['detect_mime'] = TRUE;
          $this->load->library('upload', $configUpload);
          if ($this->upload->do_upload('userfile')) {
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            $file_name = $upload_data['file_name']; //uploded file name
            $extension = $upload_data['file_ext'];    // uploded file extension
            //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
            $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
            //Set to read only
            $objReader->setReadDataOnly(true);
            //Load excel file
            $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
            $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Number of rows available in excel
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            //loop from first data until last data
            $arrayerror = '';

            for ($i = 4; $i <= $totalrows; $i++) {
              $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue())); //Excel Column 1
              $name_for_your = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
              $name_for_people = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
              $sale_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
              $purchase_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 3
              $opening_stock = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 3
              $code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(6, $i)->getValue())); //Excel Column 4
              $supplier_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(7, $i)->getValue())); //Excel Column 5
              $category_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(8, $i)->getValue())); //Excel Column 5
              $subcategory_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(9, $i)->getValue())); //Excel Column 6
              $purchase_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(10, $i)->getValue())); //Excel Column 9
              $sale_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(11, $i)->getValue())); //Excel Column 10
              $conversion_rate = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(12, $i)->getValue())); //Excel Column 11
              $alert_quantity = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(13, $i)->getValue())); //Excel Column 12
              $description = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(14, $i)->getValue())); //Excel Column 12
              $available = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(15, $i)->getValue())); //Excel Column 12
              $discount_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(16, $i)->getValue())); //Excel Column 12
              $has_offer = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(17, $i)->getValue())); //Excel Column 12
              $offer = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(18, $i)->getValue())); //Excel Column 12
              $manage_stock = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(19, $i)->getValue())); //Excel Column 12
              //$VAT = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(18, $i)->getValue())); //Excel Column 12
              if ($name == '') {
                if ($arrayerror == '') {
                  $arrayerror .= " Row Number $i column A required";
                } else {
                  $arrayerror .= "<br> Row Number $i column A required";
                }
              } else {
                $check = $this->Common_model->check_for_bulk_upload(trim($name), 'tbl_products');
                if ($check) {
                  if ($arrayerror == '') {
                    $arrayerror .= " Row Number $i . $name product already exists";
                  } else {
                    $arrayerror .= "<br> Row Number $i . $name  product already exists";
                  }
                }
              }


              if ($sale_price == '') {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column D required";
                } else {
                  $arrayerror .= "<br> Row Number $i column D required";
                }
              }
              if (!is_numeric($sale_price)) {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column D required or can not be text";
                } else {
                  $arrayerror .= "<br> Row Number $i column D required or can not be text";
                }
              }
              if ($purchase_price == '') {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column E required";
                } else {
                  $arrayerror .= "<br> Row Number $i column E required";
                }
              }
              if ($purchase_price != '' && !is_numeric($purchase_price)) {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column E required or can not be text";
                } else {
                  $arrayerror .= "<br> Row Number $i column E required or can not be text";
                }
              }
              if ($conversion_rate || $sale_unit_id || $purchase_unit_id) {
                if ($purchase_unit_id == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column K required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column K required";
                  }
                }
                if ($sale_unit_id == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column L required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column L required";
                  }
                }
                if ($conversion_rate == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column M required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column M required";
                  }
                }
                if ($conversion_rate != '' && !is_numeric($conversion_rate)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column L required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column L required or can not be text";
                  }
                }
              }
              $status = checkItemUnique($code);
              if ($status == "Yes") {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column G product code already exist";
                } else {
                  $arrayerror .= "<br> Row Number $i column G product code already exist";
                }
              }
              if ($manage_stock && $manage_stock == "Yes") {
                if ($alert_quantity == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column N required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column N required";
                  }
                }

                if ($alert_quantity != '' && !is_numeric($alert_quantity)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column N required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column N required or can not be text";
                  }
                }
              }
              if ($has_offer == 'Yes') {
                if ($offer == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column S required is required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column S required is required";
                  }
                }
              }
              //check system tax information
            }

            if ($arrayerror == '') {
              $outlet_taxes = $this->Outlet_model->getTaxesByOutletId(1);

              if (!is_null($this->input->post('remove_previous'))) {
                // $this->db->query("TRUNCATE table `tbl_products`");
              }
              for ($i = 4; $i <= $totalrows; $i++) {
                $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue())); //Excel Column 1
                $name_for_your = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                $name_for_people = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                $sale_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
                $purchase_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 3
                $opening_stock = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 3
                $code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(6, $i)->getValue())); //Excel Column 4
                $supplier_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(7, $i)->getValue())); //Excel Column 5
                $category_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(8, $i)->getValue())); //Excel Column 5
                $subcategory_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(9, $i)->getValue())); //Excel Column 6
                $purchase_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(10, $i)->getValue())); //Excel Column 9
                $sale_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(11, $i)->getValue())); //Excel Column 10
                $conversion_rate = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(12, $i)->getValue())); //Excel Column 11
                $alert_quantity = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(13, $i)->getValue())); //Excel Column 12
                $description = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(14, $i)->getValue())); //Excel Column 12
                $available = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(15, $i)->getValue())); //Excel Column 12
                $discount_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(16, $i)->getValue())); //Excel Column 12
                $has_offer = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(17, $i)->getValue())); //Excel Column 12
                $offer = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(18, $i)->getValue())); //Excel Column 12
                $manage_stock = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(19, $i)->getValue())); //Excel Column 12
                $tax = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(20, $i)->getValue())); //Excel Column 12

                $separate_tax = explode(',', $tax);

                $tax_information = array();
                foreach ($outlet_taxes as $key => $value) {
                  $get_tax = isset($separate_tax[$key]) && $separate_tax[$key] ? $separate_tax[$key] : 0;
                  $single_info = array(
                    'tax_field_id' => $value->id,
                    'tax_field_outlet_id' => $value->outlet_id,
                    'tax_field_company_id' => $value->company_id,
                    'tax_field_name' => $value->tax,
                    'tax_field_percentage' => $get_tax
                  );
                  array_push($tax_information, $single_info);
                }

                $code = isset($code) && $code ? $code : $this->Master_model->generateItemCode();
                $purchase_unit = isset($purchase_unit_id) && $purchase_unit_id ? $this->get_unit_id($purchase_unit_id) : '';
                $sale_unit = isset($sale_unit_id) && $sale_unit_id ? $this->get_unit_id($sale_unit_id) : '';
                $supplier_id = isset($supplier_id) && $supplier_id ? $this->getSupplierId($supplier_id) : '1';

                $product_info = array();

                if ($conversion_rate) {
                  $product_info['conversion_rate'] = $conversion_rate;
                } else {
                  $product_info['conversion_rate'] = 1;
                }

                if ($category_id) {
                  $product_info['category_id'] = $this->get_cat_id((ucwords(strtolower($category_id))));
                } else {
                  $product_info['category_id'] = $this->Master_model->getCategoryId("N/A");
                }

                if ($subcategory_id) {
                  $product_info['subcategory_id'] = $this->get_subcat_id($product_info['category_id'], (ucwords(strtolower($subcategory_id))));
                } else {
                  $product_info['subcategory_id'] = '';
                }

                $product_info['name'] = $name;
                $product_info['name_for_your'] = $name_for_your;
                $product_info['name_for_people'] = $name_for_people;
                $product_info['type'] = 1;
                $product_info['code'] = $code;
                $product_info['purchase_unit_id'] = $purchase_unit;
                $product_info['sale_unit_id'] = $sale_unit;
                $product_info['supplier_id'] = $supplier_id;
                $product_info['opening_stock'] = $opening_stock;
                $product_info['conversion_rate'] = $conversion_rate;
                $product_info['purchase_price'] = $purchase_price;
                $product_info['available'] = isset($available) && $available && $available == "Yes" ? "Yes" : 'No';
                $product_info['discount_price'] = $discount_price;
                $product_info['has_offer'] = isset($has_offer) && $has_offer && $has_offer == "Yes" ? "Yes" : 'No';
                $product_info['offer'] = $offer;
                $product_info['manage_stock'] = isset($manage_stock) && $manage_stock && $manage_stock == "Yes" ? "Yes" : 'No';


                $tax_field_percentage = 0;
                $product_info['description'] = $description;
                $product_info['tax_information'] = json_encode($tax_information);
                $product_info['sale_price'] = $sale_price;
                $product_info['alert_quantity'] = $alert_quantity;
                $product_info['user_id'] = $this->session->userdata('user_id');
                $product_info['company_id'] = $this->session->userdata('company_id');

                $this->Common_model->insertInformation($product_info, "tbl_products");
              }
              unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
              $this->session->set_flashdata('exception', 'Imported successfully!');
              redirect('Item/products');
            } else {
              unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
              $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
            }
          } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('exception_err', "$error");
          }
        } else {
          $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Item_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Item_Upload.xlsx' then fill it.");
        }
      } else {
        $this->session->set_flashdata('exception_err', 'File is required');
      }
      redirect('Item/uploadItem');
    } else {
      $company_id = $this->session->userdata('company_id');
      $data = array();
      $data['products'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_products");
      $data['productCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_product_categories");
      $data['main_content'] = $this->load->view('master/product/uploadItems', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * bulk upload item
   * @access public
   * @return void
   */
  public function uploadItem_17_04_2020()
  {
    if ($this->input->post('submit')) {
      if ($_FILES['userfile']['name'] != "") {
        if ($_FILES['userfile']['name'] == "Item_Upload.xlsx") {
          //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)
          $configUpload['upload_path'] = FCPATH . 'asset/excel/';
          $configUpload['allowed_types'] = 'xls|xlsx';
          $configUpload['max_size'] = '5000';
          $configUpload['detect_mime'] = TRUE;
          $this->load->library('upload', $configUpload);
          if ($this->upload->do_upload('userfile')) {
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            $file_name = $upload_data['file_name']; //uploded file name
            $extension = $upload_data['file_ext'];    // uploded file extension
            //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
            $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
            //Set to read only
            $objReader->setReadDataOnly(true);
            //Load excel file
            $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
            $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            //loop from first data untill last data
            if ($totalrows > 2 && $totalrows < 54) {
              $arrayerror = '';
              for ($i = 4; $i <= $totalrows; $i++) {
                $type = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                $sale_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                $purchase_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
                $whole_sale_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4
                $opening_stock = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5
                $category_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(6, $i)->getValue())); //Excel Column 6
                $code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(7, $i)->getValue())); //Excel Column 7
                $supplier_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(8, $i)->getValue())); //Excel Column 8
                $purchase_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(9, $i)->getValue())); //Excel Column 9
                $sale_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(10, $i)->getValue())); //Excel Column 10
                $conversion_rate = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(11, $i)->getValue())); //Excel Column 11
                $default_qty_amt = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(12, $i)->getValue())); //Excel Column 12
                $alert_quantity = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(13, $i)->getValue())); //Excel Column 12
                $warranty = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(14, $i)->getValue())); //Excel Column 12
                $guarantee = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(15, $i)->getValue())); //Excel Column 12
                $description = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(16, $i)->getValue())); //Excel Column 12
                $VAT = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(17, $i)->getValue())); //Excel Column 12


                if ($type == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column A required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column A required";
                  }
                }
                if ($name == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= " Row Number $i column B required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column B required";
                  }
                }


                if ($sale_price == '') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column C required";
                  } else {
                    $arrayerror .= "<br> Row Number $i column C required";
                  }
                }

                if ($type != 'product' && $type != 'service') {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column A maybe not product or service";
                  } else {
                    $arrayerror .= "<br> Row Number $i column A maybe not product or service";
                  }
                }

                if ($conversion_rate != '' && !is_numeric($conversion_rate)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column L required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column L required or can not be text";
                  }
                }
                if ($purchase_price != '' && !is_numeric($purchase_price)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column D required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column D required or can not be text";
                  }
                }
                if (!is_numeric($sale_price)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column C required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column C required or can not be text";
                  }
                }
                if ($default_qty_amt != '' && !is_numeric($default_qty_amt)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column M required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column M required or can not be text";
                  }
                }
                if ($alert_quantity != '' && !is_numeric($alert_quantity)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column N required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column N required or can not be text";
                  }
                }

                $status = checkItemUnique($code);
                if ($status == "Yes") {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column H product code already exist";
                  } else {
                    $arrayerror .= "<br> Row Number $i column H product code already exist";
                  }
                }

                if ($VAT != '' && !is_numeric($VAT)) {
                  if ($arrayerror == '') {
                    $arrayerror .= "Row Number $i column R required or can not be text";
                  } else {
                    $arrayerror .= "<br> Row Number $i column R required or can not be text";
                  }
                }
                //check system tax information
              }
              if ($arrayerror == '') {
                if (!is_null($this->input->post('remove_previous'))) {
                  $this->db->query("TRUNCATE table `tbl_products`");
                }
                for ($i = 4; $i <= $totalrows; $i++) {
                  $type = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                  $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                  $sale_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                  $purchase_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
                  $whole_sale_price = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4
                  $opening_stock = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5
                  $category_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(6, $i)->getValue())); //Excel Column 6
                  $code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(7, $i)->getValue())); //Excel Column 7
                  $supplier_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(8, $i)->getValue())); //Excel Column 8
                  $purchase_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(9, $i)->getValue())); //Excel Column 9
                  $sale_unit_id = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(10, $i)->getValue())); //Excel Column 10
                  $conversion_rate = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(11, $i)->getValue())); //Excel Column 11
                  $default_qty_amt = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(12, $i)->getValue())); //Excel Column 12
                  $alert_quantity = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(13, $i)->getValue())); //Excel Column 12
                  $warranty = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(14, $i)->getValue())); //Excel Column 12
                  $guarantee = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(15, $i)->getValue())); //Excel Column 12
                  $description = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(16, $i)->getValue())); //Excel Column 12
                  $VAT = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(17, $i)->getValue())); //Excel Column 12


                  $code = isset($code) && $code ? $code : $this->Master_model->generateItemCode();

                  $purchase_unit = isset($purchase_unit_id) && $purchase_unit_id ? $this->get_unit_id($purchase_unit_id) : '';
                  $sale_unit = isset($sale_unit_id) && $sale_unit_id ? $this->get_unit_id($sale_unit_id) : '';
                  $supplier_id = isset($supplier_id) && $supplier_id ? $this->getSupplierId($supplier_id) : '';


                  $product_info = array();
                  if ($default_qty_amt) {
                    $product_info['default_qty_amt'] = $default_qty_amt;
                  } else {
                    $product_info['default_qty_amt'] = 1;
                  }
                  if ((int)($conversion_rate)) {
                    $product_info['conversion_rate'] = $conversion_rate;
                  } else {
                    $product_info['conversion_rate'] = 1;
                  }
                  if ($category_id) {
                    $product_info['category_id'] = $this->get_cat_id($category_id);
                  } else {
                    $product_info['category_id'] = $this->Master_model->getCategoryId("N/A");
                  }
                  $product_info['name'] = $name;
                  $product_info['type'] = isset($type) && $type == "service" ? '2' : '1';
                  $product_info['code'] = $code;
                  // if product type products then insert this value
                  $type = isset($type) && $type == "service" ? '2' : '1';;
                  if ($type == 1) {
                    $product_info['purchase_unit_id'] = $purchase_unit;
                    $product_info['sale_unit_id'] = $sale_unit;
                    $product_info['conversion_rate'] = $conversion_rate;
                    $product_info['purchase_price'] = $purchase_price;
                    $product_info['opening_stock'] = $opening_stock;
                    $product_info['whole_sale_price'] = $whole_sale_price;
                    $product_info['supplier_id'] = $supplier_id;
                    if ($default_qty_amt) {
                      $product_info['default_qty_amt'] = $default_qty_amt;
                    } else {
                      $product_info['default_qty_amt'] = 1;
                    }
                  }
                  $tax_information = array();

                  //end
                  $single_info = array(
                    'tax_field_id' => 2,
                    'tax_field_outlet_id' => 1,
                    'tax_field_company_id' => 1,
                    'tax_field_name' => "VAT",
                    'tax_field_percentage' => $VAT
                  );
                  array_push($tax_information, $single_info);
                  $tax_field_percentage = 0;
                  $tax_information = json_encode($tax_information);
                  $product_info['warranty'] = $warranty;
                  $product_info['description'] = $description;
                  $product_info['guarantee'] = $guarantee;
                  $product_info['tax_information'] = $tax_information;
                  $product_info['sale_price'] = $sale_price;
                  $product_info['alert_quantity'] = $alert_quantity;
                  $product_info['user_id'] = $this->session->userdata('user_id');
                  $product_info['company_id'] = $this->session->userdata('company_id');

                  $this->Common_model->insertInformation($product_info, "tbl_products");
                }
                unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                $this->session->set_flashdata('exception', 'Imported successfully!');
                redirect('Item/products');
              } else {
                unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
              }
            } else {
              unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
              $this->session->set_flashdata('exception_err', "Entry is more than 50 or No entry found.");
            }
          } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('exception_err', "$error");
          }
        } else {
          $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Item_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Item_Upload.xlsx' then fill it.");
        }
      } else {
        $this->session->set_flashdata('exception_err', 'File is required');
      }
      redirect('Item/uploadItem');
    } else {
      $company_id = $this->session->userdata('company_id');
      $data = array();
      $data['products'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_products");
      $data['productCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_product_categories");
      $data['main_content'] = $this->load->view('master/product/uploadItems', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * unit details by unit id
   * @access public
   * @param int
   * @return void
   */
  public function get_unit_id($ingredint_unit)
  {
    $company_id = $this->session->userdata('company_id');
    $user_id = $this->session->userdata('user_id');
    $id = $this->db->query("SELECT id FROM tbl_units WHERE company_id=$company_id and unit_name='" . $ingredint_unit . "'")->row('id');
    if ($id != '') {
      return $id;
    } else {
      $data = array('unit_name' => $ingredint_unit, 'company_id' => $company_id);
      $query = $this->db->insert('tbl_units', $data);
      $id = $this->db->insert_id();
      return $id;
    }
  }

  /**
   * get data for ajax datatale
   * @access public
   * @return json
   */
  public function getAjaxData()
  {
    $company_id = $this->session->userdata('company_id');

    $category_id = htmlspecialchars($this->input->post('category_id'));
    $subcategory_id = htmlspecialchars($this->input->post('subcategory_id'));
    $supplier_id = htmlspecialchars($this->input->post('supplier_id'));


    $products = $this->Master_model->make_datatables($company_id, $category_id, $subcategory_id, $supplier_id);
    $data = array();

    if ($products && !empty($products)) {
      $i = count($products);
    }


    $show_product = has_permission('show_product');
    $edit_product = has_permission('edit_product');
    $delete_product = has_permission('delete_product');

    foreach ($products as $value) {
      $html = '';

      if ($show_product) {
        $html .= '<li><a  href="' . base_url() . 'Item/productDetails/' . ($this->custom->encrypt_decrypt($value->id, 'encrypt')) . '/" ><i class="fa fa-eye tiny-icon"></i>' . lang('view_details') . '</a></li>';
      }
      if ($edit_product) {
        $html .= '<li><a  href="' . base_url() . 'Item/addEditItem/' . ($this->custom->encrypt_decrypt($value->id, 'encrypt')) . '/" ><i class="fa fa-edit"></i>' . lang('edit') . '</a></li>';
      }
      if ($delete_product) {
        $html .= '<li><a class="delete" href="' . base_url() . 'Item/deleteItem/' . ($this->custom->encrypt_decrypt($value->id, 'encrypt')) . '/" ><i class="fa fa-trash tiny-icon"></i>' . lang('delete') . '</a></li>';
      }

      $sub_array = array();
      $sub_array[] = $i--;
      $sub_array[] = html_entity_decode($value->name);
      $sub_array[] = html_entity_decode($value->description);
      $sub_array[] = $this->session->userdata('currency') . ' ' . $value->sale_price;
      $sub_array[] = $this->session->userdata('currency') . ' ' . (isset($value->purchase_price) && $value->purchase_price ? $value->purchase_price : '0.00');
      $sub_array[] = $value->available;
      $sub_array[] = $value->discount_price;
      $sub_array[] = $value->has_offer;
      $sub_array[] = $value->manage_stock;
      $sub_array[] = htmlspecialchars_decode($value->full_name);
      $sub_array[] = '<div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
										 ' . $html . '
                                            </ul>
                                        </div>';
      $data[] = $sub_array;
    }
    $output = array(
      "draw" => intval($this->Master_model->getDrawData()),
      "recordsTotal" => $this->Master_model->get_all_data($company_id, $category_id, $subcategory_id, $supplier_id),
      "recordsFiltered" => $this->Master_model->get_filtered_data($company_id, $category_id, $subcategory_id, $supplier_id),
      "data" => $data
    );
    echo json_encode($output);
  }

  /**
   * supplier by id
   * @access public
   * @param int
   * @return integer
   */
  public function getSupplierId($supplier)
  {
    $company_id = $this->session->userdata('company_id');
    $id = $this->db->query("SELECT id FROM tbl_suppliers WHERE company_id=$company_id and name='" . $supplier . "'")->row('id');
    if ($id != '') {
      return $id;
    } else {
      $data = array('name' => $supplier, 'company_id' => $company_id);
      $this->db->insert('tbl_suppliers', $data);
      $id = $this->db->insert_id();
      return $id;
    }
  }

  /**
   * excel data add for items
   * @access public
   * @return void
   */
  public function ExcelDataAddItems()
  {
    $company_id = $this->session->userdata('company_id');
    if ($_FILES['userfile']['name'] != "") {
      if ($_FILES['userfile']['name'] == "Item_Upload.xlsx") {
        //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)
        $configUpload['upload_path'] = FCPATH . 'asset/excel/';
        $configUpload['allowed_types'] = 'xls|xlsx';
        $configUpload['max_size'] = '5000';
        $configUpload['detect_mime'] = TRUE;
        $this->load->library('upload', $configUpload);
        if ($this->upload->do_upload('userfile')) {
          $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
          $file_name = $upload_data['file_name']; //uploded file name
          $extension = $upload_data['file_ext'];    // uploded file extension
          //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
          $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
          //Set to read only
          $objReader->setReadDataOnly(true);
          //Load excel file
          $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
          $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
          $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
          //loop from first data untill last data
          if ($totalrows > 2 && $totalrows < 54) {
            $arrayerror = '';
            for ($i = 4; $i <= $totalrows; $i++) {
              $ingredint_name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
              $ingredint_code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
              $ingredint_category = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
              $ingredint_unit = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
              $ingredint_alertqty = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4
              $ingredint_perchaseprice = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5

              if ($ingredint_name == '') {
                if ($arrayerror == '') {
                  $arrayerror .= " Row Number $i column A required";
                } else {
                  $arrayerror .= "<br> Row Number $i column A required";
                }
              }

              if ($ingredint_code == '') {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column B required";
                } else {
                  $arrayerror .= "<br> Row Number $i column B required";
                }
              }

              if ($ingredint_category == '') {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column C required";
                } else {
                  $arrayerror .= "<br> $i Row Number column C required";
                }
              }

              if ($ingredint_unit == '') {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column D required";
                } else {
                  $arrayerror .= "<br> Row Number $i column D required";
                }
              }

              if ($ingredint_alertqty == '' || !is_numeric($ingredint_alertqty)) {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column E required or can not be text";
                } else {
                  $arrayerror .= "<br> Row Number $i column E required  or can not be text";
                }
              }

              if ($ingredint_perchaseprice == '' || !is_numeric($ingredint_perchaseprice)) {
                if ($arrayerror == '') {
                  $arrayerror .= "Row Number $i column F required or can not be text";
                } else {
                  $arrayerror .= "<br> Row Number $i column F required or can not be text";
                }
              }
            }
            if ($arrayerror == '') {
              if (!is_null($this->input->post('remove_previous'))) {
                $this->db->query("TRUNCATE table `tbl_products`");
              }
              for ($i = 4; $i <= $totalrows; $i++) {
                $ingredint_name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                $ingredint_code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                $ingredint_category = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                $ingredint_unit = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
                $ingredint_alertqty = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4
                $ingredint_perchaseprice = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5

                $ingredint_unit = $this->get_unit_id($ingredint_unit);
                $ingredint_category = $this->get_cat_id($ingredint_category);

                $fmc_info = array();
                $fmc_info['name'] = $ingredint_name;
                $fmc_info['code'] = $ingredint_code;
                $fmc_info['category_id'] = $ingredint_category;
                $fmc_info['purchase_price'] = $ingredint_perchaseprice;
                $fmc_info['alert_quantity'] = $ingredint_alertqty;
                $fmc_info['unit_id'] = $ingredint_unit;
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                $this->Common_model->insertInformation($fmc_info, "tbl_products");
              }
              unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
              $this->session->set_flashdata('exception', 'Imported successfully!');
              redirect('Item/products');
            } else {
              unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
              $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
            }
          } else {
            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
            $this->session->set_flashdata('exception_err', "Entry is more than 50 or No entry found.");
          }
        } else {
          $error = $this->upload->display_errors();
          $this->session->set_flashdata('exception_err', "$error");
        }
      } else {
        $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Item_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Item_Upload.xlsx' then fill it.");
      }
    } else {
      $this->session->set_flashdata('exception_err', 'File is required');
    }
    redirect('Item/uploadproducts');
  }

  /**
   * product details by product id
   * @access public
   * @param string
   * @return integer
   */
  public function get_product_id($foodingredints)
  {
    $company_id = $this->session->userdata('company_id');
    $user_id = $this->session->userdata('user_id');
    $id = $this->db->query("SELECT id FROM tbl_products WHERE company_id=$company_id and user_id=$user_id and name='" . $foodingredints . "'")->row('id');
    if ($id) {
      return $id;
    } else {
      $id = 0;
      return $id;
    }
  }
}
