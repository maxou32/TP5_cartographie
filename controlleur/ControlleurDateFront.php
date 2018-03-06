<?php

class ControlleurDateFront  extends Controlleur {

	public function __construct(){

		}
	public function DonneNbEnreg($params){
		$monDatesFront= new DatesFrontManager();
		$mesDatesFronts=$monDatesFront->getListUnFront($params['idfront']);
		echo count($mesDatesFronts);
	}
	public function maxId (){
		$monDatesFront= new DatesFrontManager();
		$maxId=$monDatesFront->getMaxId();
		echo $maxId;		
	}
	
	public function addDateFront($params){
		
		//echo "<br />ControlleurLigne 0 : <pre>";print_r($params);"</pre>";
		$params=$this->decoupeParam($params['maDate']); 
		//echo "<br />ControlleurLigne 1 : <pre>";print_r($params);"</pre>";	
		
		$donnees=array('description' => $params['description'],'valide'=>false,'numordre' => $params['numordre'], 'date'=>$params['date'],  'idfront'=>$params['idfront']);
		//echo"<br />ControlleurFront addFront 0<pre>";print_r($donnees);echo"</pre>";
		
		$monDatesFront= new DatesFrontManager();
		$result=$monDatesFront->add( new DatesFront($donnees));	
		//echo"<br />ControlleurDateFront<pre>";print_r($result);echo"</pre>";
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
	
	public function updateDateFront($params){
		
		//echo "<br />ControlleurLigne 0 : <pre>";print_r($params);"</pre>";
		$params=$this->decoupeParam($params['madate']); 
		//echo "<br />ControlleurLigne 1 : <pre>";print_r($params);"</pre>";	
		
		$donnees=array('iddate' => $params['iddate'],'description' => $params['description'],'valide'=>false,'numordre' => $params['numordre'], 'date'=>$params['date'],  'idfront'=>$params['idfront']);
		//echo"<br />ControlleurFront addFront 0<pre>";print_r($donnees);echo"</pre>";
		
		$monDatesFront= new DatesFrontManager();
		$result=$monDatesFront->update( new DatesFront($donnees));	
		//echo"<br />ControlleurDateFront<pre>";print_r($result);echo"</pre>";
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
	
	public function deleteDateFront ($params){
		//echo "<br />ControlleurLigne 1 : <pre>";print_r($params);"</pre>";	
		//$params=$this->decoupeParam($params['iddate']); 
		//echo('Demande de suppression pour le front = '.$params['iddate']);
		//echo "<br />ControlleurLigne 2 : <pre>";print_r($params);"</pre>";	
		
		$monDatesFront= new DatesFrontManager();
		$result=$monDatesFront->delete($params['iddate']);
		if($result){
			echo ("Success");
		}else{
			echo ("suppression impossible"); 
		}
	}
	
	public function LireDatesSeulesUnFront($params){
		$monDatesFront= new DatesFrontManager();
		$mesDatesFronts=$monDatesFront->getListUnFront($params['idfront']);
		//echo"<pre>";print_r($params);echo"</pre>";
		//echo"<pre>";print_r($mesDatesFronts);echo"</pre>";
		$temp=[];
		for($i=0; $i < count($mesDatesFronts);$i++){
			//$id=$mesDatesFronts[$i]->getIddate();

			$temp[$i]=[];
			$temp[$i]['iddate']=$mesDatesFronts[$i]->getIddate();
			$temp[$i]['description']=$mesDatesFronts[$i]->getDescription();
			$temp[$i]['numordre']=$mesDatesFronts[$i]->getNumordre();
			$temp[$i]['date']=$mesDatesFronts[$i]->getDate();
			$temp[$i]['idfront']=$mesDatesFronts[$i]->getIdFront();
			$temp[$i]['valide']=$mesDatesFronts[$i]->getValide();
			
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
			
			echo "<br /> id = ".$id;
			
			$temp[$i]=[];
			$temp[$i]['idfront']=$mesFronts[$i]->getIdFront();
			$temp[$i]['idauteur']=$mesFronts[$i]->getIdAuteur();
			$temp[$i]['dateDebut']=$mesFronts[$i]->getDateDebut();
			$temp[$i]['dateFin']=$mesFronts[$i]->getDateFin();
			$temp[$i]['nom']=$mesFronts[$i]->getNom();
			$temp[$i]['description']=$mesFronts[$i]->getDescription();
			$temp[$i]['valide']=$mesFronts[$i]->getValide();
			
			
			$monControlleurCarte= new ControlleurCarte;
			$temp[$i]['carte']=$monControlleurCarte->LireUneCarte($id);
			//echo "<br />ControlleurFront 3 : <pre>";print_r($temp[$i]);"</pre>";
			//$temp[$i]['carte']
			
			
			$monControlleurLigne= new ControlleurLigne;
			$temp[$i]['ligne']=$monControlleurLigne->LireLignesUnFront($id);
			
		}
		echo "<br />ControlleurFront 3 : <pre>";print_r($temp);"</pre>";
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