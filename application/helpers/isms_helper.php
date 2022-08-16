<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

const ISMS_TOKEN = "Shatkahonbd-7b47dea1-9b94-4b0c-80ab-31b6f8d3db08";
const ISMS_SID = "SHATKAHONBRAND"; // put ssl provided sid here
const ISMS_DOMAIN = "https://smsplus.sslwireless.com"; //api domain // example http://smsplus.sslwireless.com



function singleSms($msisdn, $messageBody, $csmsId)
{
  $params = [
    "api_token" => ISMS_TOKEN,
    "sid" => ISMS_SID,
    "msisdn" => $msisdn,
    "sms" => $messageBody,
    "csms_id" => $csmsId
  ];
  $url = trim(ISMS_DOMAIN, '/') . "/api/v3/send-sms";
  $params = json_encode($params);

  return callApi($url, $params);
}



function callApi($url, $params)
{
  $ch = curl_init(); // Initialize cURL
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($params),
    'accept:application/json'
  ));

  $response = curl_exec($ch);

  curl_close($ch);

  return $response;
}
