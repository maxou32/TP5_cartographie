<?php

class ControlleurAccueil extends Controlleur{

	public function __construct(){

	}
	

	
	public function executeUtilisateur(){
		$maView= new View($utilisateur);
		$maView->render();
	}
}