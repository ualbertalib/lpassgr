<?php


//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$currentPath = dirname(__FILE__);

$ADMIN_EMAIL = '';

$phpincludePath = "";
set_include_path(get_include_path() . PATH_SEPARATOR . $phpincludePath);



/**
 * $ALLOWED_PROFILES - this specifies the sirsi profile number that is allowed to login and get an L-PASS
 * 
 *  The profile ID number is retreieved from the sirsi.users.profile field in the sirsi database. That ID number is defined in the sirsi.Policy table.
 */
//comma seperated list of policty numbers for allowed user profiles
$ALLOWED_PROFILES = '';

//PASSPHRASE to access grant macewan web services
$MCEWAN_PASSPHRASE = "";

// the URL that users use to login from grant macewan
$MACEWAN_LOGIN_PAGE = "";

//The webservices WSDL file from grant macewan	
$MCEWAN_WSDL = "";

/**
 * $DAYS_REGISTER_BEFORE_EXPIRE sets the number of days before the users' l_PASS expires that the user can re-register again for another L-PASS. 
 * See the EplGo.class.php file for the checkAlreadyRegistered() function
 *
 *  Example: if $DAYS_REGISTER_BEFORE_EXPIRE=20 and the user's L-Pass expires on Sept 20, 2013 they would be able to register for the 2014 year on or after Sept 1 2013 but not before.
 * 
 * @var integer
 */
$DAYS_REGISTER_BEFORE_EXPIRE = 9;


include_once($currentPath.'/classes/EplGoConnect.class.php');
include_once($currentPath.'/classes/EplGo.class.php');
include_once($currentPath.'/classes/Sirsi.class.php');
include_once($currentPath.'/classes/Messaging.class.php');

session_start();


include_once($currentPath.'/helper.inc.php');


if (!empty($_SERVER) && isset($_SERVER['REMOTE_USER'])){
    $REMOTE_USER = $_SERVER['REMOTE_USER'];
}


?>