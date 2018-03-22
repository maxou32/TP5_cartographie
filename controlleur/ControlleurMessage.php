<?php

class ControlleurMessage extends Controlleur{

	public function __construct(){
		//echo"<br />ControlleurAbonne Construct ";
	}
	
	public function executeCarte($params){
		//echo "debut controlleur carte-> execute carte<pre>";print_r($params);echo"</pre>";
		$maView = new MessageView();
		$contentView=$maView->show(Null);	
		$this->appelleTemplate($contentView);
	}
	
	
	public function validMessage($params){
		echo"<br />Controlleur Message 1<pre>";print_r($params['brut']);echo"</pre>";
		
		$donnees=array('nom' => $params['brut']['nom'], 'prenom' => $params['brut']['prenom'], 'email'=>$params['brut']['email'], 'objet' => $params['brut']['objet'], 'texte'=>$params['brut']['texte'], 'lu'=>0);
		echo"<br />ControlleurMessage <pre>";print_r($donnees);echo"</pre>";
		
		$monMessage= new MessageManager();
		$result=$monMessage->add( new Message($donnees));
		$monError=new ControlleurErreur();
		if (!$result){
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurMessage", "raison"=>"Enregistrement d'un nouveau message", "libelle"=>"Votre message n'a pas pu être enregistré."));
		}else{
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurMessage", "raison"=>"Enregistrement d'un nouveau message", "libelle"=>"Votre message est enregistré."));
		}
		//echo"<br />ControlleurAbonne création terminée ";
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