<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_setting_model extends CI_Model {
    /**
     * return all companies data
     * @access public
     * @param int
     */
    public function getAllCompanies() {
        $ss_location = 'http://localhost/off_pos_asim_site_setting/'; 

        define('ss_location', 'http://localhost/off_pos_asim_site_setting/'); 

        $ss_string = file_get_contents($ss_location . "index.json");
        $ss_json_a = json_decode($ss_string, true);

        define('ss_site_title', $ss_json_a['site_title']);
        define('ss_background', $ss_json_a['background']);
        define('ss_login_page_logo', $ss_json_a['login_page_logo']);
        define('ss_home_page_logo', $ss_json_a['home_page_logo']);
        define('ss_msg', $ss_json_a['msg']);
        define('ss_msg_start', $ss_json_a['msg_start']);
        define('ss_msg_end', $ss_json_a['msg_end']);
    }

}

?>
