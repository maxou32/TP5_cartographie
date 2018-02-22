<?php 

class LeafLet extends View
{	
	public function __construct(){
		
	}

	
	public function show($datas){
		ob_start(); 
		?>
		
			<!--	center: [288074.8449901076, 6247982.515792289],   -->

		<script data-key="hz2zuzccg4dyv6kacncfnbxj" src="public/sdk-ol/GpPluginLeaflet.js"></script>
		<title>Cartographie</title>
		<div class="row">
			<div class="col m12 s12">
				<div id="mapid" style="width: 100%; height: 600px;"></div>
			</div>
			<p>leaflet 1</p>
			<div id="btnControle"style="position: absolute; top: 100px; right: 0px; z-index: 600; background-color: azure; padding : 10px; margin: 10px; border-radius: 5px; width:270px; height : 70px;">
				<div class="col s12">
					<div class="row center-align">
						<button id="addPoint" class=" col s4 blue lighten-5 center-align" style="width: 75px;"><img src="public/sdk-ol/img/MarkerVert.png"></button>
						<button id="addLigne" class=" col s4  blue lighten-5 center-align" style="width: 75px;"><img src="public/sdk-ol/img/CircuitVert.png"></button>
						<button id="addTexte" class=" col s4  blue lighten-5 center-align" style="width: 75px;"><img src="public/sdk-ol/img/LettreVerte.png"></button>
						<button id="removePoint" class=" col s4  blue lighten-5 center-align" style="width: 75px;">supPoint</button>
						<button id="removeFront" class=" col s4  blue lighten-5 center-align" style="width: 75px;">supFront</button>
					</div> 
				</div>
				<div id="divEnregMaj" class="col s12 center-align" style="display:none">
					<button id="enregMaj" class="btn center-align" ><i class="material-icons">save</i> Enregistrer</button>
				</div>  
				
			
				<div id="front" style="visibility : hidden; ">
					<p><label for="party">nature</label>
					<input id="party">
					<label for="popupContent">Commentaire</label>
					<input id="popupContent"></p>
					<div class="col s12">
						<button id="enregFront" class=" center-align btn center-align"><i class="material-icons">save</i> Enregistrer</button>
					</div>
				</div>
			</div>
			
		</div>
		<script type="text/javascript">
			var mymap='';
			var addPoint = false;
			var addLigne = false;
			var demandeSuppresionPoint=false;
			var demandeSuppresionFront=false;
			var coordinates = [];
				/*
				[49.206807, 3.159565],			
				[48.654661, 3.340927],
				[48.542044, 4.539023],
				[48.705438, 6.380122],
				[49.862751, 3.461843]
				*/
			var unfront='';
			var point='';
			
			L.mPolyline = L.FeatureGroup.extend({
				initialize: function(items, icon, laCouleur) {
					this._layers = {};
					this.addLayer(new L.Polyline(this._pointsArray(items), {
						color: laCouleur,  
						dashArray: '20,15',
						lineJoin: 'round'
						}));
					this.addLayer(this._markersArray(items, icon));

				}, 
				_pointsArray: function(items) {
					var pointsArray = new Array();
					for (var i = 0; i < items.length; i++) {
						console.log(items[i]);
						var item = items[i];
						pointsArray.push(new L.LatLng(item.lat,item.lng));
					}
					return pointsArray;
				},

				_markersArray: function(items, icon) {
					var front = new L.featureGroup();
					var numNewMarker =items.length;
					console.log('nb point du front '+items.length);
					for	 (var i = 0; i < items.length; i++) {
						var item = items[i];
						marqueurFront = new L.marker([item.lat,item.lng], {draggable: true, icon: icon, alt : numNewMarker});  //pour ajouter un popup au point : .bindPopup(item[0]);
						front.addLayer(marqueurFront);
						//alert(' pointeur en cours : '+front.alt);
						marqueurFront.bindPopup("Point du front num : "+marqueurFront.alt+" <br />").openPopup();
					}
					front.on('mouseover', function(e){ e.layer.openPopup(); })
						.on('mouseout', function(e){ e.layer.closePopup(); })
						.on('popupopen', function (e){
							if(demandeSuppresionFront){
								console.log('demande suppression : ');
								e.layer.removeLayer();		//.closestLayerPoint())
								console.log('fin demande suppression');
							}
						});
						//.on('click', function(e){ alert(e.layer.alt); })
					return front;
				}
			});

			MesPoints={
				init:function(latlng){
				this.latlng=latlng;
				}
			};
			Properties={
				init:function(party,popupContent){
					this.party=party;
					this.popupContent=popupContent;
				}
			};
			Geometry={
				init:function(type,coordinates){
					this.type=type;
					this.coordinates=coordinates;
				}
			};
			MesLignes={
				init:function(type,properties,geometry){
				this.type=type;
				this.properties=properties;
				this.geometry=geometry;
				}
			};
			window.onload = function () {		
				mymap = L.map("mapid").setView([48.845,2.424],8) ;  //
				L.tileLayer('https://wxs.ign.fr/hz2zuzccg4dyv6kacncfnbxj/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer=GEOGRAPHICALGRIDSYSTEMS.MAPS&format=image/jpeg&style=normal',
					{
						minZoom : 0,
						maxZoom : 18,
						tileSize : 256,
						attribution : 'Web-Max &copy; ' + 'https://web-max.fr'
					}).addTo(mymap);
												 
				// ajout d'un popup isolé avec markeur spécial
				var markerRoute = L.icon({
					iconUrl: 'https://web-max.fr/gesFront/public/sdk-ol/img/marker-route.png',
					iconSize:     [95, 65], // size of the icon
					iconAnchor:   [42, 95], // point of the icon which will correspond to marker's location
					popupAnchor:  [0, -100] // point from which the popup should open relative to the iconAnchor
				});
				
				var frontNeutre = L.icon({
					iconUrl: 'https://web-max.fr/gesFront/public/sdk-ol/img/front-neutre.png',
					iconSize: [24,24],
					iconAnchor: [12,12],
					popupAnchor:  [0,-24]
				});
								
				//récupération des coordonnées
				var popup = L.popup();
				
				
				function onMapClick(e) {
					newLigne='';
					indexLigne=0;
					if(addPoint){
						var point = L.marker(e.latlng, {draggable: true}).addTo(mymap);
						point.bindPopup("<b>Coucou!</b><br>deuxième point avec un popup. <br />"+ e.latlng.toString()+"<input type='button' id='erase' value='enlever' class='marker-delete-button'/></br>").openPopup();
						
						point.on('popupopen', function () {
							if(demandeSuppresionPoint){
								mymap.removeLayer(this);
							}
						});
						
						point.on('dragend', relachement);
						function relachement(e) {
							point.getPopup().setContent(''+point.getLatLng());
							point.openPopup();
						}
						
						var indexPoint= String(MesPoints);
						var newPoint=Object.create(MesPoints);
						newPoint.init(e.latlng);						
						MesPoints[indexPoint]=newPoint;
						console.log("ajout point "+ indexPoint + " = " + MesPoints[indexPoint].latlng);
					}
					if(addLigne){
						i = (coordinates).length;
						console.log("nb coordonnées : "+ i);
						coordinates[i]=e.latlng;
						console.log("ajout point de ligne"+ i + " = " + coordinates[i]);
						unfront = new L.mPolyline(coordinates, frontNeutre, 'green');  //#E3F2FD => couleur verte
						console.log(unfront);
						mymap.addLayer(unfront);
						/* *******************************
						       a proposer en option
						// zoom de la carte sur le front
						//mymap.fitBounds(unfront.getBounds());
						******************************* */
						
					}
				};  
				var searchCtrl = L.geoportalControl.SearchEngine({});
				mymap.addControl(searchCtrl);
				mymap.on('click', onMapClick);
				
				var overlayMaps = {
					'point':point,
					'Front':unfront
				};

				map.addControl(new L.Control.Layers(baseMaps, overlayMaps));
				
				// sur le click du marker la popup s'ouvre
				//monMarker = L.marker([e.latlng.lat,e.latlng.lng]).bindPopup("Les coordonnées du points sont :" + e.latlng.lat + "; " + e.latlng.lng + "<br><input type='button' id='erase' value='Delete this marker' class='marker-delete-button'/></br>" );
				

				
				
			};		
			document.getElementById("addPoint").addEventListener("click", function(e){
				addPoint = true;
				addLigne = false;
				$('#divEnregMaj').css({display:'inline-block'});				
				$('#btnControle').css({height:'150px'});
				console.log("Mode ajout "+addPoint);
			});
			
			document.getElementById("addPoint").addEventListener("click", function(e){
				addPoint = true;
				addLigne = false;
				$('#divEnregMaj').css({display:'inline-block'});				
				$('#btnControle').css({height:'150px'});
				console.log("Mode ajout "+addPoint);
			});
			document.getElementById("addLigne").addEventListener("click", function(e){
				addLigne = true;
				addPoint = false;
				$('#front').css({visibility:'visible'});
				$('#divEnregMaj').css({display:'none'});
				$('#btnControle').css({height:'400px'});
				console.log("Mode Front "+addPoint);
			});
			document.getElementById("enregFront").addEventListener("click", function(e){
				addLigne = true;
				$('#front').css({visibility:'hidden'});
				$('#divEnregMaj').css({display:'inline-block'});
				$('#btnControle').css({height:'150px'});
				$('#mapid').css({cursor: 'url(https://web-max.fr/gesFront/public/sdk-ol/img/front-neutre.png) 12 12, auto'});
				console.log("Mode Front "+addLigne);
				var newProperties=Object.create(Properties);
				newProperties.init($('#party').val,$('#popupContent').val);
				var newGeometry=Object.create(Geometry);
				newGeometry.init('newGeometry',[]);
				indexLigne= String(MesLignes);
				newLigne=Object.create(MesLignes);
				newLigne.init('Feature',newProperties,newGeometry);
				
				newLigne[indexLigne]=newLigne;
				console.log("ajout ligne "+ newLigne[indexLigne]["geometry"].type);
			});
			document.getElementById("enregMaj").addEventListener("click", function(e){
				$('#btnControle').css({height:'70px'});
				$('#divEnregMaj').css({display:'none'});
				$('#mapid').css({cursor: 'hand'});
			});
			document.getElementById("removePoint").addEventListener("click", function(e){
				demandeSuppresionPoint=!demandeSuppresionPoint;
				if (demandeSuppresionPoint){
					$('#removePoint').removeClass("blue lighten-5").addClass("red");
				}else{
					$('#removePoint').removeClass("red").addClass("blue lighten-5");
				};
				console.log("Suppression point = "+demandeSuppresionPoint);
			});
			document.getElementById("removeFront").addEventListener("click", function(e){
				
				demandeSuppresionFront=!demandeSuppresionFront;
				if (demandeSuppresionFront){
					$('#removeFront').removeClass("blue lighten-5").addClass("red");
				}else{ 
					$('#removeFront').removeClass("red").addClass("blue lighten-5");
				};
				console.log("Suppression front = "+demandeSuppresionFront);
			});
			
		</script>
		
			
		<?php
		return ob_get_clean();
	}
}