<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EplGoDB
 *
 * @author Jeremy Hennig <jhennig@ualberta.ca>
 */
class EplGo {
    //put your code here
    
    private $userKey, $userExpirationDate,$userProfile;
    
    function setUserKey($userKey){
        $this->userKey=$userKey;
    }
    
    function getUserKey(){
        return $this->userKey;        
    }

   
    
    public function getUserExpirationDate() {
        return $this->userExpirationDate;
    }

    public function setUserExpirationDate($userExpirationDate) {
        
        $this->userExpirationDate = $userExpirationDate;

    }

    function setUserProfile($prf){
        $this->userProfile = $prf;
    }
    function getUserProfile(){
        return $this->userProfile;
    }
	
	/**
		returns what the expiration date of the Grant Macewan user would be if they signed up right now.
	**/
	function getExpiration(){
		$expires="";
			$currentDate = date('Y-m-d');
			//August 29
			$beginingDate = mktime(0,0,0,8,29,date("Y"));
			//December 31
			$endDate = mktime(0,0,0,12,31,date("Y"));
			$currentYear = date('Y');
			$nextYear = $currentYear + 1;
		// if current date is between Aug 29 and Dec 31
		if ( $currentDate > $beginingDate && $currentDate < $endDate ) { 
			$expires = mktime(0,0,0,8,31,$nextYear);
		}else{
			 $expires = mktime(0,0,0,8,31, $currentYear ); 
		}
		return date('Y-m-d',$expires);
	}

   

        
    /**
     * If the user has already registered for this acedemic year then this function will return true. Otherwise it will return a false
     * 
     * @return bool
     */
    function checkAlreadyRegistered (){
        
        
        $con = new EplGoConnect();
        
        $alreadyReg = false;
        
        $con->dbConnect();
        //Get the user if their expiration date is more then 20 day away
        $sql = "Select user_key, EplGoExpires from registrant 
				where user_key=? and EplGoExpires = '" . $this->getExpiration() ."'" ;
        
        $con->prepareSQL($sql);
        
        $paramArray = $this->getUserKey();
        $con->dbexec($paramArray);
        
        $registrant = $con->dbfetchAll();
     

     
        
        if (count($registrant)>0){
            $this->setUserExpirationDate($registrant[0]['EplGoExpires']);
            $alreadyReg = true;
        }


        //print_r($registrant);
        
        return  $alreadyReg;
        
    }
    
    
    
    
}

?>
