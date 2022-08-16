<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');


define("SSLCZ_STORE_ID", "testbox");
define("SSLCZ_STORE_PASSWD", "qwerty");

# SESSION & VALIDATION API
define("SSLCZ_SESSION_API", ".sslcommerz.com/gwprocess/v4/api.php");
define("SSLCZ_VALIDATION_API", ".sslcommerz.com/validator/api/validationserverAPI.php");

# IF SANDBOX TRUE, THEN IT WILL CONNECT WITH SSLCOMMERZ SANDBOX (TEST) SYSTEM
define("SSLCZ_IS_SANDBOX", true);
