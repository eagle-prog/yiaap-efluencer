<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
define('URL',		'https://www.vipleyo.com/efluencer/');
define('VPATH',		'https://www.vipleyo.com/efluencer/');
define('APATH',		$_SERVER['DOCUMENT_ROOT']."/efluencer/");
define('ASSETS',	URL."assets/");
define('CSS',		ASSETS."css/");
define('JS',		ASSETS."js/");
define('IMAGE',		ASSETS."images/");
define('SITE_URL',      'https://www.vipleyo.com/efluencer/');

define('PDF_ICON',		IMAGE.'pdf_icon.png');
define('DOC_ICON',		IMAGE.'doc_icon.png');
define('TXT_ICON',		IMAGE.'txt_icon.png');
define('COMMON_ICON',		IMAGE.'common_file.png');

/* FB **/

/*define('YOUR_APP_ID', '220455114819794');
define('YOUR_APP_SECRET', '01739d00a434df7c3b6e09d71a3051e2');*/

require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();

$query = $db->get( 'setting' );
foreach( $query->result() as $filed=>$val ){

    define('ADMIN_EMAIL', $val->admin_mail);
    define('ADMIN_PHONE', $val->contact_no);
    define('ADMIN_FACEBOOK', $val->facebook);
    define('ADMIN_TWITTER', $val->twitter);
    define('ADMIN_PINTEREST', $val->pinterest);
    define('ADMIN_LINKEDIN', $val->linkedin);
    define('ADMIN_GOOGLE', $val->google_plus);
    define('ADMIN_RSS', $val->rss);
    define('EMAIL_VERI', $val->email_verify);
    define('TOTAL_BID', $val->total_bid);
    define('TOTAL_POST', $val->total_post);
    define('FIXED_RATE', $val->fix_featured_charge);
    define('HOURLY_RATE', $val->featured_charge_hourly);
    define('CURRENCY', $val->currency);
	define('PAYPAL', $val->paypal_mail);
	define('PAYPAL_MODE', $val->paypal_mode);
	define('BANK_AC', $val->bank_ac);
	define('BANK_AC_NAME', $val->bank_ac_name);
	define('BANK_NAME', $val->bank_name);
	define('BANK_ADDRESS', $val->bank_address);
	define('JOB_EXPIRATION', $val->job_expiration);
	define('YOUR_APP_ID', $val->my_app_id);
	define('YOUR_APP_SECRET', $val->my_app_secret);
	define('SITE_FAVICON', $val->favicon);
	define('SITE_LOGO', $val->site_logo);
	define('ESCROW_CHARGE', $val->escrow_charge);
	define('BAD_WORDS', $val->bad_words);
	define('DEMO', $val->demo);
	define('SKRILL', $val->skrill_mail);
	define('SITE_TITLE', $val->site_title);
	define('ADMIN_ADDRESS', $val->corporate_address);
	define('BID_VIEW', $val->bid_view);

}


/*
BID_VIEW : 1 = Visisble to all  , 0 = Visible to employer and bidder only.
*/


$q2 = $db->get( 'finance_constants' );
foreach( $q2->result() as $k=>$v ){
	define($v->key, $v->value);
}

/* End of file constants.php */
/* Location: ./application/config/constants.php */
