<?php

class ControlleurMenu{
	
	public function __construct()   {
		 } 
	
	public function getMenu(){
		//echo"<PRE> COntroller : fin upDateSession";print_r($_SESSION);echo"</PRE>";
		$maConfig= new Config();
		$data['style']=$maConfig->getCouleur();
		
		$monControle= new ControlleurAccess();
		if(isset($_SESSION['nom'])){
			if($monControle->estConnu($_SESSION['nom'])){
				//echo"<PRE> COntroller : réservé ";print_r($data);echo"</PRE>";
				$data['nom']=$_SESSION['nom'];
				$menuPrivate= new _MenuPrivateView();
				return $menuPrivate->show($data);
			}else{
				//echo"<PRE> COntroller : libre ";print_r($data);echo"</PRE>";
				$menuFree= new	_MenuFreeView();
				return $menuFree->show($data);
			}
		}else{
			//echo"<PRE> COntroller : libre ";print_r($data);echo"</PRE>";
			$menuFree= new	_MenuFreeView();
			return $menuFree->show($data);
		}
	}
}