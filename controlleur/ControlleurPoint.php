<?php

class ControlleurPoint  extends Controlleur {

	public function __construct(){

	}
	
	public function addPoint($paramsBrut){
		echo "<pre>";print_r($paramsBrut);echo"</pre>";
		$params=$this->decoupeParam($paramsBrut['monPoint']); 
		echo "<pre>";print_r($params);echo"</pre>";
		
		$donnees=array('lat' => $params['lat'],'lng' => $params['lng'],  'idmarqueur'=>'', 'idlignefront'=>$params['idlignefront'] );
		$monPoint=new PointManager(); 
		$result=$monPoint->add(new Point($donnees));
	}
	
	public function LirePointsUneLigne($params){
		$monPointManager = new PointManager();
		$mesPoints=$monPointManager->getPointsUneLigne($params['idlignefront']);
		//echo"<pre>";print_r($params);echo"</pre>";
		//echo"<pre>";print_r($mesDatesFronts);echo"</pre>";
		$temp=[];
		for($i=0; $i < count($mesPoints);$i++){
			//$id=$mesDatesFronts[$i]->getIddate();

			$temp[$i]=[];
			$temp[$i]['idpoint']=$mesPoints[$i]->getIdPoint();
			$temp[$i]['lat']=$mesPoints[$i]->getLat();
			$temp[$i]['lng']=$mesPoints[$i]->getLng();
			$temp[$i]['idmarqueur']=$mesPoints[$i]->getIdMarqueur();
			$temp[$i]['idlignefront']=$mesPoints[$i]->getIdLigneFront();
			
		}
		//echo "<br />ControlleurFront 3 : <pre>";print_r($temp);"</pre>";
		
		echo json_encode($temp);	
		
		//return $temp;	
	}
	
}