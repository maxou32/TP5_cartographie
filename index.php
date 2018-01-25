<?php
	session_start();

	include_once('lib/Config.php');
	
	MyAutoload::start();
	
	$request = $_GET['request'];
	echo "request = ".$request."<br />";
		
	$monRouter = new Router($request);
	$monRouter->renderControlleur();
