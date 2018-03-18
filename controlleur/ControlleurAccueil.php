<?php

class ControlleurAccueil extends Controlleur{

	public function __construct(){

	}
	public function montre($param){
		//echo"<br />Controlleur 1 ";
		//echo"<pre>";print_r($param);echo"</pre>";
		
		$maCible=$param['cible'];
		$maCarte = new $maCible();
		$fonction=$param['action'];
		
		//chargement de la carte
		$monControleurCarte= new ControlleurCarte();
		$data=$monControleurCarte->executeCarte($param);
		//echo "<br /> echo de controlleur carte <pre>";print_r($data);echo"</pre>";
		
		//chargement des parametres d'affichage
		$maConfig= new Config();
		$data['style']=$maConfig->getCouleur();
		
		//$mesFronts= new ControlleurFront();
			
		// chargement du jeu de données dans le data de la vue
		$data['maCarte']=$maCarte->$fonction($data);
		//echo"<br />Controlleur 2 ";
		$maView = new $param['classe']();
		//echo"<br />Controlleur 3 ";
		
		$theView=$maView->$fonction($data);	
		//echo"<br />Controlleur 4 ";
		$this->appelleTemplate($theView);
		
	}
	
	public function executeUtilisateur(){
		$maView= new View($utilisateur);
		$maView->render();
	}
}