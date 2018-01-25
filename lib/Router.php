<?php
echo "router";
class Router{
	private $request;
	
	public function __construct($request){
		$this->request=$request;
	}

	private function getPathName(){
		$element=explode('/',$this->request);
		echo"<pre>";print_r($element);echo"</pre>";
		return $pathName;
	}
	
	public function renderControlleur(){
		echo $this->request;
		echo CONTROLLEUR;
		$pathName=$this->getPathName($request);
		
		$monFront= new Front;
		$monFront->executeCarte();
	}
}
