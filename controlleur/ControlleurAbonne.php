<?php

class ControlleurAbonne extends Controlleur{

	public function __construct(){
		echo"<br />ControlleurAbonne Construct ";
	}
	
	public function ajoute($params){
		echo"<br />ControlleurAbonne 1<pre>";print_r($params);echo"</pre>";
		
		$donnees=array('nom' => $params['userName'], 'prenom' => $params['firstName'], 'email'=>$params['mail'], 'datecreation' =>mktime(0, 0, 0, date("m")  , date("d"), date("Y")), 'mdp' => hash('sha256',$params['userPwd']), 'idniveau'=>1, 'status'=>1, 'idavatar'=>Null);
		echo"<br />ControlleurAbonne donnees<pre>";print_r($donnees);echo"</pre>";
		
		$monAbonne= new AbonneManager();
		$result=$monAbonne->	add( new Abonne($donnees));
		if (!$result){
			echo"<br />ControlleurAbonne erreur création ";
			$monError=new ControlleurErreur();
			$monError->setError(array("origine"=>CONTROLLEUR."chapterController", "raison"=>"Ajoût d'un nouvel abonné", "numberMessage"=>21));
		}
		echo"<br />ControlleurAbonne création terminée ";
		header ("location: ?action=accueil.html");	
		
	}
}