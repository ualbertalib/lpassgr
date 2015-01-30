<?php

function left($str, $length) {
     return substr($str, 0, $length);
}


$con = new EplGoConnect();
 $con->dbConnect();


 $query="
 insert into
				registrant 
				Set
				user_key=:user_key , 
				uofa_barcode=:uofa_barcode ,
				epl_barcode =:eplBarCode  ,
				firstname = :firstname,
				middlename = :middlename ,
				lastname = :lastname,
				phone = :phone ,
				address = :address ,
				line2 = :line2 ,
				cityprov = :cityprov ,
				postalcode= :postalcode ,
				email =  :email ,
				country= :country ,
				entrydate = now() ,
				gender =  :gender,
				birthdate =  :birthdate ,
				termsAgreement =  1 ,
				currentEplPin = :currenteplpin ,
				newEplPin =  :newEplPin,
				homelibrary = :homelibrary,
				EplGoExpires = :EplGoExpires,
				UserProfile = :userProfile
				";

//do not put NULL values in the database as secondary program can't account for NULL				
foreach($_SESSION['userInfo'] as $key=>$value){
	$userInfo[$key][0]=$_SESSION['userInfo'][$key][0];
	if ( is_null($userInfo[$key][0]) ){
		$userInfo[$key][0]="";
	}
}

$sth = $con->prepareSQL($query);

$user_key = $_SESSION['eplgo']->getUserKey();

$sth->bindParam(':user_key', $user_key[0], PDO::PARAM_INT );

$sth->bindParam(':uofa_barcode', $userInfo['ID'][0], PDO::PARAM_STR);
$sth->bindParam(':eplBarCode', $_POST['eplBarCode'], PDO::PARAM_STR);
$sth->bindParam(':firstname', $userInfo['FIRST_NAME'][0], PDO::PARAM_STR);
$sth->bindParam(':middlename', $userInfo['MIDDLE_NAME'][0], PDO::PARAM_STR);
$sth->bindParam(':lastname', $userInfo['LAST_NAME'][0], PDO::PARAM_STR);
$sth->bindParam(':phone', $userInfo['PHONE'][0], PDO::PARAM_STR);
$sth->bindParam(':address', $userInfo['ADDRESS'][0], PDO::PARAM_STR);
$sth->bindParam(':line2', $userInfo['LINE2'][0], PDO::PARAM_STR);
$sth->bindParam(':cityprov', $userInfo['CITYPROV'][0], PDO::PARAM_STR);
$sth->bindParam(':postalcode', $userInfo['POSTALCODE'][0], PDO::PARAM_STR);
$sth->bindParam(':email', $userInfo['EMAIL'][0], PDO::PARAM_STR);
$sth->bindParam(':country', $userInfo['COUNTRY'][0], PDO::PARAM_STR);
$sth->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);
$sth->bindParam(':birthdate', $birthdate_str, PDO::PARAM_STR);
$sth->bindParam(':currenteplpin', $_POST['currentEplPin'], PDO::PARAM_STR);
$sth->bindParam(':newEplPin', $_POST['newEplPin'], PDO::PARAM_STR);
$sth->bindParam(':homelibrary', $_POST['homelibrary'], PDO::PARAM_STR);
$sth->bindParam(':EplGoExpires', $_SESSION['eplgo']->getExpiration() , PDO::PARAM_STR);
$sth->bindParam(':userProfile', $_SESSION['eplgo']->getUserProfile(), PDO::PARAM_STR);

$sth->execute();

header("location: success.php");


