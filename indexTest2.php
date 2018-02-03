
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
				
				
				
				<!--Import Google Icon Font-->
				
				<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
				<!--Import materialize.css-->
				<link rel="stylesheet" href="public/materialize/css/materialize.min.css">
				
				<!-- SDK Géoportail -->
				<link rel="stylesheet" href="public/sdk-ol/GpOl3.css" />
				<!-- 
				<link rel="stylesheet" href="public/sdk-ol/ol3/ol.css" />
				<link rel="stylesheet" href="public/sdk-ol/GpPluginOl3.css" />
				-->
				 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
				   integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
				   crossorigin=""/>
				
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
				<!-- Extension Géoportail pour OpenLayers -->
				<script src="public/sdk-ol/GpOl3.js"></script>
				
				<script src="public/sdk-ol/GpPluginOl3.js"></script>
				<script src="public/sdk-ol/ol3/ol.js"></script>
				<script data-key="49omnj6r7aljry7wsph1zxlx" src="public/sdk-ol/GpPluginOl3.js"></script>
				<!---->
				<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
					integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
					crossorigin=""></script>
								
				
				
				<!-- Library OpenLayers -->

				<script language="javascript" type="text/javascript">
				/*	var projection = ol.proj.get('EPSG:3857');
					var resolutions = [
						156543.03392804103,
						78271.5169640205,
						39135.75848201024,
						19567.879241005125,
						9783.939620502562,
						4891.969810251281,
						2445.9849051256406,
						1222.9924525628203,
						611.4962262814101,
						305.74811314070485,
						152.87405657035254,
						76.43702828517625,
						38.218514142588134,
						19.109257071294063,
						9.554628535647034,
						4.777314267823517,
						2.3886571339117584,
						1.1943285669558792,
						0.5971642834779396,
						0.29858214173896974,
						0.14929107086948493,
						0.07464553543474241
					] ;
					function chargeCarte() {
					
					var map = new ol.Map({
						view: new ol.View({
							center: [0, 0],
							zoom: 1
						}),
						layers: [
							// ici on rajoute des couches, instances de ol.layer
								 new ol.layer.Tile({
								source : new ol.source.WMTS({
									attributions: ["IGN-F/Géoportail"],
									url: "https://wxs.ign.fr/49omnj6r7aljry7wsph1zxlx/geoportal/wmts",
									layer: "ORTHOIMAGERY.ORTHOPHOTOS",
									matrixSet: "PM",
									format: "image/jpeg",
									style: "normal",
									tileGrid : new ol.tilegrid.WMTS({
										origin: [-20037508,20037508],// topLeftCorner
										resolutions: resolutions, // résolutions
										matrixIds: ["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19"]
										// ids des TileMatrix
									})
								})
							})
						],
						target: "mapDiv", // id de l"élément HTML
						view: new ol.View({
							center: [260516,6246918],
							zoom: 10
						})
					});
				};*/
				/*	function chargeCarte() {
						var map = Gp.Map.load(
							"mapDiv",   // identifiant du conteneur HTML
							// options d'affichage de la carte (Gp.MapOptions)
							{           
								 // clef d'accès à la plateforme
								 apiKey: "49omnj6r7aljry7wsph1zxlx",
								 // centrage de la carte
								 center : {
									 //location : "6 rue sébastien leclerc, Nancy"
									 
									 x : -4.620391,
									 y : 48.268698,
									 projection : "CRS:84"
								 },
								 // niveau de zoom de la carte (de 1 à 21)
								 zoom : 17,
								 // Couches à afficher
								 layersOptions : {
									 "GEOGRAPHICALGRIDSYSTEMS.MAPS.SCAN-EXPRESS.STANDARD" : {
									 }
								 },
								 // Outils additionnels à proposer sur la carte
								 controlsOptions : {
									 // ajout d'une barre de recherche
									 "search" : {
										 maximised : true
									 }
								 },
								  Repères visuels
								 markersOptions : [{
									 content : "<h1>Caserne Thiry</h1><br/><p>24 rue sainte catherine, Nancy</p><br/><p><a href='http://web-max.fr/index.htm' target='_blank'>Site Web</a></p>"
								 }]
							}
						)
					};	*/
					window.onload = function () {
							var map = L.map('mapid').setView([48.268698,-4.620391], 13);

							L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
								attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
							}).addTo(map);

							L.marker([51.5, -0.09]).addTo(map)
								.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
								.openPopup();
							
							var map = Gp.Map.load(
							"mapDiv",   // identifiant du conteneur HTML
							// options d'affichage de la carte (Gp.MapOptions)
							{           
								 // clef d'accès à la plateforme
								 apiKey: "49omnj6r7aljry7wsph1zxlx",
								 // centrage de la carte
								 center : {
									 //location : "6 rue sébastien leclerc, Nancy"
									 
									 x : -4.620391,
									 y : 48.268698,
									 projection : "CRS:84"
								 },
								 // niveau de zoom de la carte (de 1 à 21)
								 zoom : 17,
								 // Couches à afficher
								 layersOptions : {
									 "GEOGRAPHICALGRIDSYSTEMS.MAPS" : {	//.SCAN-EXPRESS.STANDARD
									 }
								 },
								 // Outils additionnels à proposer sur la carte
								 controlsOptions : {
									 // ajout d'une barre de recherche
									 "search" : {
										 maximised : true
									 }
								 },
								 // Repères visuels
								 markersOptions : [{
									 content : "<h1>Caserne Thiry</h1><br/><p>24 rue sainte catherine, Nancy</p><br/><p><a href='http://web-max.fr/index.htm' target='_blank'>Site Web</a></p>"
								 }]
							}
						)
					}    
            
       
				</script>
		<title>Cartographie</title>
		<div id="mapid" style="height:600px"></div>
		<p> AVANT MA CARTE IGN </p>
		<div id="mapDiv" >
			<a href='#!' onClick='javascript:chargeCarte()'> PENDANT MA CARTE IGN </a>
		</div>
		<p> APRES MA CARTE IGN </p>
		
	</body>
</html>
