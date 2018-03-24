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
	/********************************************** */
	public function renderControlleur(){
		//echo "<br />get =<pre>";print_r($_GET);echo"</pre>";
		//echo "<br />request =<pre>";print_r($_POST);echo"</pre>";
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
			$this->myParam=$this->myRequest;
			$this->myParam['brut']=$this->request;
			if(isset($this->request['userName'])){
					$this->myParam['userName']=$this->request['userName'];
					$this->myParam['userPwd']=$this->request['userPwd'];
			}
			if(isset($this->myRoad['niveauSecurité'])){
				if(isset($_SESSION['niveau']) ){
					if($this->myRoad['niveauSecurité']>$_SESSION['niveau']){
						$monError=new ControlleurErreur();
						$monError->setError(array("origine"=> "web_max\Gesfront\router\renderControlleur", "raison"=>"Accès avec réservé", "libelle"=>"Vous ne bénéficiez pas des autorisations nécessaires pour poursuivre."));
						//echo "niveau insuffisant";
						header ("Location:?action=accueil.html/classe/AccueilView/action/show");
					}else{
						foreach ($this->myRoad["variable"] as $key => $value){
							//echo"<br />element : <pre>";print_r($key);echo"</pre>";
							empty($key) ? null : $param = $key ;
							$this->myParam[$key]=$value;
							//echo"<br />element 2: <pre>";print_r($this->myParam);echo"</pre>";
							
						}
						$maClasse->$function($this->myParam);
					}
				}else{
					if($this->myRoad['niveauSecurité'] > 0){
						$monError=new ControlleurErreur();
						$monError->setError(array("origine"=> "web_max\Gesfront\router\renderControlleur", "raison"=>"Accès avec réservé (idenfication non réalisée)", "libelle"=>"Vous devez vous identifier pour poursuivre."));			
						//echo "a inscrire ".$this->myRoad['niveauSecurité'];
					
						$this->request['action']="accueil.html/classe/AccueilView/action/show";
						
						$pathName=$this->getPathName();
						$myConfig= new Config(); 
						$this->myRoad=$myConfig->getRoad($pathName);
						//echo"<br />myRoad : <pre>";print_r($this->myRoad);echo"</pre>";
						
							
					
						$maClasse = new $this->myRoad['classe'];
						$function = $this->myRoad['operation'];
						$this->myParam=$this->myRequest;
						$this->myParam['brut']=$this->request;
						
						
						foreach ($this->myRoad["variable"] as $key => $value){
							//echo"<br />element : <pre>";print_r($key);echo"</pre>";
							empty($key) ? null : $param = $key ;
							$this->myParam[$key]=$value;
							//echo"<br />element 2: <pre>";print_r($this->myParam);echo"</pre>";
							
						}
						$maClasse->$function($this->myParam);	
					}else{
						foreach ($this->myRoad["variable"] as $key => $value){
							//echo"<br />element : <pre>";print_r($key);echo"</pre>";
							empty($key) ? null : $param = $key ;
							$this->myParam[$key]=$value;
							//echo"<br />element 2: <pre>";print_r($this->myParam);echo"</pre>";
							
						}
						$maClasse->$function($this->myParam);
					}
				}
			}
			
		}else{
			$monError=new ControlleurErreur();
			$monError->setError(array("origine"=> "web_max\Gesfront\router\renderControlleur", "raison"=>"Route inconnue", "libelle"=>"Cette fonctionnalité n'existe pas"));
			$this->request['action']="accueil.html/classe/AccueilView/action/show";
						
			$pathName=$this->getPathName();
			$myConfig= new Config(); 
			$this->myRoad=$myConfig->getRoad($pathName);
			//echo"<br />myRoad : <pre>";print_r($this->myRoad);echo"</pre>";
			
				
		
			$maClasse = new $this->myRoad['classe'];
			$function = $this->myRoad['operation'];
			$this->myParam=$this->myRequest;
			$this->myParam['brut']=$this->request;
			
			
			foreach ($this->myRoad["variable"] as $key => $value){
				//echo"<br />element : <pre>";print_r($key);echo"</pre>";
				empty($key) ? null : $param = $key ;
				$this->myParam[$key]=$value;
				//echo"<br />element 2: <pre>";print_r($this->myParam);echo"</pre>";
				
			}
			$maClasse->$function($this->myParam);				
		}
	}
}
