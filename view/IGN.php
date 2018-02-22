<?php 

class IGN extends View
{	
	public function __construct(){
		
	}

	
	public function show($datas){
		ob_start(); 
		?>
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
				
					window.onload = function () {
							/*var map = L.map('mapid').setView([48.268698,-4.620391], 13);

							L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
								attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
							}).addTo(map);

							L.marker([51.5, -0.09]).addTo(map)
								.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
								.openPopup();
							*/
							/*
							var map = Gp.Map.load(
								"mapDiv",   // identifiant du conteneur HTML
								// options d'affichage de la carte (Gp.MapOptions)
								{           
									 // clef d'accès à la plateforme
									 apiKey: "hz2zuzccg4dyv6kacncfnbxj",   //"49omnj6r7aljry7wsph1zxlx"
									 // centrage de la carte
									 center : {
										 location : "6, rue sébastien Leclerc, 54000 Nancy"
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
									 // Repères visuels
									 markersOptions : [{
										 content : "<h1>Pôle Géosciences</h1><br/><p>place stanislas, 54000 Nancy</p><br/><p><a href='http://www.pôle-géosciences.fr/index.htm' target='_blank'>Site Web</a></p>"
									 }]
								}    
							)*/
							function go() {
								var osmLyr = new ol.layer.Tile({
										source: new ol.source.OSM()
									});
								var map = new ol.Map({
									target: 'map',
									layers: [
										osmLyr,
										new ol.layer.GeoportalWMTS({
											layer: "GEOGRAPHICALGRIDSYSTEMS.MAPS",
										}),
										new ol.layer.GeoportalWMTS({
											layer: "ORTHOIMAGERY.ORTHOPHOTOS",
											olParams: {
												opacity: 0.7
											}
										})
									],
									view: new ol.View({
										center: [288074.8449901076, 6247982.515792289],
										zoom: 12
									})
								});    
								// gestion des couches
								var lsControl = new ol.control.LayerSwitcher({
									layers : [{
										layer: osmLyr,
										config: {
											title: "OSM",
											description: "Couche OpenStreet Map",
										}
									}], 
									options : {
										collapsed: true
									}
								});
								map.addControl(lsControl);
								
								// Creation du controle caclcu coordonnées
							  var mpControl = new ol.control.GeoportalMousePosition({
									collapsed: false,
									systems : [
										{
											crs : 'EPSG:4559',
											label : "UTM 20 Nord",
											type : "Metric"
										},
										{
											crs : "EPSG:4326",
											label : "Géographiques",
											type : "Geographical"
										}
									],
									units : ["DEC","M"]
								});
								map.addControl(mpControl);

								
								// Creation du controle de recherche
								var searchControl = new ol.control.SearchEngine({
								});

								// Ajout à la carte
								map.addControl(searchControl);								

																
								// Creation du controle de dessin 
								var drawControl = new ol.control.Drawing({
								});
								// Ajout à la carte
								map.addControl(drawControl);
								
								// creéation du controle d'importation
								var lyrImport = new ol.control.LayerImport({
								});       
								map.addControl(lyrImport); 
							}

							Gp.Services.getConfig({
								apiKey: "hz2zuzccg4dyv6kacncfnbxj",
								onSuccess: go
							});

							var infoDiv = document.getElementById("map");
							infoDiv.innerHTML = "<p> Extension OL3 version " + Gp.ol3extVersion + " (" + Gp.ol3extDate + ")</p>";
						
					}    
            
       
				</script>
		<title>Cartographie</title>
		<div id="mapDiv" >
		</div>
		<div id="map"></div>
		<div id="info"></div>		
		<?php
		return ob_get_clean();
	}
}
	
