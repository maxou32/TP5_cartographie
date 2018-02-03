<?php
	session_start();

	include_once('lib/Autoload.php');
	
	Autoload::start();
	
	//$request = $_GET['request'];
	$request = $_GET;
	//echo "request = ".$request."<br />";
		
	$monRouter = new Router($request);
	$monRouter->renderControlleur();
