<?php
namespace web_max\ecrivain\View;
use web_max\ecrivain\view\View;
use web_max\ecrivain\lib\Config;
use web_max\ecrivain\view\_ErrorView;

class template extends view{
	private $title;
	
	public function __construct($menu, $aside, $footer,$content){
		$this->menuView=$menu;
		$this->asideView=$aside;
		$this->footerView=$footer;
		$this->contentView=$content;
		$this->title="";
		
	}
			
	public function show($params,$datas){
		$monConfig= new Config;
		//echo $monConfig->getBackground();
		$this->imageBackGround=$monConfig->getBackground();
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
				<meta property="og:image" content="D:\perso\maxou\oPENCLASSROOM\04_Php_MySQL\TP_XX\ecrivain\public\media\icone.png">
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
				<!-- Compiled and minified CSS -->
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
				<script  src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css"></script>
				<!--Import Google Icon Font-->
				<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
				<!--Import materialize.css-->
				<link type="text/css" rel="stylesheet" href="public/materialize/css/materialize.css"  media="screen,projection"/>
				
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
			<body style="background-image: url('<?= $this->imageBackGround ?>');">	 
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<script type="text/javascript"  src="public\js\jquery-3.2.1.min.js"></script>		
				<script type="text/javascript" src="public\js\ajax.js"></script>
				<script type="text/javascript" src="public\materialize\js\materialize.min.js"></script>
				<title>Voyage en Alaska</title>
				<?= $this->menuView ?>
				<div id="content" >
					
					<div id="contenuDetail">
						<?= $this->contentView ?>
					</div>
				<?php
				$monErrorView=new _ErrorView();
					if ($monErrorView->hasError()){
						echo $monErrorView->show();
					}
				?>
				</div>
				<?= $this->footerView ?>

			</body>
		</html>
	<?php 
	}
}	