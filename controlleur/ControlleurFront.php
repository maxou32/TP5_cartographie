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
		
		$donnees=array('nom' => $params['nom'], 'description' => $params['description'],'dateDebut' => $params['dateDebut'], 'dateFin'=>$params['dateFin'], 'valide'=>false, 'idauteur'=>5);
		//echo"<br />ControlleurFront addFront 0<pre>";print_r($donnees);echo"</pre>";
		
		$monFront= new FrontManager();
		$result=$monFront->add( new Front($donnees));	
		if (!$result['resultat']){
			echo"<br />ControlleurFront erreur création ";
			/*$monError=new ControlleurErreur();
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurFront", "raison"=>"Ajoût d'un nouveau front", "numberMessage"=>21));
			*/
		}else{
			echo"<br />ControlleurFront création Front terminée ";
		
		//2 creation de la carte
			$result['idFront']=$result['idFront'];
			$params['idFront']=$result['idFront'];
			//echo"<br />ControlleurFront Carte 1 <pre>";print_r($result);echo"</pre>";

			$maCarte= new ControlleurCarte;
			$resultCarte=$maCarte->addCarte($params);
			if (!$result['resultat']){
				echo"<br />ControlleurFront erreur création ";
				/*$monError=new ControlleurErreur();
				$monError->setError(array("origine"=>CONTROLLEUR."ControlleurFront", "raison"=>"Ajoût d'un nouveau front", "numberMessage"=>21));
				*/
			}else{
				$result['idCarte']=$resultCarte['idCarte'];
			}
		}
		//echo "<br />ControlleurFront 2 : <pre>";print_r($result);"</pre>";
			
		return $result;
	}
	
	
	public function demandeSuppressionFront($params){
		echo"<br />Controlleur front 3.5: <pre>";print_r($params);echo"</pre>";
		$monFront= new FrontManager;
		$result=$monFront->getLigneUnFront($params['idFront']);
		if($result){
			echo ("Success");
		}else{
			echo ("suppression impossible"); 
		}	
	}
	
	public function supprimeFront ($params){
		//echo('Demande de suppression pour le front = '.$params['idFront']);
		$monFront= new FrontManager;
		$result=$monFront->delete($params['idFront']);
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
			$temp[$i]['dateDebut']=$mesFronts[$i]->getDateDebut();
			$temp[$i]['dateFin']=$mesFronts[$i]->getDateFin();
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