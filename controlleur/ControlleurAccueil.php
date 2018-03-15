<?php

class ControlleurAccueil extends Controlleur{

	public function __construct(){

	}
	public function montre($param){
		//echo"<br />Controlleur 1 ";
		//echo"<pre>";print_r($param);echo"</pre>";
		
		$fonction=$param['action'];
		$maConfig= new Config();
		$data['style']=$maConfig->getCouleur();
		
		$maCible=$param['cible'];
		$maCarte = new $maCible();
		
		//$mesFronts= new ControlleurFront();
		//$carte=$maView->show(Null);	
		
		isset($_SESSION['niveau']) ? $data['levelUser']=$_SESSION['niveau'] : $data['levelUser']=0;
		//echo "niveau utilisateur = ". $data['levelUser'] ;
		
		$data['maCarte']=$maCarte->$fonction($data);
		//echo"<br />Controlleur 2 ";
		$maView = new $param['classe']();
		//echo"<br />Controlleur 3 ";
		
		$theView=$maView->$fonction($data);	
		//echo"<br />Controlleur 4 ";//echo "<br /> echo de theView <pre>";print_r($theView);echo"</pre>";
		$this->appelleTemplate($theView);
		
	}
	
	public function executeUtilisateur(){
		$maView= new View($utilisateur);
		$maView->render();
	}
}