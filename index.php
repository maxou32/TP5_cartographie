<?php
	session_start();
	
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	

	/*require_once("lib/SplClassLoader.php");		
	$Loader = new \SplClassLoader('web_max\ecrivain\lib', 'lib');
	$Loader->register();
	*/
	
	$monRouter = new Router($_REQUEST);
	$monRouter->Router();