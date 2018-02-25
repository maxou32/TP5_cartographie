<?php

	
class VerifAjax {
	public function __construct(){
    
	}

	public function user(){ 
		if( isset($_POST['username']) ) {
			$monControlleurAccess = new ControlleurAccess();
			if ($monControlleurAccess->estConnu($_POST['username'])) {         
				echo "Success";    
			}
			else{
				echo "Utilisateur inconnu";
			}
		}else{
			 echo "nothing";			 
		}
	}
}
	
