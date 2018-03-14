<?php

class Controlleur{
	
	public function __construct(){

	}
	
	protected function chargeMenu(){
		//echo"<br />Controlleur Menu : ";
		$monControlleurMenu = new ControlleurMenu();
		return $monControlleurMenu->getMenu();
	}
	
	protected function chargeFooter(){
		$monControle= new ControlleurAccess();
		if(isset($_SESSION['nom'])){
			$monControle->estConnu($_SESSION['nom']) ?$fond="red"  :$fond="blue-grey";	
		}else{
			$fond="blue-grey";
		}
		$monFooterView = new _footerView();
		return $monFooterView->show($fond);
	}
	
	protected function appelleTemplate($contenu){
		$monTemplate= new Template($this->chargeMenu(),$this->chargeFooter(),$contenu);
		$monTemplate->show(NULL,NULL);
		
	}
	
	protected function decoupeParam($params){
		$result=[];
		$result0=[];
		$result1=[];
		
		
		$temp = explode('|',$params);
		//echo "Controlleur decoupeParam 2: <pre>";print_r($temp);"</pre>";
		for ($i=0; $i<count($temp);$i++){
			$elem =explode('>',$temp[$i]);
			//echo "Controlleur decoupeParam 3: <pre>";print_r($elem);"</pre>";
		
			if(count($elem)===2){
				//echo "<br />Controlleur decoupeParam 3.5: <pre>";print_r($elem);echo"</pre>";
				$result[$elem['0']]=$elem['1'] ;
			}elseif(count($elem)===3){
				$result[$temp[$i]]=$temp[$i];

			}else{
				$result[$elem['0']]=Null;
			}
		}
		//echo "Controlleur decoupeParam 7: <pre>";print_r($result);"</pre>";
		return $result;
	}
	
	public function montre($param){
		//echo"<br />Controlleur 1 ";
		//echo"<pre>";print_r($param);echo"</pre>";
		
		
		$maConfig= new Config();
		$data['style']=$maConfig->getCouleur();
		//echo"<br />Controlleur 2 ";
		$maView = new $param['classe']();
		//echo"<br />Controlleur 3 ";
		$fonction=$param['action'];
		$theView=$maView->$fonction($data);	
		//echo"<br />Controlleur 4 ";//echo "<br /> echo de theView <pre>";print_r($theView);echo"</pre>";
		$this->appelleTemplate($theView);
		
	}
}	