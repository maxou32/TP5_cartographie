<?php

class ControlleurFront  extends Controlleur {

	public function __construct(){

		}
		
	public function executeCarte($params){
		//echo"<br />FRONT: <pre>";print_r($params);echo"</pre>";
		$maView= new View($params['zone']);
		
		$maView->render();
	}
	
	public function executeUtilisateur(){
		$maView= new View($utilisateur);
		$maView->render();
	}
	
	
	
	public function addFront($params){
		//echo "<br />ControlleurLigne 0 : <pre>";print_r($paramsBrut);"</pre>";
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
			/*$monError=new ControlleurErreur();
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurFront", "raison"=>"Ajoût d'un nouveau front", "numberMessage"=>21));
			*/
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
			echo ("suppression impossible"); 
		}
	}
	
	public function LireTousFrontsSeuls(){
		$monFrontManager = new FrontManager();
		$mesFronts=$monFrontManager->getListAll();
		
		
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
		$mesFronts=$monFrontManager->getListAll();
		
		
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