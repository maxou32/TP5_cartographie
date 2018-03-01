<?php

class Template extends view{
	private $title;
	
	public function __construct($menu, $footer, $content){
		$this->menuView=$menu;
		$this->footerView=$footer;
		$this->contentView=$content;
		$this->title="";
		
	}
			
	public function show($datas){
		$monConfig= new Config;
		//echo $monConfig->getBackground();
		//$this->imageBackGround=$monConfig->getBackground();
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset= "utf8" />
				<!-- <meta charset="utf8_general_ci" />  -->
				<!-- Ligne à ajouter si on veut un favicon		-->
				<link rel="icon" type="image/jpeg" href="public\media\WM.png">

				<meta name="description" content="Le récit de mes dernières aventures en Alaska !" />	<!-- description pour les moteurs -->
				<meta name="keywords" content="aventure, Alaska" />										<!-- description des mots clefs -->
				<meta name="robots" content="none"> 													<!-- dire au moteur de passer leur chemin -->
				<meta name="content-language" content="french">											<!-- language du site -->
				<meta name="author" content="Toto le héros">											<!-- nom de l'auteur -->
				<meta name="distribution" content="local"> 												<!-- distribtion locale ou générale -->
				<meta name="rating" content="general">													<!-- public visé tous, averti ou restreint -->
				
				<meta name="robots" content="noindex, nofollow">
				
				<!-- facebook		-->
				<meta property="og:title" content="Alaska, mon périple" />
				<meta property="og:url" content="https://web-max.fr/ecrivain/index.php"/>
				<meta property="og:site_name" content="web-max.fr"/>
				<meta property="og:description" content="Mon périple en Alaska au milieu du PHP entouré de MVC menaçants.">
				<meta property="og:image" content="public\media\WMlogo.png">
				<!-- Twitter  		-->
				<meta name="twitter:card" content="Alaska, mon périple">
				<meta name="twitter:site" content="@Web-max">
				<meta name="twitter:title" content="Web-max">
				<meta name="twitter:description" content="Mon périple en Alaska au milieu du PHP entouré de MVC menaçants.">
				<meta name="twitter:creator" content="@moi_meme">
				<!-- Twitter Summary card images must be at least 120x120px -->
				<meta name="twitter:image" content="public\media\icone.png">
				
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<link href="public/css/style.css" rel="stylesheet" /> 
				<!-- SDK Géoportail -->
				<link rel="stylesheet" href="public/sdk-ol/GpOl3.css" />
				<!-- leaflet  -->
				 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
   integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
   crossorigin=""/>
				<link rel="stylesheet" href="public/css/leaflet.css" />
				<link rel="stylesheet" href="public/css/leaflet-contextmenu-min.css" />
				<link rel="stylesheet" href="public/css/GpPluginLeaflet.css" />
				
				<!--Import Google Icon Font-->
				<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
				<!--Import materialize.css-->
				<link type="text/css" rel="stylesheet" href="public/materialize/css/materialize.css" />
								
				<!-- Let browser know website is optimized for mobile -->
				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

				<script src="public/js/tinymce/tinymce.min.js"></script>
				<script>
				tinymce.init({
					selector:'.texteChapitre',
					language:"fr_FR",	
					theme: "modern",
					plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak,searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern imagetools codesample toc noneditable autosave',
					toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					toolbar2: 'print preview media | forecolor backcolor emoticons '
					
					});
				</script>
			</head>
			<body class="grey lighten-2">	 
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<script type="text/javascript"  src="public/js/jquery-3.2.1.min.js"></script>		
				<script type="text/javascript" src="public/js/ajax.js"></script>
				<script type="text/javascript" src="public/materialize/js/materialize.min.js"></script>
				<script src="public/sdk-ol/GpOl3.js"></script>
				<!-- Extension Géoportail pour Leaflet -->
				<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="    crossorigin=""></script>
				
				
				<title>GesFront</title>
				<?= $this->menuView ?>
				<div id="content" >
					<div id="contenuDetail">
						<?= $this->contentView ?>
					</div>
				</div>
				<?= $this->footerView ?>
				<?php
					$monErrorView=new _ErrorView();
					if ($monErrorView->hasError()){
						echo $monErrorView->show();
					}
				?>
			</body>
		</html>
	<?php 
	}
}	
