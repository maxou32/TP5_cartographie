<?php

class ControlleurParam 	extends Controlleur{

	private $data;
	private $cheminFichier;
	public function __construct(){
		$this->cheminFichier = LIB.'param.yaml';
		require_once LIB.'Spyc.php';
		$this->data = \Spyc::YAMLLoad('lib/param.yaml');
		
	}
 
	public function executeCarte($params){
		//echo "debut controlleur carte-> execute carte<pre>";print_r($params);echo"</pre>";
		$maView = new ParamView();
		
		
		isset($_SESSION['niveau']) ? $this->data['levelUser']=$_SESSION['niveau'] : $this->data['levelUser']=0;
		isset($_SESSION['IdAbonne']) ? $this->data['idAbonne']=$_SESSION['IdAbonne'] : $this->data['idAbonne']=0;
		
		$paramView=$maView->show($this->data);			
		
		$this->appelleTemplate($paramView);
	}
	
	private function miseEnFormeParam(){
		foreach ($datas as $key => $value){
			$result=$result.$key.' : '.value;
		}
		return $result;
	}
	  
    public function validParam($params){	
		echo"<PRE>CONTROLLER : validParam1 ";print_r($params);echo"</PRE>";


		$result='';
		$result.="\r\n"."#**************************************";
		$result.="\r\n"."# ajax  ";
		$result.="\r\n"."#*************************************";		
		$result.="\r\n"."ajax :";
		foreach ($this->data["ajax"] as $key => $value){
			$result.="\r\n ".$key." : ".$value;
		}		
		$result.="\r\n"."#**************************************";
		$result.="\r\n"."# propriété de la carte  ";
		$result.="\r\n"."#*************************************";		
		
		$result.="\r\n"."carte :";
		foreach ($this->data["carte"] as $key => $value){
			$result.="\r\n ".$key." : ".$value;
		}
		
		$result.="\r\n"."#**************************************";
		$result.="\r\n"."# style ";
		$result.="\r\n"."#*************************************";		
		
		$result=$result."\r\n"."style :";
		foreach ($this->data["style"] as $key => $value){
			$result.="\r\n ".$key." : ".$value;
		}
		$result=substr($result, 1); 
		$chemin = $this->cheminFichier;
		$handle = fopen($chemin, "w+");
		$monError=new ControlleurErreur();
		if(fwrite($handle, $result) === FALSE)
		{
			$monError->setError(array("origine"=> "web_max\Gesfront\controlleurParam\valideParam", "raison"=>"Mise à jour des paramètres de présentation", "libelle"=>"Vos modifications n'ont pas pu être prises en compte"));
		}else{
			$monError->setError(array("origine"=> "web_max\Gesfront\controlleurParam\valideParam", "raison"=>"Mise à jour des paramètres de présentation", "libelle"=>"Vos modifications sont prises en compte"));
		}
		fclose($handle);


		header ("Location:?action=montreParam.html");
	}	
}