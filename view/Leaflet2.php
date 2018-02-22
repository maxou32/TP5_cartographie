<?php 

class LeafLet2 extends View
{	
	public function __construct(){
		
	}

	
	public function show($datas){
		ob_start(); 
		?>

		<script data-key="hz2zuzccg4dyv6kacncfnbxj" src="public/sdk-ol/GpPluginLeaflet.js"></script>
		<script src="public/js/leaflet-editable-polyline.js"></script>
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
						<button id="addTexte" class=" col s4  blue lighten-5 center-align" style="width: 75px;"><img src="public/sdk-ol/img/LettreVerte.png"></button>
						<button id="removePoint" class=" col s4  blue lighten-5 center-align" style="width: 75px;">supPoint</button>
						<button id="removeFront" class=" col s4  blue lighten-5 center-align" style="width: 75px;">supFront</button>
						<button id="removeFront" class=" col s4  blue lighten-5 center-align" style="width: 75px;">Rien</button>
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
				<input id="idLeaflet" type="hidden"/>
				<input id="idAlt" type="hidden"/>
				<input id="origin" type="hidden"/>
				<button id="btnOui" class="btn center-align col s6 text-green" ><i class="material-icons">check</i>oui</button>
				<button id="btnNon" class="btn center-align col s6 text-red" ><i class="material-icons">cancel</i> non</button>
			</div>
		</div>
		<script type="text/javascript">
			var mymap;
			var addPoint = false;
			var addLigne = false;
			var demandeSuppresionPoint=false;
			var demandeSuppresionFront=false;
			var coordonnees;
			var newdonnees=[];
			var newLigne=[];
			var indexLigne=0;
			var unfront;
			var tempPoint;
			var tempFront;
			var tempLigne;
			var point;
			var TypeLigne=['Ami','Ennemi','Neutre'];
			var CouleurLigne=['blue','red','green'];

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
				
				
			MesPoints={
				init:function(latlng){
				this.latlng=latlng;
				}
			};
			
			MaLigne={
				init:function(id, type,couleur,coordonnées,point, commentaire,dateLigne){
					this.id=id;
					this.type=type;
					this.couleur=couleur;
					this.coordonnees=[];
					this.point=point;
					this.commentaire=commentaire;
					this.dateLigne=dateLigne;
				},
				getId:function(){
					return this.id;
				},
				getCouleur:function(){
					return this.couleur;
				},
				getType:function(){
					return this.type;
				},
				addCoordonnees:function(coordonnees){
					this.coordonnees.push(coordonnees);
				},				
				getNbCoordonnees:function(){
					return this.coordonnees.length;
				},
				getCoordonnees:function(i){
					return this.coordonnees[i] ;
				},
				getToutesCoordonnees:function(){
					return this.coordonnees ;
				},
				getCommentaire:function(){
					return this.commentaire;
				},
				getDateLigne:function(){
					return this.dateLigne;
				}				
			};
			mesFront=[];
			
			
			window.onload = function () {
				
				mymap = L.map("mapid",{
						center : [<?= $datas['latCentre'] ?> ,<?= $datas['lngCentre'] ?>],
						zoom: <?= $datas['zoom'] ?>
						}
					);  //
				var etatMajor =	L.tileLayer('https://wxs.ign.fr/hz2zuzccg4dyv6kacncfnbxj/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer=<?= $datas['layer'] ?>&format=image/jpeg&style=normal',
					{
						minZoom : 0,
						maxZoom : <?= $datas['maxZoom'] ?>,
						tileSize : <?= $datas['tileSize'] ?>,
						boxZoom : <?= $datas['boxZoom'] ?>,
						attribution : '<?= $datas['attribution'] ?>'
					});
				etatMajor.addTo(mymap);
				
				lgMarkers = new L.LayerGroup();
				mymap.addLayer(lgMarkers);
				
				//récupération des coordonnées
				var popup = L.popup();
				
				// Chargement des fronts déjà enregistrés
				var urlJSON = "public/json/fronts.json";
				
				var listeFronts=[];				
				/*
				var Front={
					init:function(nom,valide,dateDebut,dateFin,idAuteur,lacarte,laligne){
						this.nom=nom;
						this.valide=valide;
						this.dateDebut=dateDebut;
						this.dateFin=dateFin;
						this.idAuteur=idAuteur;
						this.carte=lacarte;
						this.ligne=laligne;
					}
				};
				var listeCarte=[];
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
					getNom:function(){
						return this.nom;
					}
				};
				var listeLigne=[];
				var Ligne={
					init:function(points){
						this.points=points;
					}
				}
				var listePoint=[];
				var Point={
					init:function(idpoint,lat,lng,idmarqueur,idlignefront){
						this.idpoint=idpoint;
						this.lat=lat;
						this.lng=lng;
						this.idmarqueur=idmarqueur;
						this.idlignefront=idlignefront;
					}
				};
				*/
				ajaxGet(urlJSON, afficher); 
				
				function afficher(reponse) {
					newdonnees = JSON.parse(reponse);    
					console.log("parcours Json débuté "+newdonnees.length);
					console.debug(newdonnees);
					for (var i=0; i < newdonnees.length; i++) {
						/*
						for (var j;j <newdonnees[i]['ligne']; i++){
							for (var k;k <newdonnees[i]['ligne'][j]; k++){
								var newPoint=Object.create(Point);
								newPoint.init=(
									newdonnees[i]['carte'][j][k]['idpoint'],
									newdonnees[i]['carte'][j][k]['lat'],
									newdonnees[i]['carte'][j][k]['lng'],
									newdonnees[i]['carte'][j][k]['idmarqueur'],
									newdonnees[i]['carte'][j][k]['idlignefront']
								);
								listePoint[k]=newPoint;
							};
							var newLigne=Object.create(Ligne);
							newLigne.init=(
								listePoint
							);
							listeLigne[j]=newLigne;
						};
						var newCarte=Object.create(Carte);
						newCarte.init=(
							newdonnees[i]['carte']['idcarte'],
							newdonnees[i]['carte']['idfront'],
							newdonnees[i]['carte']['lat'],
							newdonnees[i]['carte']['lng'],
							newdonnees[i]['carte']['layeroption'],
							newdonnees[i]['carte']['nom'],
							newdonnees[i]['carte']['projection']
						);
						listeCarte[0]=newCarte;
						console.debug ('carte '+newdonnees[i]['carte']['lat']);
						console.debug ('carte '+newCarte['lat']+listeCarte[0]['lat']);
						
						var newFront=Object.create(Front);						
						newFront.init(
							newdonnees[i]['nom'],
							newdonnees[i]['valide'],
							newdonnees[i]['dateDebut'],
							newdonnees[i]['dateFin'],
							newdonnees[i]['idAuteur'],
							newCarte,
							newLigne
						);
						*/ 
						var unelat=newdonnees[i]['carte']['lat'];
						var unelng=newdonnees[i]['carte']['lng'];
						point = L.marker( [unelat,unelng], 
							{
								draggable: true, 
								icon:  L.icon({
									iconUrl:FormeLigne[4].icone,
									iconSize: [24,24],
									iconAnchor: [12,12],
									popupAnchor:  [0,-24]
									}),
								riseOnHover:true,
								alt: i, // ne pas modifier, sert de référence
								title: "front /"+newdonnees[i]['idfront']
							}).addTo(mymap);
							//
						var tempIdFront= newdonnees[i]['idfront'];
						point.bindPopup("<b>"+newdonnees[i]['nom']+" <i>"+newdonnees[i]['idfront']+"/"+i+"</i></b><br />"+newdonnees[i]['description']+"<br />"+"<button class='point-show-button' title='affiche le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png'></button>"+"<button class='point-update-button' title='modifie le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'></button>"+"<button class='point-delete-button' title='supprime le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> </button>").openPopup();
						point.on("popupopen", onPopupOpen);
						
						console.log('nom '+newdonnees[i]['nom']);
						listeFronts=newdonnees;
						//onclick=montreFront(2)
						//"<br />"+"<input type='button' id='montreFront'+newdonnees[i]['idfront'] value='affiche le front' class='marker-delete-button'/></br>"	
						
						
					}
					console.debug('Front '+newdonnees[1]['carte']['nom']);
					console.debug('Front '+newdonnees[1]['carte']['lat']);
					console.debug('Front '+newdonnees[1]['carte']['lng']);
					console.log("parcours Json terminé");
					
				};
				
				function onMapClick(e) {
					//newFront= Object.create(MonFront);
					//newFront.init('date souhaitée','');
					//console.log('création new front '+newFront.getDateFront());
					if(addPoint){
						point = L.marker(e.latlng, {draggable: true}).addTo(mymap);
						point.bindPopup("<b>Coucou!</b><br>deuxième point avec un popup. <br />"+ e.latlng.toString()+"<input type='button' value='enlever' class='marker-delete-button' /></br>").openPopup();
						
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
						coordonnees=e.latlng;
						newLigne.addCoordonnees(coordonnees);
						console.log("ajout point de ligne "+ newLigne.getNbCoordonnees() +" couleur "+ newLigne.getCouleur());
						//********************************************
						unfront =  L.polyline
						//unfront =  L.polyline.polylineEditor
							(newLigne.getToutesCoordonnees(),			//coordonnees,
								{
								color: newLigne.getCouleur(),
								weight: 5,
								dashArray: '10,7',
								lineJoin:'round'
								}
							).addTo(mymap); 
						var i = newLigne.getNbCoordonnees()-1;
						var texteAlt=newLigne.getType() + " n° "+ newLigne.getNbCoordonnees() +"<br />";
						console.log('texte alt : '+texteAlt);
						/*
						marqueurFront =  L.marker(
							[String(newLigne.getCoordonnees(i).lat),String(newLigne.getCoordonnees(i).lng)], 
							{draggable: true, 
								icon:  L.icon({
									iconUrl:FormeLigne[$('#typeLigne').val()].icone,
									iconSize: [24,24],
									iconAnchor: [12,12],
									popupAnchor:  [0,-24]
								}),						
								alt : texteAlt
							}).bindPopup(texteAlt); //pour ajouter un popup au point : .bindPopup(item[0]);
						mymap.addLayer(marqueurFront);
						*/
						console.log(unfront);
						 
						unfront.on('dblclick', stopLigne);
						function stopLigne(e) {
							addLigne=false;
						};
						//unfront.on('click', onLigneClick);
						marqueurFront.on('click', onMarquerLigneClick);
						/*
						marqueurFront.on('contextmenu', function( e){
							var me_ = this;
							// position pour affichage
							var pos = {
							  x: e.originalEvent.pageX,
							  y: e.originalEvent.pageY
							};
							// affiche le context-menu
							showContextMenu( me_, pos);
						  });   
						*/
						/* *******************************
						       a proposer en option
						// zoom de la carte sur le front
						//mymap.fitBounds(unfront.getBounds());
						******************************* */
						
					}
					if (demandeSuppresionFront){
						alert('suppression on click map ligne : '+ e);
						console.log('suppression ligne e =' + e);
						//mymap.removeLayer(unfront);
					}
				}; 
				
				
				/*
				function onLigneClick(e){
					//if (demandeSuppresionFront){
						tempLigne=e.
						alert('suppression ligne : '+ e);
						console.log('suppression ligne e =' + e);
						//mymap.removeLayer(unfront);
					//}
				}; 
				*/
				
				function onMarquerLigneClick(e){
					//if (demandeSuppresionFront){
						alert('suppression point : '+ e);
						console.log('suppression marqueur e =' + e);
						//mymap.removeLayer(marqueurFront);
					//}	
				};
				function onPopupOpen(){
					tempPoint=this;
									
					$(".point-show-button:visible").click(function () {
						console.debug('temppoint demande = '+tempPoint.options.alt);
						var uneLat=newdonnees[tempPoint.options.alt]['carte']['lat'];
						var uneLng=newdonnees[tempPoint.options.alt]['carte']['lng'];
						var unZoom=newdonnees[tempPoint.options.alt]['carte']['zoom'];
						mymap.setView([uneLat,uneLng],unZoom);
						for(i=0;i<newdonnees[tempPoint.options.alt]['ligne'].length;i++){
							newLigne=Object.create(MaLigne);
							newLigne.init(i,newdonnees[tempPoint.options.alt]['ligne'][i]['type'],newdonnees[tempPoint.options.alt]['ligne'][i]['couleur'],[],[],'','');				
							newLigne[indexLigne]=newLigne;
							for(j=0;j< newdonnees[tempPoint.options.alt]['ligne'][i]['points'].length;j++){
								coordonnees=[String(newdonnees[tempPoint.options.alt]['ligne'][i]['points'][j]['lat']),String(newdonnees[tempPoint.options.alt]['ligne'][i]['points'][j]['lng'])];
								newLigne.addCoordonnees(coordonnees);
								/*						
								marqueurFront =  L.marker(
									[String(newdonnees[tempPoint.options.alt]['ligne'][i]['points'][j]['lat']),String(newdonnees[tempPoint.options.alt]['ligne'][i]['points'][j]['lng'])], 
										{
										draggable: true, 
										icon:  L.icon({
											iconUrl:FormeLigne[newdonnees[tempPoint.options.alt]['ligne'][i]['points'][j]['idmarqueur']].icone,
											//iconUrl:FormeLigne[newdonnees[0]['ligne'][0][j]['idmarqueur']].icone,
											iconSize: [24,24],
											iconAnchor: [12,12],
											popupAnchor:  [0,-24]
										}
									),alt :newdonnees[tempPoint.options.alt]['ligne'][i]['points'][j]['idpoint']
									}).bindPopup('idPoint = '+ newdonnees[tempPoint.options.alt]['ligne'][i]['points'][j]['idpoint']); //pour ajouter un popup au point : .bindPopup(item[0]);
								mymap.addLayer(marqueurFront);
								*/
								//console.log(unfront);
							}							
							unfront =  L.polyline
							(newLigne.getToutesCoordonnees(),			//coordonnees,
								{
								color: newdonnees[tempPoint.options.alt]['ligne'][i]['couleur'],
								weight: 5,
								dashArray: '10,7',
								lineJoin:'round'
								}
							).addTo(mymap);
							var tempIdFront= newdonnees[i]['idfront'];
							//sessionStorage[this._leaflet]['LigneFront_id'] = newdonnees[tempPoint.options.alt]['ligne'][i]['idlignefront'];
							var cleid =unfront._leaflet_id+'/id'
							sessionStorage[cleid] = newdonnees[tempPoint.options.alt]['ligne'][i]['idlignefront'];
							var clei=unfront._leaflet_id+'/i'
							sessionStorage.clear;
							sessionStorage[clei] = i;
							sessionStorage['origin'] = 'ligne';
							//alert('id ligne front'+sessionStorage[cleid]+', i= '+sessionStorage[clei]);
							unfront.bindPopup("<b>"+" <i>"+unfront._leaflet_id+"</i></b><br />"+"<button class='ligne-update-button' title='modifie la lignet'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'></button>"+"<button class='ligne-delete-button' title='supprime la ligne'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> </button>").openPopup();
							
						
						console.log('nom '+newdonnees[i]['nom']);
						unfront.on("popupopen", onPopupFrontOpen);
						//unfront.on("click",onFrontClick);
						}
					});
					
					
					$(".point-delete-button:visible").click(function () {
						tempFront=tempPoint.options.title.split ('/');
						$('#idLeaflet').text(tempFront[tempFront.length-1]);
						$('#idAlt').text(tempPoint.options.alt);						
						$('#origin').text('front');						
						$('#question').html ('Confirmez-vous la suppression définitive du front de '+newdonnees[tempPoint.options.alt]['nom'] +' ? <br /><i> (ref = '+tempFront[tempFront.length-1]+')</i>');
						$('#confirmation').css({display:'inline-block'});
					});
					
					
				};
				/*
				function onFrontClick(e){
					
					//if (demandeSuppresionFront){
						alert('suppression ligne : '+ this._leaflet_id);
						console.log('suppression ligne e =' + e);
						//mymap.removeLayer(unfront);
					
				}
				*/
				function onPopupFrontOpen(e){
					tempFront=this;
					tempLigne=this;
					var cle=this._leaflet_id
					var cleid =cle+'/id'
					sessionStorage['frontActif']=cle;
					//sessionStorage['objetActif']=serialize(this);
					//alert('popup front '+this._leaflet_id+' idligne '+sessionStorage[cleid]);
					$(".ligne-delete-button:visible").click(function () {
						
						console.log('ref leaflet ='+this._leaflet_id);
						//$('#idLeaflet').text(tempFront[tempFront.length-1]);
						console.log('temppoint  supprime = '+ sessionStorage[cleid]);
						//$('#origin').text('ligne');						
						$('#question').html ('Confirmez-vous la suppression définitive de cette ligne de front ? <br /><i> (ref = '+sessionStorage[cleid]+')</i>');
						$('#confirmation').css({display:'inline-block'});
					});
				}
				
				mymap.on('click', onMapClick);
				
				/*
				var searchCtrl = L.geoportalControl.SearchEngine({});
				mymap.addControl(searchCtrl);
				
				var baseMaps = {
					"OSM": etatMajor
				};
				var overlayMaps = {
					'point':point,
					'Front':unfront
				};
				mymap.addControl(new L.Control.Layers(baseMaps, {}));
				*/
				
				// sur le click du marker la popup s'ouvre
				//monMarker = L.marker([e.latlng.lat,e.latlng.lng]).bindPopup("Les coordonnées du points sont :" + e.latlng.lat + "; " + e.latlng.lng + "<br><input type='button' id='erase' value='Delete this marker' class='marker-delete-button'/></br>" );
			};	

			document.getElementById("addFront").addEventListener("click", function(e){
				addPoint = false;
				addLigne = false;
				$('#defFront').css({display:'inline-block'});				
				console.log("Mode ajout "+addFront);
			});
			document.getElementById("addCarte").addEventListener("click", function(e){
				addPoint = false;
				addLigne = false;
				//rendre la carte mobile avec zoom et déplacement
				console.log("Mode ajout "+addCarte);
			});
			document.getElementById("addLigneFront").addEventListener("click", function(e){
				addPoint = false;
				addLigne = false;
				$('#btnControle').css({height:'200px', display:'inline-block'});
				$('#front').css({visibility:'visible'});
				console.log("Mode ajout "+addCarte);
			});				
			document.getElementById("addPoint").addEventListener("click", function(e){
				addPoint = true;
				addLigne = false;
				$('#divEnreg').css({display:'inline-block'});				
				$('#btnControle').css({height:'200px'});
				console.log("Mode ajout "+addPoint);
			});
			document.getElementById("addLigne").addEventListener("click", function(e){
				addLigne = true;
				addPoint = false;
				$('#front').css({visibility:'visible'});
				$('#divEnreg').css({display:'none'});
				$('#typeLigne').css({display:'inline-block'});
				$('#EnregLigne').css({visibility:'visible'});
				$('#enregFront').css({marginTop:'20px'});
				$('#btnControle').css({height:'200px'});
				console.log("Mode Front "+addPoint);
			});
			document.getElementById("btnOui").addEventListener("click", function(e){
				//alert('front supprime = '+$('#idFront').text());
				var cle=sessionStorage['frontActif'];
				var cleid =cle+'/id';
				var clei=cle+'/i';
				if($('#origin').text()==="front"){
					supprimeFront(cleid);
					delete newdonnees[clei];
					mymap.removeLayer(tempPoint);
				}else{
					console.log("supprime ligne en base = "+cleid);
					supprimeLigneFront(cleid);
					delete newdonnees[clei];
	
					mymap.removeLayer(tempLigne);
					
				}
				console.log("Mode suppression  terminé");
				$('#confirmation').css({display:'none'});
				
			});
			function supprimeFront(idFront){
				//console.log('fonction ajax supprime front = '+idFront);
				
				$.post(
					'?action=supprimeFront/', {
						idFront : idFront
					},
					function(data){
						if(data == 'Success'){ 		
							$("#resultat").html("<p>"+data+"</p>");
						}else if(data == 'nothing'){
							$("#resultat").html("<p>Nom inconnu...</p>");
						}else{
							$("#resultat").html("<p>"+data+"</p>");
						};
						$('#cercle').css('display','none');
					},
					'text' // Format du retour 
				 );
			};
			
			function supprimeLigneFront(idLigne){
				console.log('fonction ajax supprime  ligne de front = '+ idLigne);
				
				$.post(
					'?action=supprimeLigneFront/', {
						idLigne : idLigne
					},
					function(data){
						if(data == 'Success'){
							$("#resultat").html("<p>"+data+"</p>");
						}else if(data == 'nothing'){
							$("#resultat").html("<p>Nom inconnu...</p>");
						}else{
							$("#resultat").html("<p>"+data+"</p>");
						};
						$('#cercle').css('display','none');
					},
					'text' // Format du retour 
				 );
			};
				
			document.getElementById("btnNon").addEventListener("click", function(e){
				$('#confirmation').css({display:'none'});
				console.log("Mode suppression annulé");
			});
			document.getElementById("typeLigne").addEventListener("change", function(e){
				addLigne = true;
				
				$('#front').css({visibility:'hidden'});
				$('#divEnreg').css({display:'inline-block'});
				$('#btnControle').css({height:'150px'});					
				$('#mapid').css({cursor: 'url('+ FormeLigne[$('#typeLigne').val()].icone+') 12 12, auto'});

				newLigne=Object.create(MaLigne);
				//newLigne.init(indexLigne,FormeLigne[$('#typeLigne').val()].libelle,FormeLigne[$('#typeLigne').val()].couleur,[],[],$('#commentaire').val(),$('#dateLigne').val());
				newLigne.init(indexLigne,FormeLigne[$('#typeLigne').val()].libelle,FormeLigne[$('#typeLigne').val()].couleur,[],[],'','');				
				newLigne[indexLigne]=newLigne;
				console.log("ajout ligne "+ indexLigne + " de type " +newLigne[indexLigne].getType() +' commentaire = '+newLigne[indexLigne].getCommentaire());
				
				indexLigne++;
			});
			
			document.getElementById("enregLigne").addEventListener("click", function(e){
				$('#btnControle').css({height:'80px'});
				$('#EnregLigne').css({visibility:'hidden'});
				//$('#divEnreg').css({display:'none'}); 
				$('#mapid').css({cursor: 'hand'});
				var coord=[];
				var savLigne=[];
				for(var i=0;i<newLigne.getNbCoordonnees();i++){	
					coord [i]=String(newLigne.getCoordonnees(i));
				};
				savLigne['id']=newLigne.getId();
				savLigne['couleur']=newLigne.getCouleur();
				savLigne['type']=newLigne.getType();
				savLigne['commentaire']=newLigne.getCommentaire();
				savLigne['dateLigne']=newLigne.getDateLigne();
				savLigne['coord']=coord;
				console.log('savlignb front : '+ mesFront.length );
				mesFront[mesFront.length]=savLigne;
				
				console.log('coord: '+savLigne['coord'] );
				console.log('type: '+savLigne['type'] );
				console.log('type Front: '+mesFront[0]['type']);
				//coord='toto';
				
				/*$.post(
					'?action=addFront/', 
					{
						id:newLigne.getId(),
						couleur:newLigne.getCouleur(),
						type:newLigne.getType(),
						commentaire: newLigne.getCommentaire(),
						date:newLigne.getDateLigne(),
						coordonnees:coord,
						lesfront:front
					},

					function(data){
						if(data == 'Success'){ 
							$("#resultat").html("<p></p>");
							
						 }else if(data == 'nothing'){
							 $("#resultat").html("<p>Nom inconnu...</p>");
							 
						}else{
							$("#resultat").html("<p>"+data+"</p>");
						};
						
					},
					'text' // Format du retour 
					
				 );
				 */
			});
			
			function donneFront (){
				var rep='';
				rep = 'zoom>' + mymap.getZoom() + '|';
				rep = rep + 'latlngCarte>'+ String(mymap.getCenter()) +'|';  // 
				//rep = rep + 'lng>'+ String(mymap.getCenter()) +'|';  // 
				rep = rep + 'nom>'+ $('#nom').val() +'|';
				rep = rep + 'description>'+ $('#description').val() +'|';
				rep = rep + 'dateDebut>'+ $('#dateDebutLigne').val() +'|';
				rep = rep + 'dateFin>'+ $('#dateFinLigne').val() +'|';
				rep = rep + 'nbLignesFront>'+ mesFront.length +'|';
				for(var i=0; i < mesFront.length; i++){	
					console.log("preparation front : "+i);
					rep = rep +'ligne'+ [i]+'>'+'id'+'>' + mesFront[i]['id'] +'|' ;
					rep = rep +'ligne'+ [i]+'>'+'type'+'>' + mesFront[i]['type']  +'|';
					rep = rep + 'ligne'+[i]+'>'+'couleur'+'>' +  mesFront[i]['couleur']  +'|' ;
					rep = rep +'ligne'+ [i]+'>'+'idmarqueur'+'>' + mesFront[i]['commentaire']  +'|' ;
					rep = rep +'ligne'+ [i]+'>'+'commentaire'+'>' + mesFront[i]['commentaire']  +'|' ;
					rep = rep +'ligne'+ [i]+'>'+'dateligne'+'>' +  mesFront[i]['dateLigne'] +'|'  ;
					console.log("preparation front lat : "+mesFront[i]['coord']);
					rep = rep +'ligne'+ [i]+'>'+'coord'+'>' + mesFront[i]['coord']+'|'  ;		
				};
				return rep;
			};

			function prepareJSON (){
				var rep=[];
				rep['zoom'] = mymap.getZoom() ;
				rep['lat'] = String(mymap.getCenter());  // 
				rep['lng'] = String(mymap.getCenter()); // 
				rep['nom'] = $('#nom').val();
				rep['description'] = $('#description').val();
				rep['dateDebut'] = $('#dateDebutLigne').val();
				rep['dateFin'] = $('#dateFinLigne').val() ;
				rep['nbFronts'] = mesFront.length;
				for(var i=0; i < mesFront.length; i++){	
					console.log("preparation front : "+i);
					rep['id'] = mesFront[i]['id'];
					rep['type'] = mesFront[i]['type'];
					rep['couleur'] =  mesFront[i]['couleur'] ;
					rep['commentaire'] = mesFront[i]['commentaire'] ;
					rep['dateligne'] =  mesFront[i]['dateLigne'] ;
					console.log("preparation front lat : "+mesFront[i]['coord']);
					rep['coord'] = mesFront[i]['coord'];		
				};
				return rep;			
			};
			
			document.getElementById("enregPage").addEventListener("click", function(e){
				$('#btnControle').css({height:'70px'});
				$('#divEnreg').css({display:'none'});
				$('#mapid').css({cursor: 'hand'});
				
				console.log('nb fronts : '+mesFront.length );
				var textejson = JSON.stringify(prepareJSON());
				console.log('texte Json = '+textejson);
				
							
				$.post(
					'?action=addLigne/', 
					{
						nbFront: mesFront.length,
						mesFronts: donneFront()
					},

					function(data){
						if(data == 'Success'){ 
							$("#resultat").html("<p></p>");
							
						 }else if(data == 'nothing'){
							 $("#resultat").html("<p>Nom inconnu...</p>");
							 
						}else{
							$("#resultat").html("<p>"+data+"</p>");
						};
						
					},
					'text' // Format du retour 
					
				 );
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