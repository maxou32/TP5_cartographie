<?php

class ControlleurAbonne extends Controlleur{

	public function __construct(){
		//echo"<br />ControlleurAbonne Construct ";
	}
	
	public function executeCarte($params){
		//echo "debut controlleur carte-> execute carte<pre>";print_r($params);echo"</pre>";
		$maView = new AdminAbonneView();
		
		$monAbonne= new AbonneManager();
		$temp['abonne']=$monAbonne->getListAll();
		$temp['niveau']=$this->prepareNiveau();
		$temp['status']=$this->prepareStatus();
		
		isset($_SESSION['niveau']) ? $temp['levelUser']=$_SESSION['niveau'] : $temp['levelUser']=0;
		isset($_SESSION['IdAbonne']) ? $temp['idAbonne']=$_SESSION['IdAbonne'] : $temp['idAbonne']=0;
		
		$contentView=$maView->show($temp);			
		
		$this->appelleTemplate($contentView);
	}
	
	/**
     * recherche les différents niveau d'un abonné
     * @return array contenant les id et libelle des niveau
     */
    private function prepareNiveau(){
		$niveau['1']='Abonné';
		$niveau['2']='Contributeur';
		$niveau['3']='Auteur';
		$niveau['4']='Administrateur';
		
		return $niveau;
	}
	
	 private function prepareStatus(){
		$status['valide']='valide';
		$status['invalide']='invalide';
		$status['suspendu']='suspendu';
		
		return $status;
	}
	
	public function ajoute($params){
		echo"<br />ControlleurAbonne 1<pre>";print_r($params);echo"</pre>";
		
		$donnees=array('nom' => $params['brut']['userName'], 'prenom' => $params['brut']['firstName'], 'email'=>$params['brut']['mail'], 'datecreation' =>mktime(0, 0, 0, date("m")  , date("d"), date("Y")), 'mdp' => hash('sha256',$params['brut']['userPwd']), 'idniveau'=>1, 'status'=>'', 'idavatar'=>Null);
		echo"<br />ControlleurAbonne donnees<pre>";print_r($donnees);echo"</pre>";
		
		$monAbonne= new AbonneManager();
		$result=$monAbonne->add( new Abonne($donnees));
		if (!$result){
			echo"<br />ControlleurAbonne erreur création ";
			$monError=new ControlleurErreur();
			$monError->setError(array("origine"=>CONTROLLEUR."chapterController", "raison"=>"Ajoût d'un nouvel abonné", "numberMessage"=>21));
		}
		echo"<br />ControlleurAbonne création terminée ";
		header ("location: ?action=accueil.html");	
		
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
		foreach ($params['brut']['actionAFaire'] as $key => $value){	
			if (isset($params['brut']["D".$value])){
				echo"delete abonné ".$value;
				$resultat["result"]=$abonneManager->delete($value);
			}else{
				//echo (" abone = ".$value." niveau = ".$params['brut']["N".$value]);
				$donnees=array('idabonne'=>$value,'status'=>$params['brut']["S".$value], 'idniveau'=>$params['brut']["N".$value]);
				$newAbonne = new Abonne($donnees);
				$resultat["result"]=$abonneManager->updateNiveauStatus($newAbonne);
			}
		}
		if ($resultat["result"]){
			
			$monError=new ControlleurErreur();
			$monError->setError(array("origine"=> "web_max\Gesfront\controlleurAbonne\validAbonne", "raison"=>"Mise à jour de la liste des abonnés", "libelle"=>"Vos modifications sont prises en compte"));
		}		
		
		header ("Location:?action=adminAbonne.html");
		//return $resultat["result"];		
	}	
	
}