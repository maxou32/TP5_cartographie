<?php

class Front{

	public function __construct(){

		}
		
	public function executeCarte($params){
		//echo"<br />FRONT: <pre>";print_r($params);echo"</pre>";
		$maView= new View($params['zone']);
		$maView->render();
	}
	
	public function executeUtilisateur(){
		$maView= new View($utilisateur);
		$maView->render();
	}
}