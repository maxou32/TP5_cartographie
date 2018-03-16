	<?php

class ControlleurCarte extends Controlleur{

	public function __construct(){

		}
		
	public function executeCarte($params){
		//echo "debut controlleur carte-> execute carte<pre>";print_r($params);echo"</pre>";
		$maCible=$params['cible'];
		$maView = new $maCible();

		$mesFronts= new ControlleurFront();
		$temp['front']=$mesFronts->lireTousFronts();
		
		$temp['paramGeneraux']=$this->LireParamGeneraux();
		isset($_SESSION['niveau']) ? $temp['levelUser']=$_SESSION['niveau'] : $temp['levelUser']=0;
		
		if($params['ChargementCarte']){
			$carte=$maView->show($temp);			
			$this->appelleTemplate($carte);
		}
		return $temp;
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
			$param['synchrone']=$maConfig->getProprieteLeaflet()['synchrone'];
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
	
	public function LireParamGeneraux(){
		//echo "LireParamGeneraux";
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
			$param['synchrone']=$maConfig->getProprieteLeaflet()['synchrone'];
			
		return $param;		
	}
	
	public function LireToutesCartes(){
		$maCarteManager = new CarteManager();
		$mesCartes=$maCarteManager->getListAll();
		//echo"<br />ControlleurMap carte 4 <pre>";print_r($maCarte);echo"</pre>";
		return $mesCartes; 
	}
}

