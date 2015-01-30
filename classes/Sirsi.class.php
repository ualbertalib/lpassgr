<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sirsi
 *
 * @author Jeremy Hennig <jhennig@ualberta.ca>
 */
class Sirsi {
    //put your code here
    
    private $user_keyArray, $userKey;

    private $allowedProfiles;
    
    private $sirsiUserID;

    private $user, $host, $dbName, $password, $sid, $alternateID;



    public function setAllowedProfiles($profiles){
      $this->allowedProfiles = $profiles;
    }


    public function getAllowedProfiles(){
     return $this->allowedProfiles;
    }
	
	public function setAlternateID( $alternateID ){
		$this->alternateID = $alternateID;
	}
	
	public function getAlternateID(){
		return $this->alternateID ;
	}
    
    /**
     * requires a userkey in the format of $userKeyArray = Array ( [0] => Array ( [user_key] => 585786 ) 
     * if the function gets passed just a plain variable it will try to convert it to the appropriate format
     * @param array $userKey
     */
    public function setUserKeyArray($userKey){
      //if $userKey is not an array them make it one, becuase the sirsi class expects it to be an array
      if (! is_array($userKey)){
       
        $myUserKeyArray[0] = array('user_key'=> $userKey);  
        $this->userKeyArray = $myUserKeyArray;
      }else{
        $this->userKeyArray = $userKey;        
      }
             
    }
    public function getUserKeyArray(){
        return $this->userKeyArray;
    }
    
    public function setUserKey($user_key){
        $this->userKey = $user_key;
    }
    public function getUserKey(){
        return $this->userKey;
    }

    public function setSirsiUserID ($id){
        $this->sirsiUserID=trim($id);
    }

    public function getSirsiUserID (){
        return $this->sirsiUserID;
    }
    
    
    function ociOracleConnect(){
		//echo $user. ', ' . $pass. ', ' . '//'.$host.'/'.$sid;
          $currentPath = dirname(__FILE__);
            $this->config = parse_ini_file($currentPath.'/../db_config.ini.php', true);
            $this->user = $this->config['SIRSI']['DBUSER'];
            $this->host = $this->config['SIRSI']['DBHOST'];
            $this->dbName = $this->config['SIRSI']['DBNAME'];
            $this->password = $this->config['SIRSI']['DBPASSWORD'];
            $this->sid = $this->config['SIRSI']['SID'];

		$conn= oci_connect($this->user, $this->password, '//'.$this->host.'/'.$this->sid);
		if (!$conn) {
			$e = oci_error();
    		echo "error";
    		echo $e['message'];
    		
    		//trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    	}
    	return $conn;
   }
   
           
        
    
    function getValidation(){
        
        $conn = $this->ociOracleConnect();
        
        if ($this->getAllowedProfiles() == ""){
          throw new Exception("ERROR: Allowed Profiles Not Set", 1);
        }
      
      
         $sql = "SELECT user_key, ID, alternative_id, library, profile
    				  FROM sirsi.users u
    				  WHERE (DATE_PRIVILEGE_EXPIRES > sysdate OR '1900-01-01' = to_char(DATE_PRIVILEGE_EXPIRES,'YYYY-MM-DD'))  
    				       AND alternative_id =:personid  AND profile in ( " . $this->getAllowedProfiles() . " )";

                        
		 $stid = oci_parse($conn, $sql);
         oci_bind_by_name($stid, ':personid', $this->getAlternateID(), -1); 
         oci_execute($stid);
         oci_fetch_all($stid, $res);
        
        return $res;
        
    }

    function login($pin){

      try{
     
       if ($this->getAllowedProfiles() == ""){
          throw new Exception("ERROR: Allowed Profiles Not Set", 1);
        }

      $conn = $this->ociOracleConnect();

          $sql = "SELECT user_key, ID, alternative_id, library, profile
              FROM sirsi.users u
              WHERE (DATE_PRIVILEGE_EXPIRES > sysdate OR '1900-01-01' = to_char(DATE_PRIVILEGE_EXPIRES,'YYYY-MM-DD'))  
                    AND u.id = :id and u.pin = :pin AND profile in ( " . $this->getAllowedProfiles() . " )";
       
         $stid = oci_parse($conn, $sql);
              oci_bind_by_name($stid, ':id', $this->getSirsiUserID(), -1); 
              oci_bind_by_name($stid, ':pin', $pin, -1); 
          
         oci_execute($stid);
         oci_fetch_all($stid, $res);
        

		  return $res;
        }catch (Exception $e){

            echo "Error: " . $e->getMessage();
            exit();

        }
    }
    
       
    /**
		get's most of the users information from the sirsi database
	**/
    function getUserInfo(){
       
            $conn = $this->ociOracleConnect();
			        
            $sql= "SELECT u.user_key, u.id, u.name as last_name , first_name, middle_name,  DATE_PRIVILEGE_EXPIRES, p.policy_name as userProfile,
										max(decode(X.entry_number,9026,X.entry,NULL)) as Phone,
										max(decode(X.entry_number,9019,X.entry,NULL)) as PostalCode,
								     	max(decode(X.entry_number,9068,X.entry,NULL)) as Address,
										max(decode(X.entry_number,9024,X.entry,NULL)) as Line2,
								     	max(decode(X.entry_number,9007,trim(X.entry),NULL)) as Email,
								     	max(decode(X.entry_number,9008,X.entry,NULL)) as Country,
								     	max(decode(X.entry_number,1003,X.entry,NULL)) as CityProv

								  FROM sirsi.users u, sirsi.userxinfo x, sirsi.policy p
								  WHERE (DATE_PRIVILEGE_EXPIRES > sysdate  OR ('1900-01-01') = to_char(DATE_PRIVILEGE_EXPIRES,'YYYY-MM-DD') )
								  		AND ( u.address_offset_1 = x.offset OR u.address_offset_2 = x.offset OR u.address_offset_3 = x.offset )

										AND alternative_id =:personid 
										and u.profile in ( " . $this->getAllowedProfiles() . ") 
										and POLICY_type = 'UPRF' and u.profile = p.policy_number
								group by u.user_key, u.id, u.name,first_name, middle_name, DATE_PRIVILEGE_EXPIRES, p.policy_name";
            

             $stid = oci_parse($conn, $sql);
              oci_bind_by_name($stid, ':personid', $this->getAlternateID(), -1); 
              
              oci_execute($stid);
	          oci_fetch_all($stid, $res);

        return $res;
        
    }


    
    
}

?>