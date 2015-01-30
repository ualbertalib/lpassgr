<?php

class Messaging{


   private $error = Array();

	

	public  function getErrorString(){
		$msg="";
		if( count($this->error) > 0){
			$msg = "<ul class='error'>";
			foreach($this->error as $key => $value){
				$msg .= "<li>" . $value . "</li>";
			}
			$msg .= "</ul>";
		}
		return $msg;
	}

	public function addError($msg){
		$this->error[] = $msg;
	}
	
	public function getError($msg){
		$this->error[] = $msg;
	}
	
	public function getErrorCount(){
		return count($this->error);
	}
	
}

?>