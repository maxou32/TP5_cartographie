<?php 

class LeafLet extends View
{	
	public function __construct(){
		
	}

	
	public function show($datas){
		ob_start(); 
		?>

		<script data-key="hz2zuzccg4dyv6kacncfnbxj" src="public/sdk-ol/GpPluginLeaflet.js"></script>
		 <script src="view/js/carteLeaflet.js"></script> 
		<!--<script  type="text/javascript">
			var listeLeaflet=[];
			var leaflet={
				init:function(idFront, idCarte){
					this.idFront=idFront;
					this.idCarte=idCarte;
				}
			};
			
			function chargementParamGeneraux (){
				var paramTemp=[];

				return paramTemp;
			}
			
			function chargementCarteLeaflet(ParamGeneraux){
				var mymap = L.map("mapid",{
						center : [ ParamGeneraux['latCentre'],ParamGeneraux['lngCentre'] ],
						zoom: ParamGeneraux['zoom'] 
						}
					);  //
				var etatMajor =	L.tileLayer('https://wxs.ign.fr/hz2zuzccg4dyv6kacncfnbxj/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer='+ParamGeneraux['layer']+'&format=image/jpeg&style=normal',
					{
						minZoom : 0,
						maxZoom : ParamGeneraux['maxZoom'] ,
						tileSize :ParamGeneraux['tileSize'],
						boxZoom : ParamGeneraux['boxZoom'],
						attribution : ParamGeneraux['attribution']
					});
				etatMajor.addTo(mymap);	
				return mymap;
			}
			var listeFronts=[];	
			var Front={
				init:function(nom,valide,dateDebut,dateFin,idAuteur,description){
					this.nom=nom;
					this.valide=valide;
					this.dateDebut=dateDebut;
					this.dateFin=dateFin;
					this.idAuteur=idAuteur;
					this.description=description;
				},
				getNom:function(){
					return this.nom;
				},
				getDescription:function(){
					return this.description;
				}
			};
			function integreFronts(){
				var newFront = JSON.parse(jsonFront)
				for(unFront in = newFront){
					newfront=Object.create(Front);
					newfront.init=(
						unFront['idfront'],
						unFront['nom'],
						unFront['valide'],
						unFront['dateDebut'],
						unFront['dateFin'],
						unFront['idauteur']
					);
					listeFronts[unFront['idfront']]=unFront;
				};
			}
			var listeCartes=[];
			var Carte={
				init:function(idcarte,idfront, lat, lng,layeroption, nom, projection){
					this.idCarte=idcarte;
					this.idFront=idfront;
					this.lat=lat;
					this.lng=lng;
					this.layerOption=layeroption;
					this.nom=nom;
					this.projection=projection;
				},
				getLat:function(){
					return this.lat;
				},
				getLng:function(){
					return this.lng;
				},
				getIdFront:function(){
					return this.idfront
				}
			};

			var FormeLigne={
				1:{
					couleur:'blue',	
					libelle :'Ami',
					icone:'https://web-max.fr/gesFront/public/sdk-ol/img/front-ami.png'				
				},
				2:{
					couleur:'red',
					libelle :'Ennemi',
					icone:'https://web-max.fr/gesFront/public/sdk-ol/img/front-ennemi.png'				
				},
				3:{
					couleur:'green',
					libelle :'Neutre',
					icone:'https://web-max.fr/gesFront/public/sdk-ol/img/front-neutre.png'				
				},
				4:{
					couleur:'gray',
					libelle :'Centre',
					icone: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-canon-24.png'	//icons8-poing-serrÃ©-48.png
				}
			};

			window.onload = function () {
				var ParamGeneraux=chargementParamGeneraux();
				var mymap=chargementCarteLeaflet(ParamGeneraux);				
				alert('fin chgt carte');
				// chargement des fronts
				integreFronts();	
				alert('fin chgt fronts');
				console.debug('fronts '+listeFronts);

				// chargement des cartes
				function integreCartes(jsonCarte){
					var newCarte = JSON.parse(jsonCarte)
					for(uneCarte in newCarte){
						var newfront=Object.create(Front);
						newfront.init=(
							uneCarte['idcarte'],
							uneCarte['idfront'],
							uneCarte['lat'],
							uneCarte['lng'],
							uneCarte['layeroption'],
							uneCarte['nom'],
							uneCarte['projection']
						);
						listeCartes[uneCarte['idfront']]=uneCarte;
					};
				};
				alert('fin chgt carte');

				
				//affichage carte
				for (uneCarte in listeCartes){
					var unelat=uneCarte.getLat();
					var unelng=uneCarte.getLng();
					var monFront=listeFront(uneCarte.getIdFront());
					var centreCarte = L.marker( [unelat,unelng], 
						{
							draggable: true, 
							icon:  L.icon({
								iconUrl:FormeLigne[4].icone,
								iconSize: [24,24],
								iconAnchor: [12,12],
								popupAnchor:  [0,-24]
								}),
							riseOnHover:true,
							alt: 'Point central du front',
							title: 'monFront.getNom()'
						}).addTo(mymap);	
					var newLeaflet= Object.create(Leaflet);
					newLeaflet.init(uneCarte.getIdFront(),neCarte.getIdCarte());
					ListeLeaflet[this._leaflet_id]=newLeaflet;
					
					centreCarte.bindPopup("<b>"+monFront.getNom()+" <i>"+uneCarte.getIdFront()+"</i></b><br />"+monFront.getDescription()+"<br />"+"<button class='point-show-button' title='affiche le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png'></button>"+"<button class='point-update-button' title='modifie le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'></button>"+"<button class='point-delete-button' title='supprime le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> </button>").openPopup();
					centreCarte.on("popupopen", onPopupOpenCentreCarte);
				};
				function onPopupOpenCentreCarte(){
					var tempCentreCarte=this;
					//alert ('id marqueur centreCarte = '+tempCentreCarte._leaflet_id+ 'idfront = '+ListeLeafLet(tempCentreCarte._leaflet_id).['idCarte']);
					alert ('id marqueur centreCarte = ');
					
				}

			}
		</script>
		-->
		<!-- <script src="public/js/leaflet-editable-polyline.js"></script> -->
		<title>Cartographie</title>
		<div class="row">
			
			<div class="col m12 s12">
				<div id="mapid" style="width: 100%; height: 600px;"></div>
			</div>

			<div id="btnCommande" style="position: absolute; top: 100px; left: 0px; z-index: 600; background-color: azure; padding : 10px; margin: 10px; border-radius: 5px; width:270px; ">
				<div class="col s12">
					<div class="row center-align">
						<button id="addFront" class=" col s4 blue lighten-5 center-align" style="width: 75px;">1° étape : définir le front 
							<!-- <img src="public/sdk-ol/img/MarkerVert.png">  -->
						</button>
						<button id="addCarte" class=" col s4  blue lighten-5 center-align" style="width: 75px;">2° étape : centrer la carte
							<!-- <img src="public/sdk-ol/img/MarkerVert.png">  -->
						</button>
						<button id="addLigneFront" class=" col s4  blue lighten-5 center-align" style="width: 75px;">3° étape : Dessiner les lignes 
							<!-- <img src="public/sdk-ol/img/MarkerVert.png">  -->
						</button>
					</div> 
				</div>
						
			
				<div id="defFront" style="display : none;background-color: azure;" class="col s12">
					<div >
						<h2 class="col s12">
						<input id="nom" /></h2>
						<label for="description">description</label>
						<textarea id='description' name='description' rows="10" cols="50" ></textarea> 
						<div class="col s12">
							<div class="col s6">
								<label for="dateDebutLigne">début de période</label>
								<input id="dateDebutLigne" />
							</div>
							<div class="col s6">
								<label for="dateFinLigne">fin de période</label>
								<input id="dateFinLigne" />
							</div>
						</div>
					</div>

				</div>
			</div>
			
			
			
			<div id="btnControle" style="position: absolute; top: 100px; right: 0px; z-index: 600; background-color: azure; padding : 10px; margin: 10px; border-radius: 5px; width:270px; height : 150px; display:none">
				<div class="col s12">
					<div class="row center-align">
						<button id="addPoint" class=" col s4 blue lighten-5 center-align" style="width: 75px;"><img src="public/sdk-ol/img/MarkerVert.png"></button>
						<button id="addLigne" class=" col s4  blue lighten-5 center-align" style="width: 75px;"><img src="public/sdk-ol/img/CircuitVert.png"></button>
					</div> 
				</div>
				<div id="divEnreg" class="col s12 center-align row" style="display:none">
					<button id="enregLigne" class="btn center-align col s6" ><i class="material-icons">save</i> ligne</button>
					<button id="enregPage" class="btn center-align col s6" ><i class="material-icons">save</i> page</button>
				</div>  
				
			
				<div id="front"  class="col s12">
					<div >
						<label for="typeLigne">Type de ligne</label>
						<select id="typeLigne">
							<option value="" disabled selected>Choisissez</option>
							<option value="1">Ami</option>
							<option value="2">Ennemi</option>
							<option value="3">Neutre</option>
						</select>
						
					</div>
				</div>
			</div>
			<p id="resultat"></p>
			<div id="confirmation" class="row" style="position:absolute; top:100px;left:45%; display:none; z-index:700; background-color:white;text-align:center">
				<p id="question"></p>
				<button id="btnOui" class="btn center-align col s6 text-green" ><i class="material-icons">check</i>oui</button>
				<button id="btnNon" class="btn center-align col s6 text-red" ><i class="material-icons">cancel</i> non</button>
			</div>
		</div>
		
			
		<?php
		return ob_get_clean();
	}
}