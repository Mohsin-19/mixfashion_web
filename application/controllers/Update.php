<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Update extends Cl_Controller
{

  protected $update;
  protected $my_info;

  function __construct()
  {
    parent::__construct();
    $this->my_info = json_decode(file_get_contents(base_url('/assets/blueimp/REST_API_UV.json')));
    $this->update = json_decode(file_get_contents($this->my_info->url));
  }

  /**
   * update landing page view
   * @access public
   * @return void
   */
  public function index()
  {
    if ($this->update->version > $this->my_info->version) {
      $data['color'] = '#4b7bec';
      $data['message'] = 'A NEW VERSION IS AVAILABLE';
      if (isset($this->update->whats_new)) {
        $data['whats_new'] = $this->update->whats_new;
      }
      $data['update_url'] = base_url('/update/do_update');
    } else {
      $data['color'] = '#16a085';
      $data['message'] = 'You are already using latest version';
    }
    $this->load->view('updater/update_view', $data);
  }

  /**
   * upload second step view page
   * @access public
   * @return void
   */
  function do_update()
  {
    if (!$this->input->is_ajax_request()) {
      echo 'downloading...<br>';
    }
    if ($this->downloadFile($this->update->url, 'build.zip')) {
      $zip = new ZipArchive;
      $res = $zip->open('build.zip');
      if ($res == TRUE) {
        $zip->extractTo('_temp/');
        if ($zip) {
          if ($this->input->is_ajax_request()) {
            $response = array(
              "status" => "success",
              "message" => "Downloaded Successfully!",
              "action" => base_url('update/install_update'),
              "caption" => 'Install Update'
            );
            echo json_encode($response);
          } else {
            echo 'downloaded successfully...</br>Extracted successfully <a href="' . base_url('/update/install_update') . '">click here</a> to install the updates!';
          }
        } else {
          if ($this->input->is_ajax_request()) {
            $response = array(
              "status" => "error",
              "message" => "Could not extract package.",
              "action" => base_url('update/help'),
              "caption" => 'Contact Us'
            );
            echo json_encode($response);
          } else {
            echo 'downloaded successfully...</br>Could not extract installation package!';
          }
        }
        $zip->close();
      }
    }
  }

  /**
   * after upload file from server for this view
   * @access public
   * @return void
   */
  public function install_update()
  {
    $src = '_temp/';
    $dst = '.';

    if (!file_exists('_temp/installer.json')) {
      if ($this->input->is_ajax_request()) {
        $res = array(
          'status' => 'error',
          'message' => 'Package installer missing.'
        );
        echo json_encode($res);
      } else {
        show_404();
      }
      return 0;
    }

    $installer = json_decode(file_get_contents('_temp/installer.json'));
    if (isset($installer->delete)) {
      foreach ($installer->delete as $key => $filePath) {
        if ($filePath) {
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
      }
    }
    if (isset($installer->sql)) {
      foreach ($installer->sql as $key => $query) {
        if ($query) {
          $q = $this->db->query($query);
        }
      }
    }

    $this->recurse_copy($src, $dst);
    delete_files($src, TRUE);
    if (file_exists('build.zip')) {
      unlink('build.zip');
    }

    if ($this->input->is_ajax_request()) {
      $res = array(
        'status' => 'success',
        'message' => 'Installed successfully.',
        'action' => base_url(),
        "caption" => 'Login Now'
      );


      echo json_encode($res);
    } else {
      echo 'Installed Successfully.';
    }

  }

  /**
   * download updated file for prepare to move
   * @access public
   * @param int
   * @return void
   */
  function downloadFile($file, $newFileName)
  {
    $err_msg = '';
    $out = fopen($newFileName, 'wb');
    if ($out == FALSE) {
      return false;
      exit;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FILE, $out);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $file);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if (curl_exec($ch)) {
      return true;
    } else {
      return false;
    }
    curl_close($ch);
    fclose($out);
  }

  /**
   * recurse the copy file
   * @access public
   * @return callable
   */
  protected function recurse_copy($src, $dst)
  {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
      if (($file != '.') && ($file != '..') && ($file != 'installer.json')) {
        if (is_dir($src . '/' . $file)) {
          $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
        } else {
          copy($src . '/' . $file, $dst . '/' . $file);
        }
      }
    }
    closedir($dir);
  }

  /**
   * help view for update file
   * @access public
   * @return void
   */
  public function help()
  {
    echo 'contact support information will go here!';
  }
}
