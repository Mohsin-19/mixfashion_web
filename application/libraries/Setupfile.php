<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setupfile {

  function send($number, $message, $sender, $email_address, $password,$apikey='')
  {
      $ci = & get_instance();
      $data=array("username"=>$email_address,"hash"=>$password,'apikey'=>$apikey);
      $numbers = array($number);
      $ci->load->library('textlocal',$data);
      $response = $ci->textlocal->sendSms($numbers, $message, $sender);
      return $response;
  }
}
