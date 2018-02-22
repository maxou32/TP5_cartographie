<?php

class Autoload{
	public static function start (){
		spl_autoload_register(array(__CLASS__, 'myAutoload'));
				
		ini_set('display_errors',1);
		ini_set('display_startup_errors',1);
		error_reporting(E_ALL);			
		
		//echo"<pre>autoLoad";print_r($_SERVER);//echo"</pre>";

		$host='http://'.$_SERVER['HTTP_HOST'].'/';
		$root=$_SERVER['DOCUMENT_ROOT'].'/';

		define ("HOST",$host.'gesFront/');
		define ("ROOT",$root.'gesFront/');

		
		define ("CONTROLLEUR", ROOT."controlleur/"); 
		define ("LIB", ROOT."lib/");
		define ("MODEL", ROOT."model/");
		define ("VIEW", ROOT."view/");
		define ("REPPUBLIC", ROOT."public/");
		define ("REPAJAX", ROOT."ajax/");
	}

	private static function myAutoload($class){

		if(file_exists(MODEL.$class.".php")){
			//echo "model ".$class."<br />";
			include_once(MODEL.$class.".php");
		}elseif(file_exists(CONTROLLEUR.$class.".php")){
			//echo "controlleur <br />".CONTROLLEUR.$class."<br />";
			include_once(CONTROLLEUR.$class.".php");
		}elseif(file_exists(LIB.$class.".php")){
			//echo "lib ".$class."<br />";
			include_once(LIB.$class.".php");
		}elseif(file_exists(VIEW.$class.".php")){
			//echo "view ".$class."<br />";
			include_once(VIEW.$class.".php");
		}elseif(file_exists(REPAJAX.$class.".php")){
			//echo "view ".$class."<br />";
			include_once(REPAJAX.$class.".php");
		}
		//echo "fin autoLoad ".$class.".php";
	}
	
}
