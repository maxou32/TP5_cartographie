<?php

	
class verifAjax {
	public function __construct(){
    
	}

	public function user(){
	  
		if( isset($_POST['username']) ) {
			$monControlleurAccess = new ControlleurAccess();
			if ($monControlleurAccess->estConnu($_POST['username'])) {     
			
			//if ($_POST['username'] ==='cante') {            
				echo "Success";    
			}
			else{
				echo "Failed1";
			}
		}else{
			
			 echo "Failed2";
			 
		}
	}
}	
