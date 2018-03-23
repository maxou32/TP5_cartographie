<?php

class ControlleurMessage extends Controlleur{

	public function __construct(){
		//echo"<br />ControlleurMessage Construct ";
	}
	
	public function executeCarte($params){
		//echo "debut controlleur carte-> execute carte<pre>";print_r($params);echo"</pre>";
		$maView = new MessageView();
		$contentView=$maView->show(Null);	
		$this->appelleTemplate($contentView);
	}
	
	
	public function validMessage($params){
		//echo"<br />Controlleur Message 1<pre>";print_r($params['brut']);echo"</pre>";
		
		$donnees=array('nom' => $params['brut']['nom'], 'prenom' => $params['brut']['prenom'], 'email'=>$params['brut']['email'], 'objet' => $params['brut']['objet'], 'texte'=>$params['brut']['texte'], 'lu'=>0);
		//echo"<br />ControlleurMessage <pre>";print_r($donnees);echo"</pre>";
		
		$monMessage= new MessageManager();
		$result=$monMessage->add( new Message($donnees));
		$monError=new ControlleurErreur();
		if (!$result){
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurMessage", "raison"=>"Enregistrement d'un nouveau message", "libelle"=>"Votre message n'a pas pu être enregistré."));
		}else{
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurMessage", "raison"=>"Enregistrement d'un nouveau message", "libelle"=>"Votre message est enregistré."));
		}
		//echo"<br />ControlleurMessage création terminée ";
		header ("location: ?action=accueil.html");	
		
	}
	public function donneMessage($params){
		$maView = new VoirMessagesView();		
		
		$monMessage= new MessageManager();
		$temp['message']=$monMessage->getListAll();
		
		isset($_SESSION['niveau']) ? $temp['levelUser']=$_SESSION['niveau'] : $temp['levelUser']=0;
		isset($_SESSION['IdMessage']) ? $temp['idMessage']=$_SESSION['IdMessage'] : $temp['idMessage']=0;
		
		$paramView=$maView->show($temp);			
		
		$this->appelleTemplate($paramView);
	}
	
	public function noteMessageLu($params){
		echo"<br />Controlleur Message 1<pre>";print_r($params);echo"</pre>";
		$monMessage= new MessageManager();
		
		foreach ($params['brut']as $key => $value){	
			if (is_numeric($key)){
				echo ("<br/> nom = ".$key." lu = ".$value);
				$value === 'on' ? $etat=true :$etat=false ;
				$donnees=array('idmessage'=>$key, 'lu'=>$etat);
				$newMessage = new Message($donnees);
				$resultat["result"]=$monMessage->updateLu($newMessage);
			}else{
				echo ("<br/> nom = ".$key." non lu = ".$value);
				$key=substr($key, 1); 
				$value === 'off' ? $etat=true :$etat=false ;
				$donnees=array('idmessage'=>$key, 'lu'=>$etat);
				$newMessage = new Message($donnees);
				$resultat["result"]=$monMessage->updateLu($newMessage);
			}
		}
		
		$monError=new ControlleurErreur();
		if (!$resultat["result"]){
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurMessage", "raison"=>"Lecture des messages", "libelle"=>"les messages lus n'ont pas pu être marqués comme tels."));
		}else{
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurMessage", "raison"=>"Lecture des messages", "libelle"=>"Les messages lus sont marqués comme tels."));
		}
		//echo"<br />ControlleurMessage création terminée ";
		header ("location: ?action=accueil.html");	
	}
	
}