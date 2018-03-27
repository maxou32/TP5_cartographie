		<script src="public/leaflet/leaflet.js"></script>
		<script src="public/js/leaflet-editable-polyline.js"></script> 
		<script src="public/js/leaflet-contextmenu-min.js"></script> 
		<script data-key="hz2zuzccg4dyv6kacncfnbxj" src="public/sdk-ol/GpPluginLeaflet.js"></script>
		<script src="view/js/carteLeaflet.js"></script> 
		<script>
			// a mettre en bas si possible 
			var monUser=Object.create(User);
			monUser.init(<?= htmlspecialchars($datas['idAbonne']) ?>,<?=htmlspecialchars( $datas['levelUser']) ?>);
			listeUser.push(monUser);
			console.log('user level from view :'+listeUser[0].userLevel);
			
			var mesParamGeneraux=Object.create(paramGeneraux);
			var zoom=<?= htmlspecialchars($datas['paramGeneraux']['zoom']) ?>;
			var latCentre=<?= htmlspecialchars($datas['paramGeneraux']['latCentre']) ?>;
			var lngCentre=<?= htmlspecialchars($datas['paramGeneraux']['lngCentre']) ?>;
			var maxZoom=<?= htmlspecialchars($datas['paramGeneraux']['maxZoom']) ?>;
			var tileSize=<?= htmlspecialchars($datas['paramGeneraux']['tileSize']) ?>;
			var boxZoom=<?= htmlspecialchars($datas['paramGeneraux']['boxZoom']) ?>;
			var attribution="<?= htmlspecialchars($datas['paramGeneraux']['attribution']) ?>";
			var layer1="<?= htmlspecialchars($datas['paramGeneraux']['layer1']) ?>";
			var layer2="<?= htmlspecialchars($datas['paramGeneraux']['layer2']) ?>";
			var synchrone=<?= htmlspecialchars($datas['paramGeneraux']['synchrone']) ?>;
			mesParamGeneraux.init(
				zoom,latCentre,lngCentre,maxZoom,tileSize,boxZoom,attribution,layer1, layer2,synchrone);
			ParamGeneraux.push(mesParamGeneraux);
			
			
			<?php
				for($f=0;$f < count($datas['front']); $f++){
					$temp['idfront']=htmlspecialchars($datas['front'][$f]['idfront']);
					$temp['nom']= htmlspecialchars($datas['front'][$f]['nom']);
					$temp['zoom']= htmlspecialchars($datas['front'][$f]['zoom']);
					$temp['lat']= htmlspecialchars($datas['front'][$f]['lat']);
					$temp['lng']= htmlspecialchars($datas['front'][$f]['lng']);
					$temp['valide']= htmlspecialchars($datas['front'][$f]['valide']);
					$temp['idauteur']= htmlspecialchars($datas['front'][$f]['idauteur']);
					$temp['description']= htmlspecialchars($datas['front'][$f]['description']);
					?>
					var mesFronts=Object.create(Front);
					mesFronts.init( 
						<?= htmlspecialchars($temp['idfront']) ?>,
						"<?= htmlspecialchars($temp['nom']) ?>",
						<?= htmlspecialchars($temp['zoom']) ?>,
						"<?= htmlspecialchars($temp['lat']) ?>",
						"<?= htmlspecialchars($temp['lng']) ?>",
						<?= htmlspecialchars($temp['valide']) ?>,
						<?= htmlspecialchars($temp['idauteur']) ?>,
						"<?= htmlspecialchars($temp['description']) ?>"
					);
					listeFronts[<?= htmlspecialchars($temp['idfront']) ?>]=mesFronts;
					console.log('id front =' + mesFronts['idfront']);
					<?php
				}
			?>
		</script>
		<div class="row">
			
			<div class="col m12 s12">
				<div id="mapid"  ></div>
			</div>
			
			<div id="btnCommande" >
				<div id="fermeCommande">
					<a  href="#">X</a>
				</div>
				<div class="detailFront col s12" style="display:none" >		
					<label class="detailFront" for="nomDetailFront">Nom</label>
					<input class="detailFront" type="text" id="nomDetailFront"/>
					<label class="detailFront" for="descriptionDetailFront">Description</label>
					<input class="detailFront" id="descriptionDetailFront" />
					<button id='detailFront-save-button' class="col s3 detailFront" title='enregistre modification conflit'> 
						<img src='public/sdk-ol/img/icons8-sauvegarder-32.png' alt="Enregistre" > 
					</button>
				</div>
				<div class="textDescriptifLigne col s12" style="display:none">
					<p id="textDescriptifLigne" class="textDescriptifLigne">descriptif date</p>
				</div>
				<div id="btnNavDate" class="col s12">
					<p>Faites défiler le temps : </p>
					<a id="btnNavDatePrev"><img src="public/sdk-ol/img/icons8-inferieur-32.png" alt="Précédent"></a>
					<a id="btnNavDateNext"><img src="gesFront/public/sdk-ol/img/icons8-superieur-32.png" alt="Suivant"></a>
				</div>
				<div id="infoDateLigne" class= "col s12" >
					<label class="dateLigne" for="dateLigne">Date des lignes</label>
					<select class="dateLigne" id="dateLigne" >
						<option value="" >Choisissez une date</option> 	<!-- disabled selected  -->
					</select>
					<label class="addDateLigne infoligne" for="addDateLigne">Date</label>
					<input class="addDateLigne infoligne" type="date" id="addDateLigne"/>
					<label class="
					infoligne" for="addDescriptionLigne">Description</label>
					<input class="addDateLigne infoligne" id="addDescriptionLigne" /> 
										
				</div>					
				<div id="dateFront-show" class="col s12" >					
					<div class="admin">
						<div class="row">
							<button id='dateFront-add-button' class="dateFrontAction col s3" title='ajoute une nouvelle date'> 
								<img src='public/sdk-ol/img/icons8-add-new-32.png' alt='Creéation'>
							</button>
							<button id='dateFront-dupplicate-button' class="dateFrontAction col s3" title='dupplique une  date'> 
								<img src='public/sdk-ol/img/icons8-copie-32.png' alt='Dupplication'>
							</button>
							<button id='dateFront-update-button' class="dateFrontAction col s3" title='modifie les caractéristiques de la date'> 
								<img src='public/sdk-ol/img/icons8-modifier-32.png' alt='Mise à jour'>
							</button>					
							<button id='dateFront-delete-button' class="dateFrontAction col s3" title='supprime une date'> 
								<img src='public/sdk-ol/img/icons8-poubelle-32.png' alt='Suppression'> 
							</button>
						</div>
						<div class="row dateFront-save-cancel">
							<button id='dateFront-save-button' class="col s3 offset-s3" title='enregistre date'  > 
								<img src='public/sdk-ol/img/icons8-sauvegarder-32.png' alt='Sauvegarde'> 
							</button>
							<button id='dateFront-cancel-button' class="col s3" title='annule action'  > 
								<img src='public/sdk-ol/img/icons8-annuler-32.png' alt='Annulation'> 
							</button>
						</div>
					</div>
				</div>

				<div id="Front-action" class="col s12" >					
					<div id="dateFront-action" class="col s12" style="display:inline-block" >					
						<button id='Front-show-ligne' title='affiche le front'> 
							<img src='public/sdk-ol/img/icons8-visible-32.png' alt='Montre ligne' >
						</button>
					</div>
					
					<button id='Front-update-button' title='modifie le front'> 
						<img src='public/sdk-ol/img/icons8-modifier-32.png' alt='Modifie le front'>
					</button>
					<button id='Front-delete-button' title='supprime le front'> 
						<img src='public/sdk-ol/img/icons8-poubelle-32.png' alt='Supprime le front'> 
					</button>
				</div>	
			
				<div id="defFront" class="col s12">
					<div >
						<input id="nom" />
						<label for="description">description</label>
						<textarea id='description' name='description' rows="10" cols="50" ></textarea> 
					</div>
				</div>
			</div>
			

			<p id="resultat"></p>
			
			<div id="confirmation" class="row">
				<p id="question"></p>
				<button id="btnOui" class="btn center-align col s6 text-green" ><i class="material-icons">check</i>oui</button>
				<button id="btnNon" class="btn center-align col s6 text-red" ><i class="material-icons">cancel</i> non</button>
			</div>
			
			<div id="choixLigne" class="row">
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
			
			<div id="addFront" class="row">
				<p id="questionFront" ></p>
				<label for="nomFront" class="col s12">Nom du conflit :</label>
				<input id="nomFront" type="text">
				<label for="descriptionFront" class="col s12">Description sommaire :</label>
				<input id="descriptionFront" type="text">
				<button id="btnOuiFront" class="btn center-align col s6 text-green" ><i class="material-icons">check</i> oui</button>
				<button id="btnAnnulerFront" class="btn center-align col s6 text-red" ><i class="material-icons">cancel</i> annuler</button>
			</div>
		</div>
