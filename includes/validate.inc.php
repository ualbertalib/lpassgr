<?php 
$messaging = new Messaging();

if (isset($_POST['barcode'])){

	$sirsi = new Sirsi();

	$sirsi->setAllowedProfiles($ALLOWED_PROFILES);
	$sirsi->setSirsiUserID( $_POST['barcode'] );

	$login = $sirsi->login( $_POST['pin'] );
	

	if( count($login['USER_KEY']) > 0 ){

			$_SESSION['L_PASS']['USER_KEY'] = $login['USER_KEY'][0];
			
			header('location: eplgo.php');
			exit();

	}else{

		$messaging->addError("Invalid Username/password");

	}

}

?>