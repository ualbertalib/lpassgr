<?php

require_once('config.inc.php');
$session_id = "";
//Check for Provided Session
  if((isset($_POST['sid'])) && ($_POST['sid'] <> "")) {
    $session_id = $_POST['sid'];
  } elseif ((isset($_GET['sid'])) && ($_GET['sid'] <> "")) {
    $session_id = $_GET['sid'];
  }

  if ($session_id == ""){
	echo "Error a session ID was not passed to the program. Cannot validate user.";
	exit();
  }
  
  
 
  if($session_id <> "") {
    //We got a session_id from somewhere... let's check it out
    $soap_client = new SoapClient($MCEWAN_WSDL, array('soap_version' => SOAP_1_2));
 
    if($soap_client->checkSession($MCEWAN_PASSPHRASE, $session_id)) {
      //We're Valid!
     
        $login_args = $soap_client->getLoginArgs($MCEWAN_PASSPHRASE, $session_id);
     
		$userName = $login_args->keydata[0]->data;
		$person_id = $login_args->keydata[1]->data;
		$person_id = '32' . str_pad($person_id,8,'0',STR_PAD_LEFT);
		
		$messaging = new Messaging();
		$sirsi = new Sirsi();
		$sirsi->setAllowedProfiles($ALLOWED_PROFILES);
		$sirsi->setAlternateID( $person_id );
		
		$_SESSION['userInfo']= $sirsi->getUserInfo();
		
		
		$briefUserInfo = $sirsi->getValidation();
		
		if (count($briefUserInfo['USER_KEY']) ==  0){
			
			echo "Based on your MacEwan University status, it appears that you are not eligible for this service.<br>
				If you are a MacEwan faculty or staff member you may need a new Library card to qualify for the L-Pass service<br>
				<br><br>
				Please contact the <a target=_blank href=\"http://library.macewan.ca/contact_us\">Borrower Services</a> desk at your campus for assistance.
						<br>";
				exit();
		}
		$_SESSION['eplgo'] = new EplGo();
		$_SESSION['eplgo']->setUserKey($briefUserInfo['USER_KEY']);
		$_SESSION['eplgo']->setUserProfile($_SESSION['userInfo']['USERPROFILE'][0]); 
		if($_SESSION['eplgo']->checkAlreadyRegistered()){
			echo "You have already registered for this Edmonton Public Library service. Your account will expire on
										" . $_SESSION['eplgo']->getUserExpirationDate() . ". You may register after your account expires, provided you are still a student at Macewan University.									
								Please review the <a target='_parent' href='http://library.macewan.ca/lpass_help'>L-Pass Help Page</a> for more information or contact
								any <a target=\"_blank\" href=\"http://library.macewan.ca/contact_us\">Borrower Services</a> desk for assistance.<br>";
								
								exit();
			
		}
		
		
		if ( ! empty($_POST) ){
			include_once('./includes/verifyForm.inc.php');
				if ($messaging->getErrorCount() == 0){
				
						include_once('./includes/saveinfo.inc.php');
				}
		}
		
		include('includes/dsp_form.inc.php');
		
		
		
		
 
    } else {
		
	
      //There is no session in the database matching your session id... send to login page.
      //header('Location: ' . $MACEWAN_LOGIN_PAGE);
    }
  } else {
    //There is no session id cookie or argument... send to login page.
    //header('Location: ' . $MACEWAN_LOGIN_PAGE);
  }
  
?>  