<?php

class Carte(){

	public function __construct(){

		}
		
	public function executeCarte($zone){
		$maView= new View($zone);
		$maView->render();
	}
	
	public function executeUtilisateur(){
		$maView= new View($utilisateur);
		$maView->render();
	}
}