<?php

class ControlleurPoint  extends Controlleur {

	public function __construct(){

	}
	
	public function addPoint($donnees){
		$monPoint=new PointManager(); 
		$result=$monPoint->add(new Point($donnees));
	}
	
	public function LirePointsUneLigne($idLigne){
		$monPointManager = new PointManager();
		$mesPoints=$monPointManager->getPointsUneLigne($idLigne);
		
		
		//echo"<br />ControlleurMap point  1 = <pre>";print_r($mesPoints);echo"</pre>";
		return $mesPoints; 
	}
	
}