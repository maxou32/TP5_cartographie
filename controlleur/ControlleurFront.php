<?php

class ControlleurFront  extends Controlleur {

	public function __construct(){

		}
		
	public function executeCarte($params){
		//echo "debut controlleur carte-> execute carte<pre>";print_r($params);echo"</pre>";
		$maView = new AdminFrontView();
		
		$monFront= new FrontManager();
		$temp['front']=$monFront->getListAll();
		$temp['valide']=$this->prepareValide();
		//echo "debut controlleur front-> execute carte<pre>";print_r($temp['front']);echo"</pre>";
		isset($_SESSION['niveau']) ? $temp['levelUser']=$_SESSION['niveau'] : $temp['levelUser']=0;
		isset($_SESSION['IdAbonne']) ? $temp['idAbonne']=$_SESSION['IdAbonne'] : $temp['idAbonne']=0;
		
		$contentView=$maView->show($temp);			
		
		$this->appelleTemplate($contentView);
	}
	
	private function prepareValide(){
		$valide[1]='Valide';
		$valide[0]='à valider';
		
		return $valide;
	}
	    /**
     * pour chaque triplet (chapitre, status, numéro) modifie les chapitres
     * 
     * @param  array $params couples à modifier
     * @return boolean resultat de la modification 
     */
    public function validFront($params){	
		//echo"<PRE>CONTROLLER : validStatusChapters 1 ";print_r($params);echo"</PRE>";
		$frontManager= new FrontManager();
		if(isset($params['brut']['actionAFaire'])){
			foreach ($params['brut']['actionAFaire'] as $key => $value){	
				if (isset($params['brut']["D".$value])){
					//echo"delete front ".$value;
					$resultat["result"]=$abonneManager->delete($value);
				}else{
					//echo (" front = ".$value." valide= ".$params['brut']["V".$value]);
					$donnees=array('idfront'=>$value,'valide'=>$params['brut']["V".$value]);
					$newFront = new Front($donnees);
					$resultat["result"]=$frontManager->updateValide($newFront);
				}
			}
			if ($resultat["result"]){
				
				$monError=new ControlleurErreur();
				$monError->setError(array("origine"=> "web_max\Gesfront\controlleurAbonne\validFront", "raison"=>"Mise à jour de la liste des conflits", "libelle"=>"Vos modifications sont prises en compte"));
			}		
		}
		header ("Location:?action=adminFront.html");
		//return $resultat["result"];		
	}	
	
	public function addFront($params){
		//echo "<br />ControlleurLigne 0 : <pre>";print_r($params);"</pre>";
		$params=$this->decoupeParam($params['mesFronts']); 
		//echo "<br />ControlleurLigne 1 : <pre>";print_r($params);"</pre>";	
		
		
		$donnees=array('nom' => $params['nom'], 'description' => $params['description'],'zoom'=> $params['zoom'], 'lat' => $params['lat'], 'lng'=> $params['lng'], 'valide'=>false, 'idauteur'=>$params['idauteur']);
		
		
		$monFront= new FrontManager();
		$result=$monFront->add( new Front($donnees));	
		if (!$result['resultat']){
			echo"<br />ControlleurFront erreur création ";
			/*$monError=new ControlleurErreur();
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurFront", "raison"=>"Ajoût d'un nouveau front", "numberMessage"=>21));
			*/
		}else{
			echo"Success";
		}
		exit;
		//return $result;
	}
	
	public function updateFront($params){
		
		echo "<br />ControlleurFront 0 : <pre>";print_r($params);"</pre>";
		$params=$this->decoupeParam($params['mesFronts']); 
		echo "<br />ControlleurLigne 1 : <pre>";print_r($params);"</pre>";	
		
		$donnees=array('idfront'=>$params['idfront'], 'nom' => $params['nom'],'description' => $params['description'],'zoom'=>$params['zoom'],'lat' => $params['lat'], 'lng'=>$params['lng'], 'idauteur'=>$params['idauteur'],'valide' => $params['valide'] );
		echo"<br />ControlleurFront addFront 0<pre>";print_r($donnees);echo"</pre>";
		
		$monFront= new FrontManager();
		$result=$monFront->update( new Front($donnees));	
		echo"<br />ControlleurFront<pre>";print_r($result);echo"</pre>";
		if (!$result['resultat']){
			//echo"<br />ControlleurDateFront erreur création ";
				$monError=new ControlleurErreur();
				$monError->setError(array("origine"=> "web_max\Gesfront\controlleurAbonne\validFront", "raison"=>"Mise à jour des fronts", "libelle"=>"Vos modifications ne sont pas prises en compte"));
		}else{
			echo"Success";
		}			
		//return $result;
	}
		
	public function deleteFront ($params){
		//echo "<br />ControlleurLigne 1 : <pre>";print_r($params);"</pre>";	
		//$params=$this->decoupeParam($params['iddate']); 
		//echo('Demande de suppression pour le front = '.$params['idfront']);
		//echo "<br />ControlleurLigne 2 : <pre>";print_r($params);"</pre>";	
		
		$monFront= new FrontManager();
		$result=$monFront->delete($params['idfront']);
		if($result){
			echo ("Success");
		}else{
			$monError=new ControlleurErreur();
			$monError->setError(array("origine"=> "web_max\Gesfront\controlleurAbonne\validFront", "raison"=>"Suppresion de fronts", "libelle"=>"Vos modifications ne sont pas prises en compte"));
		}
	}
	
	public function LireTousFrontsSeuls(){
		$monFrontManager = new FrontManager();
		$mesFronts=$monFrontManager->getListValide();
		
		
		for($i=0; $i < count($mesFronts);$i++){
			$id=$mesFronts[$i]->getIdFront();
			
			//echo "<br /> id = ".$id; 
			
			//$temp[$i]=[];
			$temp[$i]['idfront']=$mesFronts[$i]->getIdFront();  
			$temp[$i]['idauteur']=$mesFronts[$i]->getIdAuteur();
			$temp[$i]['zoom']=$mesFronts[$i]->getZoom();
			$temp[$i]['lat']=$mesFronts[$i]->getLat();
			$temp[$i]['lng']=$mesFronts[$i]->getLng();
			$temp[$i]['nom']=$mesFronts[$i]->getNom();
			$temp[$i]['description']=$mesFronts[$i]->getDescription();
			$temp[$i]['valide']=$mesFronts[$i]->getValide();

		}
		//echo "<br />ControlleurFront 3 : <pre>";print_r($temp);"</pre>";
		echo json_encode($temp);	
		//return $temp;	
	}
	
	public function lireTousFronts(){
		$monFrontManager = new FrontManager();
		if (isset($_SESSION['niveau'])){
			$_SESSION['niveau'] === 4 ? $mesFronts=$monFrontManager->getListAll() : $mesFronts=$monFrontManager->getListValide();
		}else{
			$mesFronts=$monFrontManager->getListValide();
		}
		
		
		for($i=0; $i < count($mesFronts);$i++){
			$id=$mesFronts[$i]->getIdFront();
			
			//echo "<br /> id = ".$id;
			
			$temp[$i]=[];
			$temp[$i]['idfront']=$mesFronts[$i]->getIdFront();
			$temp[$i]['idauteur']=$mesFronts[$i]->getIdAuteur();
			$temp[$i]['zoom']=$mesFronts[$i]->getZoom();
			$temp[$i]['lat']=$mesFronts[$i]->getLat();
			$temp[$i]['lng']=$mesFronts[$i]->getLng();
			$temp[$i]['nom']=$mesFronts[$i]->getNom();
			$temp[$i]['description']=$mesFronts[$i]->getDescription();
			$temp[$i]['valide']=$mesFronts[$i]->getValide();
			
			//echo "<br />ControlleurFront 3 : <pre>";print_r($temp[$i]);"</pre>";
			//$temp[$i]['carte']
			
			/*
			$monControlleurLigne= new ControlleurLigne;
			$temp[$i]['ligne']=$monControlleurLigne->LireLignesUnFront($id);
			*/
		}
		//echo "<br />ControlleurFront 3 : <pre>";print_r($temp);"</pre>";
		return $temp;
	}
	
	public function jsonTousFronts(){
		$maConfig = new Config;
		
		$contenu_json =json_encode($this->lireTousFronts());

		// Nom du fichier à créer
		$fronts = $maConfig->getFichierJSON();

		// Ouverture du fichier
		$fichier = fopen($fronts, 'w+');

		// Ecriture dans le fichier
		fwrite($fichier, $contenu_json);

		// Fermeture du fichier
		fclose($fichier);
	}
	
	public function lireJSON(){
		// Si les données json sont dans un fichier distant:
		$json_source = file_get_contents('public/json/fronts.json');

		// Décode le JSON
		$json_data = json_decode($json_source);

		// Affiche la valeur des attributs du JSON
		echo "<br />ControlleurFront 3 : <pre>";print_r($json_data);"</pre>";
	}
}