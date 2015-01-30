<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EplGoConnect
 *
 * @author Jeremy Hennig <jhennig@ualberta.ca>
 */
class EplGoConnect {
    //put your code here
    
     //put your code here
    
    private $host='',$dbName="", $user='',$password='';
    private $config;
    private $dbh, $sth;
	
	public function __construct() {
       $currentPath = dirname(__FILE__);
       $this->config = parse_ini_file($currentPath.'/../db_config.ini.php', true);
	   $this->user = $this->config['EPLGO']['DBUSER'];
	   $this->host = $this->config['EPLGO']['DBHOST'];
	   $this->dbName = $this->config['EPLGO']['DBNAME'];
	   $this->password = $this->config['EPLGO']['DBPASSWORD'];
    }
    
    function dbConnect(){
        
            try{
                    $this->dbh = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                    $this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                    
                    return $this->dbh;                    
            }catch(PDOException $e){
                    // Do not user a print_r($e) statement as it will display the password                    
                    print("Transaction failed " . $e->getMessage() . "\n");
            }	        
    }
    
    public function prepareSQL($sql){
         try{
            $this->sth = $this->dbh->prepare($sql);
            
			return $this->sth;
        
        } catch(Exception $ex){
            print("Exception: " . $ex->getMessage() . "\n");
        }
    }
    
     public function dbexec($paramArray=Array()){        
        try{			
            $this->sth->execute($paramArray);
         
        }catch(Exception $e){
                    // Do not user a print_r($e) statement as it will display the password                    
                    print("Exec failed " . $e->getMessage() . "\n");
       }
    }
    
    
    public function dbfetchAll(){
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    
    
}

?>