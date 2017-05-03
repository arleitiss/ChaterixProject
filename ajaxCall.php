<?php
require_once('inc/recaptchalib.php');
$privatekey = "6Ld_7PwSAAAAAPSma_eoSYceiZNh9MQnoxrVczrm";
$challange = $_POST['chall'];
$response = $_POST['resp'];
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $challange,
                                $response);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    echo("false");
  } else {
    echo("true");
  }
  ?>