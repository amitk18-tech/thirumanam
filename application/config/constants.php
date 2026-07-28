<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);


//=================================================
		//	For PayTM Settings::
		//=================================================

		// $PAYTM_ENVIRONMENT = "PROD";	// For Production /LIVE
		// $PAYTM_ENVIRONMENT = "TEST";	// For Staging / TEST

		// if(!defined("PAYTM_ENVIRONMENT") ){
		// 	define('PAYTM_ENVIRONMENT', $PAYTM_ENVIRONMENT); 
		// }

		// For LIVE
		// if (PAYTM_ENVIRONMENT == 'PROD') {
		// 	//===================================================
		// 	//	For Production or LIVE Credentials
		// 	//===================================================
		// 	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
		// 	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';


		// }else{
		// 	//===================================================
		// 	//	For Staging or TEST Credentials
		// 	//===================================================
		// 	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
		// 	$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';

		// 	//Change this constant's value with Merchant key received from Paytm.
		// 	$PAYTM_MERCHANT_MID 		= "YOUR_MERCHANT_MID";
		// 	$PAYTM_MERCHANT_KEY 		= "YOUR_MERCHANT_KEY";

		// 	$PAYTM_CHANNEL_ID 		= "WEB";
		// 	$PAYTM_INDUSTRY_TYPE_ID = "Retail";
		// 	$PAYTM_MERCHANT_WEBSITE = "WEBSTAGING";

		// 	$PAYTM_CALLBACK_URL 	= "http://127.0.0.1/paytmpayment/paytm_response";
			
		// }

		// define('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY); 
		// define('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID);

		// define("PAYTM_MERCHANT_WEBSITE", $PAYTM_MERCHANT_WEBSITE);
		// define("PAYTM_CHANNEL_ID", $PAYTM_CHANNEL_ID);
		// define("PAYTM_INDUSTRY_TYPE_ID", $PAYTM_INDUSTRY_TYPE_ID);
		// define("PAYTM_CALLBACK_URL", $PAYTM_CALLBACK_URL);


		// define('PAYTM_REFUND_URL', '');
		// define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		// define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		// define('PAYTM_TXN_URL', $PAYTM_TXN_URL);





/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
$GLOBALS['merchant_key'] = 'Opx4hR9O';
$GLOBALS['salt'] = 'WGq7rlu9FZ';
$GLOBALS['per_page'] = 6;
/*$GLOBALS['admin_email'] = 'sathishsharma@iclienttech.com';
$GLOBALS['from_email'] = 'emails@iclientprojects.com';
$GLOBALS['smtp_user'] = 'emails@iclientprojects.com';
$GLOBALS['smtp_pass'] = 'Q[,EdB1{{KR_';*/

$GLOBALS['admin_email'] = 'valli.vallikodi@gmail.com';
$GLOBALS['from_email'] = 'info@vallikodivanniarmatrimonial.in';
$GLOBALS['smtp_user'] = 'info@vallikodivanniarmatrimonial.in';
$GLOBALS['smtp_pass'] = '^W4R^D7zynPw';

$GLOBALS['per_page'] = 6;
$GLOBALS['message_per_page'] = 5;
$GLOBALS['success_per_page'] = 5;
$GLOBALS['profile_images_count'] = 24;
$GLOBALS['aadhar_images_count'] = 24;
$GLOBALS['certificate_images_count'] = 24;
$GLOBALS['horoscope_images_count'] = 24;

