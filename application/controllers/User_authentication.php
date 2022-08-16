<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Authentication extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('facebook');
  }

  public function index()
  {
    $userData = array();

    // Authenticate user with facebook
    if ($this->facebook->is_authenticated()) {
      // Get user info from facebook
      $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');

      // Preparing data for database insertion
      $userData['oauth_provider'] = 'facebook';
      $userData['oauth_uid'] = !empty($fbUser['id']) ? $fbUser['id'] : '';;
      $userData['first_name'] = !empty($fbUser['first_name']) ? $fbUser['first_name'] : '';
      $userData['last_name'] = !empty($fbUser['last_name']) ? $fbUser['last_name'] : '';
      $userData['email'] = !empty($fbUser['email']) ? $fbUser['email'] : '';
      $userData['gender'] = !empty($fbUser['gender']) ? $fbUser['gender'] : '';
      $userData['picture'] = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '';
      $userData['link'] = !empty($fbUser['link']) ? $fbUser['link'] : 'https://www.facebook.com/';

      $data['userData'] = $userData;

      // Facebook logout URL
      $data['logoutURL'] = $this->facebook->logout_url();
    } else {
      // Facebook authentication url
      $data['authURL'] = $this->facebook->login_url();
    }

    // Load login/profile view
    $this->load->view('user_authentication/index', $data);
  }

  public function logout()
  {
    // Remove local Facebook session
    $this->facebook->destroy_session();
    // Remove user data from session
    $this->session->unset_userdata('userData');
    // Redirect to login page
    redirect('user_authentication');
  }
}