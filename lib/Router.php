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

	/***********************************************
	//
	// la fonction getPathName extrait l'action à réalier et ses parametres
	// grace au contenu de l'url
	// 1 - découpage des parametres
	// 2 - le premier correspond obligatoirement au pathname
	// 3 - les autres aux parametres de la route
	// elle retourne le pathName et stocke els parametres
	/********************************************** */
	private function getPathName(){
		$pathName='';
		$element='';
		//echo "<br />this request  =<pre>";print_r($this->request);echo"</pre>";
		if(isset($this->request['action'])){
			$element=explode('/',$this->request['action']);
			$pathName=$element[0];
			for ($i=1; $i<count($element);$i++){
				if(isset($element[$i+1])){
					$this->myRequest[$element[$i]]=$element[$i+1];
				}				
				$i++;
			}
			//echo"<br /><pre>getPathName 1 : ";print_r($this->myRequest);echo"</pre>";
			//echo"<br /><pre>getPathName 2: ";print_r($pathName);echo"</pre>";
	
			return $pathName;
		}else{
			return "";
		}
	}

	/***********************************************
	//
	// la fonction renderControlleur va chercher la route à suivre
	// grace à la classe config et aux parametrtes passés dasn l'url
	//		si la route existe, il en déduit le controller à appeler
	//      sinon erreur 44
	/********************************************** */
	public function renderControlleur(){
		//echo "<br />get =<pre>";print_r($_GET);echo"</pre>";
		//echo "<br />request =<pre>";print_r($_REQUEST);echo"</pre>";
		//echo "<br />controller =".CONTROLLEUR;
		
		!isset($this->request['action']) ? $this->request['action']="accueil.html/classe/AccueilView/action/show" : true;

		$pathName=$this->getPathName();
		

		if(isset($pathName)){		
			$myConfig= new Config(); 
			$this->myRoad=$myConfig->getRoad($pathName);
			//echo"<br />myRoad : <pre>";print_r($this->myRoad);echo"</pre>";
		}
			
		if(isset($this->myRoad['classe'])){
			$maClasse = new $this->myRoad['classe'];
			$function = $this->myRoad['operation'];
			//echo"<br />appel 1 : ".$this->myRoad['classe']." fonction : ".$this->myRoad['operation'];
			//echo"<br />myRoad : <pre>";print_r($this->myRoad);echo"</pre>";
			$this->myParam=$this->request;
			foreach ($this->myRoad["variable"] as $key => $value){
				//echo"<br />element : <pre>";print_r($key);echo"</pre>";
				empty($key) ? null : $param = $key ;
				$this->myParam[$key]=$value;
				//echo"<br />element 2: <pre>";print_r($this->myParam);echo"</pre>";
				
	;		}
			$maClasse->$function($this->myParam);
		}
	}
}
