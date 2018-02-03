<?php
//echo "router";
class Router{
	private $request;
	private $myRequest;
	private $myRoad;
	private $myParam;
	
	public function __construct($request){
		$this->request=$request;
	}

	private function getPathName(){
		$pathName='';
		$element='';
		echo "<br />this request  =<pre>";print_r($this->request);echo"</pre>";
		foreach ($this->request as $key => $value){
			if ($key !=="request"){
				$element=explode('/',$value);
				$pathName=$key;
				for ($i=0;$i<count($element)-1;$i++){
					$this->myRequest[$element[$i]]=$element[$i+1];
					$i++;
				}
				echo"<br /><pre>getPathName 1 : ";print_r($this->myRequest);echo"</pre>";
			}
		}
		//$element=explode('/',$this->request[1]);
		echo"<br /><pre>getPathName 2: ";print_r($element);echo"</pre>";

		//return $element[0];
		return $pathName;
	}
	
	public function renderControlleur(){
		echo "<br />get =<pre>";print_r($_GET);echo"</pre>";
		echo "<br />request =<pre>";print_r($_REQUEST);echo"</pre>";
		echo "<br />controller =".CONTROLLEUR;
		$pathName=$this->request['url'];
		
		if(isset($pathName)){		
			$myConfig= new Config(); 
			$this->myRoad=$myConfig->getRoad($pathName);
			//echo"<br />myRoad : <pre>";print_r($this->myRoad);echo"</pre>";
		}
		if(isset($this->myRoad['classe'])){
			$maClasse = new $this->myRoad['classe'];
			$function = $this->myRoad['operation'];
			
			foreach ($this->myRoad["variable"] as $element){
				//echo"<br />element : <pre>";print_r($element);echo"</pre>";
				empty($element) ? null : $param = $element ;
				$this->myParam[$param]=$this->request[$param];
				//echo"<br />element 2: <pre>";print_r($this->myParam);echo"</pre>";
				
	;		}
			$maClasse->$function($this->myParam);
		}
	}
}
