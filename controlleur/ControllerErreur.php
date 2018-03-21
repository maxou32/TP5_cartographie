<?php
namespace web_max\ecrivain\controler;

class ErrorController extends MainController	{

	
public function __construct(){
		
	}
 
	
	/**
     * Enregistrement de l'erreur dans les variables de SESSION
     * @params  array $erreur contient l'erreur à traiter, son origine et ses paramêtres
     *      
     */
    
    public	function setError($error) {  
		//echo "ERROR CONTROLLER : set error";
		$_SESSION['error']=$error;
	}
	
	
	public	function getOrigineError() {   
		if(isset($_SESSION['error']["origine"])){
			return $_SESSION['error']["origine"];
		}else{
			return Null;
		}
	}
	
		public	function getRaisonError() {   
		if(isset($_SESSION['error']["raison"])){
			return $_SESSION['error']["raison"];
		}else{
			return Null;
		}
	}
	public	function getNumberError() {   
		//echo"<PRE> ERROR COntroller : ";print_r($_SESSION['error']);echo"</PRE>";
		if(isset($_SESSION['error']['numberMessage'])){
			//echo "<br />yes";
			return $_SESSION['error']['numberMessage'];
		}else{
			//echo "<br />oh no";
			return Null;
		}
	}
	
	public	function getExisteError() {   
		//echo"<PRE> ERROR COntroller : ";print_r($_SESSION);echo"</PRE>";
		if (isset($_SESSION['error'])){
			return true;
		}else{
			return false;
		}
	}
	
	public	function deleteError() {   
		//echo"<PRE> ERROR COntroller DELETE : ";print_r($_SESSION);echo"</PRE>";
		if(isset($_SESSION['error'])){
			unset ($_SESSION['error']);
		}
		//echo"<PRE> ERROR COntroller DELETE : ";print_r($_SESSION);echo"</PRE>";
		
	}
}