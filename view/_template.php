<?php

?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset= "utf8" />
				<!-- <meta charset="utf8_general_ci" />  -->
				<!-- Ligne à ajouter si on veut un favicon		-->
				
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
				<meta property="og:image" content="">
				<!-- Twitter  		-->
				<meta name="twitter:card" content="Alaska, mon périple">
				<meta name="twitter:site" content="@Web-max">
				<meta name="twitter:title" content="Web-max">
				<meta name="twitter:description" content="Mon périple en Alaska au milieu du PHP entouré de MVC menaçants.">
				<meta name="twitter:creator" content="@moi_meme">
				<!-- Twitter Summary card images must be at least 120x120px -->
				<meta name="twitter:image" content="">
				
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<link href="public/css/style.css" rel="stylesheet" /> 
				
				<!-- SDK Géoportail -->
				<link rel="stylesheet" href="public/sdk-ol/GpOl3.css" />
				
				
				<!--Import Google Icon Font-->
				<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
				<!--Import materialize.css-->
				<link rel="stylesheet" href="public/materialize/css/materialize.min.css">
				
				
				
				<!-- Let browser know website is optimized for mobile -->
				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

				<script src="public\js\tinymce\tinymce.min.js"></script>
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
			<body >	 
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<script type="text/javascript"  src="public/js/jquery-3.2.1.min.js"></script>		
				<script type="text/javascript" src="public/js/ajax.js"></script>
				<script type="text/javascript" src="public/materialize/js/materialize.min.js"></script>
				<script src="public/sdk-ol/GpOl3.js"></script>
		
		<title>Cartographie</title>
		
		<div id="content" >
			
			<div id="contenuDetail">
				<?php echo $content; ?>
			</div>
		
		</div>

	</body>
</html>
