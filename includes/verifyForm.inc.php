<?php

//set_default();


$_POST['eplBarCode'] = trim($_POST['eplBarCode']);

if ($_POST['EPLQuestion'] == "Yes"){

	if ($_POST['eplBarCode'] ==""){
		$messaging->addError("Please enter in your eplBarCode");
	}
	elseif ( (substr($_POST['eplBarCode'],0,5) != '21221' || strlen($_POST['eplBarCode']) !='14' ) && 
                 (substr($_POST['eplBarCode'],0,3) != '132' || strlen($_POST['eplBarCode']) !='13' ) ){
		$messaging->addError("Your barcode is invalid.  EPL Barcodes start with 21221 and are 14 digits in length.  ");
	}

	if (trim($_POST['currentEplPin']) ==""){
		$messaging->addError("Please enter in your EPL Pin");
	}

	//make sure the newEPLPIN is blank. It theoretically should be this line of code just forces it to be.
	$_POST['newEplPin']="";

	
}else{
		
		if (trim($_POST['newEplPin']) ==""){
			$messaging->addError("You must select a pin");
		}
		if ( strlen($_POST['newEplPin']) <= 4 &&  strlen($_POST['newEplPin']) > 10){
			$messaging->addError("Your pin must be between 4 and 10 characters in length");
		}
		if ($_POST['newEplPin'] != $_POST['confirmEplPin']){
			$messaging->addError("Your pin numbers do not match.");
		}
}

	if ($_POST['homelibrary'] == ""){
		$messaging->addError("You must select a home library.");
	}
	if ( $_POST['homelibrary']!="" &&  strlen($_POST['homelibrary'])!=6 && substr($_POST['homelibrary'],0,3)!='EPL' ){
		$messaging->addError("The home library you selected is invalid" .substr($_POST['homelibrary'],0,3). $_POST['homelibrary']);	
	}

	if ($_POST['gender']!='Male' && $_POST['gender']!='Female' && $_POST['gender']!=''){
		$messaging->addError("Gender has an invalid value");	
	}
	
	if (trim($_POST['birthdate'])==""){
		$messaging->addError("Please enter in your birthdate");	
	}
	
	
	function checkNumber($n){
		if (is_numeric($n)){
			return	 $n;
		}else{
			return 0;
		}
	}

	//mm/dd/yyyy
	$datepart = $parts = explode('/', $_POST['birthdate']);
	
	$_POST['birthdate']=checkNumber($datepart[0]) . '/' . checkNumber($datepart[1]) . '/' . checkNumber($datepart[2]);

	$birthdate_t = mktime(0,0,0,$datepart[0],$datepart[1],$datepart[2]);
	$birthdate_str = date('Y-m-d',$birthdate_t);

