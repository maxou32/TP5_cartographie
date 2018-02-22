	<?php

class ControlleurMap extends Controlleur{

	public function __construct(){

		}
		
	public function executeCarte($params){
		$maCible=$params['cible'];
		$maView = new $maCible();
		$maConfig= new Config();
		
		if (isset($params['proprieteLeaflet'])){
			if($params['proprieteLeaflet']){
				$paramView['zoom']=$maConfig->getProprieteLeaflet()['zoom'];
				$paramView['latCentre']=$maConfig->getProprieteLeaflet()['latCentre'];
				$paramView['lngCentre']=$maConfig->getProprieteLeaflet()['lngCentre'];
				$paramView['maxZoom']=$maConfig->getProprieteLeaflet()['maxZoom'];
				$paramView['tileSize']=$maConfig->getProprieteLeaflet()['tileSize'];
				$paramView['boxZoom']=$maConfig->getProprieteLeaflet()['boxZoom'];
				$paramView['attribution']=$maConfig->getProprieteLeaflet()['attribution'];
				$paramView['layer']=$maConfig->getProprieteLeaflet()['layer'];
				//echo "<pre>";print_r($paramView);echo"</pre>";
			}
		}
		$carte=$maView->show($paramView);	
		
		$this->appelleTemplate($carte);
		
	}
	
	public function executeUtilisateur(){
		$maView= new View($utilisateur);
		$maView->render();
	}
	
	public function addCarte($params){
				
		$supprime = array("LatLng(",")");			
		$latlngTemp=str_replace($supprime, '', $params['latlngCarte']);
		$latlngFinal=explode(',',$latlngTemp);
		
		// $params['projection'], $params['layeroption']
		
		$donnees=array('zoom' => $params['zoom'], 'lat' => $latlngFinal['0'], 'lng' => $latlngFinal['1'], 'projection'=>'', 'layeroption'=>'', 'nom'=>$params['nom'], 'idfront'=>$params['idFront']);
		
		//echo"<br />ControlleurMap carte 1 <pre>";print_r($donnees);echo"</pre>";
		
		$monCarte= new CarteManager();
		$result=$monCarte->add( new Carte($donnees));
		
		//echo"<br />ControlleurMap carte 2 <pre>";print_r($result);echo"</pre>";
		
		if (!$result['resultat']){
			echo"<br />ControlleurFront erreur création ";
			$monError=new ControlleurErreur();
			$monError->setError(array("origine"=>CONTROLLEUR."ControlleurMap", "raison"=>"Ajoût d'une nouvelle carte", "numberMessage"=>21));
		}
		//echo"<br />ControlleurMap carte 3 création Carte terminée ";
		
		return $result;
	}
	
	public function LireUneCarte($idFront){
		$maCarteManager = new CarteManager();
		$maCarte=$maCarteManager->getCarteUnFront($idFront);
		//echo"<br />ControlleurMap carte 4 <pre>";print_r($maCarte);echo"</pre>";
		return $maCarte; 
	}
}

