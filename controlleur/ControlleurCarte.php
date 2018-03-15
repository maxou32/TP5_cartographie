	<?php

class ControlleurCarte extends Controlleur{

	public function __construct(){

		}
		
	public function executeCarte($params){
		$maCible=$params['cible'];
		$maView = new $maCible();

		$mesFronts= new ControlleurFront();
		$carte=$maView->show(Null);	
		
		$this->appelleTemplate($carte);
		
	}
	public function donneParamGenerauxCartes(){
		$maConfig= new Config();
		$param=[];
			$param['zoom']=$maConfig->getProprieteLeaflet()['zoom'];
			$param['latCentre']=$maConfig->getProprieteLeaflet()['latCentre'];
			$param['lngCentre']=$maConfig->getProprieteLeaflet()['lngCentre'];
			$param['maxZoom']=$maConfig->getProprieteLeaflet()['maxZoom'];
			$param['tileSize']=$maConfig->getProprieteLeaflet()['tileSize']; 
			$param['boxZoom']=$maConfig->getProprieteLeaflet()['boxZoom'];
			$param['attribution']=$maConfig->getProprieteLeaflet()['attribution'];
			$param['layer']=$maConfig->getProprieteLeaflet()['layer'];

		echo json_encode($param);	
		//echo $param;	
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
	
	public function LireToutesCartesSeules(){
		$monCarteManager = new CarteManager();
		$mesCartes=$monCarteManager->getListAll();
		
		
		for($i=0; $i < count($mesCartes);$i++){
			$id=$mesCartes[$i]->getIdFront();
			
			//echo "<br /> id = ".$id;
			
			//$temp[$i]=[];
			$temp[$i]['idcarte']=$mesCartes[$i]->getIdCartes();
			$temp[$i]['zoom']=$mesCartes[$i]->getZoom();
			$temp[$i]['lat']=$mesCartes[$i]->getLat();
			$temp[$i]['lng']=$mesCartes[$i]->getLng();
			$temp[$i]['projection']=$mesCartes[$i]->getProjection();
			$temp[$i]['layeroption']=$mesCartes[$i]->getLayeroption();
			$temp[$i]['nom']=$mesCartes[$i]->getNom();
			$temp[$i]['idfront']=$mesCartes[$i]->getIdFront();

		}
		echo json_encode($temp);	
	}
	
	public function LireToutesCartes(){
		$maCarteManager = new CarteManager();
		$mesCartes=$maCarteManager->getListAll();
		//echo"<br />ControlleurMap carte 4 <pre>";print_r($maCarte);echo"</pre>";
		return $mesCartes; 
	}
}

