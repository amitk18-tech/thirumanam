<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function send_sms_for_mobile_number($mobile_number,$message)
{
	$message=str_replace(" ","+",$message);
      $_h = curl_init();
      curl_setopt($_h, CURLOPT_HEADER, 1);
      curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($_h, CURLOPT_HTTPGET, 1);
      curl_setopt($_h, CURLOPT_URL, 'http://199.189.250.157/smsclient/api.php?username=vetritv&password=26020609&source=UPDATE&dmobile=91'.$mobile_number.'&message='.$message);
      curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
      curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
      $data = curl_exec($_h);
      //echo $data;
}// send_sms_for_mobile_number function closed