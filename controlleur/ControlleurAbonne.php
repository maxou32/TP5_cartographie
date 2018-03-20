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
	
	/**
     * recherche les différents niveau d'un abonné
     * @return array contenant les id et libelle des niveau
     */
    public function prepareNiveau(){
		$niveau['1']='Abonné';
		$niveau['2']='Contributeur';
		$niveau['3']='Auteur';
		$niveau['4']='Administrateur';
		
		return $niveau;
	}
    /**
     * pour chaque triplet (chapitre, status, numéro) modifie les chapitres
     * 
     * @param  array $params couples à modifier
     * @return boolean resultat de la modification
     */
    public function validAbonne($params){	
		//echo"<PRE>CONTROLLER : validStatusChapters 1 ";print_r($params);echo"</PRE>";

		$abonneManager= new AbonneManager();
		foreach ($params['actionAFaire'] as $key => $value){	
			if (isset($params["D".$value])){
				$resultat["result"]=$abonneManager->delete($value);
			}else{
				$donnees=array('idabonne'=>$value,'status'=>$params["S".$value], 'niveau'=>$params["G".$value]);
				$newAbonne = new Abonne($donnees);
				$resultat["result"]=$abonneManager->update($newAbonne);
			}
		}
		if ($resultat["result"]){
			$monError=new ErrorController();
			$monError->setError(array("origine"=> "web_max\Gesfront\controlleurAbonne\validAbonne", "raison"=>"Mise à jour de la liste des abonés", "numberMessage"=>23));
		}		
		return $resultat["result"];		
	}	
	
}