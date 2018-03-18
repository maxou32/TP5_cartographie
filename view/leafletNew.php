		<script src="public/leaflet/leaflet.js"></script>
		<script src="public/js/leaflet-editable-polyline.js"></script> 
		<script src="public/js/leaflet-contextmenu-min.js"></script> 
		<script data-key="hz2zuzccg4dyv6kacncfnbxj" src="public/sdk-ol/GpPluginLeaflet.js"></script>
		<script src="view/js/carteLeaflet.js"></script> 
		<script>
			// a mettre en bas si possible 
			var monUser=Object.create(User);
			monUser.init(<?= $datas['idAbonne'] ?>,<?= $datas['levelUser'] ?>);
			listeUser.push(monUser);
			console.log('user level from view :'+listeUser[0].userLevel);
			
			var mesParamGeneraux=Object.create(paramGeneraux);
			var zoom=<?= $datas['paramGeneraux']['zoom'] ?>;
			var latCentre=<?= $datas['paramGeneraux']['latCentre'] ?>;
			var lngCentre=<?= $datas['paramGeneraux']['lngCentre'] ?>;
			var maxZoom=<?= $datas['paramGeneraux']['maxZoom'] ?>;
			var tileSize=<?= $datas['paramGeneraux']['tileSize'] ?>;
			var boxZoom=<?= $datas['paramGeneraux']['boxZoom'] ?>;
			var attribution="<?= $datas['paramGeneraux']['attribution'] ?>";
			var layer="<?= $datas['paramGeneraux']['layer'] ?>";
			var synchrone=<?= $datas['paramGeneraux']['synchrone'] ?>;
			mesParamGeneraux.init(
				zoom,latCentre,lngCentre,maxZoom,tileSize,boxZoom,attribution,layer,synchrone);
			ParamGeneraux.push(mesParamGeneraux);
			
			
			<?php
				for($f=0;$f < count($datas['front']); $f++){
					$temp['idfront']=$datas['front'][$f]['idfront'];
					$temp['nom']= $datas['front'][$f]['nom'];
					$temp['zoom']= $datas['front'][$f]['zoom'];
					$temp['lat']= $datas['front'][$f]['lat'];
					$temp['lng']= $datas['front'][$f]['lng'];
					$temp['valide']= $datas['front'][$f]['valide'];
					$temp['idauteur']= $datas['front'][$f]['idauteur'];
					$temp['description']= $datas['front'][$f]['description'];
					?>
					var mesFronts=Object.create(Front);
					mesFronts.init( 
						<?= $temp['idfront'] ?>,"<?= $temp['nom'] ?>",<?= $temp['zoom'] ?>,"<?= $temp['lat'] ?>","<?= $temp['lng'] ?>",<?= $temp['valide'] ?>,<?= $temp['idauteur'] ?>,"<?= $temp['description'] ?>");
					listeFronts[<?= $temp['idfront'] ?>]=mesFronts;
					console.log('id front =' + mesFronts['idfront']);
					<?php
				}
			?>

			
		</script>
		<title>Cartographie</title>
		<div class="row">
			
			<div class="col m12 s12">
				<div id="mapid" style="width: 100%; height: 600px;"></div>
			</div>
			<input id="levelUser" type="hidden" value="<?= $datas['levelUser'] ?>" >
			
			<div id="btnCommande" style="position: absolute; top: 150px; left: 0px; z-index: 600; background-color: azure; padding : 10px; margin: 10px; border-radius: 5px; width:270px; display:none">
				<div class="detailFront col s12" style="display:none" >		
					<label class="detailFront" for="nomDetailFront">Nom</label>
					<input class="detailFront" type="text" id="nomDetailFront"/>
					<label class="detailFront" for="descriptionDetailFront">Description</label>
					<input class="detailFront" id="descriptionDetailFront" />
					<button id='detailFront-save-button' class="col s3 detailFront" title='enregistre modification conflit'> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-sauvegarder-32.png' > 
					</button>
				</div>
				<div id="btnNavDate" col s12">
					<p>Faites défiler la frise du temps</p>
					<a id="btnNavDatePrev"><img src="https://web-max.fr/gesFront/public/sdk-ol/img/icons8-inferieur-32.png" alt="Précédent"></a>
					<a id="btnNavDateNext"><img src="https://web-max.fr/gesFront/public/sdk-ol/img/icons8-superieur-32.png" alt="Suivant"></a>
				</div>
				<div id="infoDateLigne col s12" >
					<label class="dateLigne" for="dateLigne">Date des lignes</label>
					<select class="dateLigne" id="dateLigne" style="display:inline-block">
						<option value="" >Choisissez une date</option> 	<!-- disabled selected  -->
					</select>
					<label class="addDateLigne" for="addDateLigne">Date</label>
					<input class="addDateLigne" type="date" id="addDateLigne"/>
					<label class="addDateLigne" for="addDescriptionLigne">Description</label>
					<input class="addDateLigne" id="addDescriptionLigne" /> 
										
				</div>					
				<div id="dateFront-show" class="col s12" style="display:inline-block" >					
					
					<button id='dateFront-show-button' class="col s3" title='affiche le détail de la journée'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png'>
					</button>
					<div class="admin">
						<button id='dateFront-add-button' class="col s3" title='ajoute une nouvelle date'/> 
							<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png'>
						</button>
						<button id='dateFront-dupplicate-button' class="col s3" title='dupplique une  date'/> 
							<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-copie-32.png'>
						</button>
						<button id='dateFront-update-button' class="col s3" title='modifie les caractéristiques de la date'/> 
							<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'>
						</button>					
						<button id='dateFront-delete-button' class="col s3" title='supprime une date'/> 
							<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> 
						</button>
						<button id='dateFront-save-button' class="col s3 addDateLigne" title='enregistre date' style="display:none" /> 
							<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-sauvegarder-32.png' > 
						</button>
					</div>
				</div>

				<div id="Front-action" class="col s12" style="display:none" >					
					<div id="dateFront-action" class="col s12" style="display:inline-block" >					
						<button id='Front-show-ligne' title='affiche le front'/> 
							<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png'>
						</button>
					</div>
					
					<button id='Front-update-button' title='modifie le front'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'>
					</button>
					<button id='Front-delete-button' title='supprime le front'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> 
					</button>
				</div>	
			
				<div id="defFront" style="display : none;background-color: azure;" class="col s12">
					<div >
						<h2 class="col s12">
						<input id="nom" /></h2>
						<label for="description">description</label>
						<textarea id='description' name='description' rows="10" cols="50" ></textarea> 
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
			
			<div id="choixLigne" class="row" style="position:absolute; top:100px;left:45%; display:none; z-index:700; background-color:white;text-align:center">
				<p id="questionLigne" ></p>
				<label for="typeLigne2" class="col s12">Choisissez le type de ligne à créer :</label>
				<select id="typeLigne2" class="col s6 offset-s3" style="visibility : visible;display :inline-block">
					<option value="" disabled selected>Choisissez</option>
					<option value="1">Ami</option>
					<option value="2">Ennemi</option>
					<option value="3">Neutre</option>
				</select>
				<button id="btnOuiLigne" class="btn center-align col s6 text-green" ><i class="material-icons">check</i> oui</button>
				<button id="btnAnnulerLigne" class="btn center-align col s6 text-red" ><i class="material-icons">cancel</i> annuler</button>
			</div>
			
			<div id="addFront" class="row" style="position:absolute; top:100px;left:45%; display:none; z-index:700; background-color:white;text-align:center">
				<p id="questionFront" ></p>
				<label for="nomFront" class="col s12">Nom du conflit :</label>
				<input id="nomFront" type="text"></input>
				<label for="descriptionFront" class="col s12">Description sommaire :</label>
				<input id="descriptionFront" type="text"></input>
				<button id="btnOuiFront" class="btn center-align col s6 text-green" ><i class="material-icons">check</i> oui</button>
				<button id="btnAnnulerFront" class="btn center-align col s6 text-red" ><i class="material-icons">cancel</i> annuler</button>
			</div>
		</div>