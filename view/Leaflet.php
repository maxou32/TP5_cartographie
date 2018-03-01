<?php 

class LeafLet extends View
{	
	public function __construct(){
		
	}

	
	public function show($datas){
		ob_start(); 
		?>
		<script src="public/leaflet/leaflet.js"></script>
		<script src="public/js/leaflet-editable-polyline.js"></script> 
		<script src="public/js/leaflet-contextmenu-min.js"></script> 
		<script data-key="hz2zuzccg4dyv6kacncfnbxj" src="public/sdk-ol/GpPluginLeaflet.js"></script>
		<script src="view/js/carteLeaflet.js"></script> 
		<title>Cartographie</title>
		<div class="row">
			
			<div class="col m12 s12">
				<div id="mapid" style="width: 100%; height: 600px;"></div>
			</div>

			<div id="btnCommande" style="position: absolute; top: 150px; left: 0px; z-index: 600; background-color: azure; padding : 10px; margin: 10px; border-radius: 5px; width:270px; display:none">
				<div id="dateFront-action" class="col s12" style="display:inline-block" >					
					<button id='dateFront-add-button' title='ajoute un front'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png'>
					</button>
					<button id='dateFront-update-button' title='modifie le front'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'>
					</button>
					<button id='dateFront-delete-button' title='supprime le front'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> 
					</button>
				</div>
				<div class="col s12" >
					<label for="dateLigne">Date des lignes</label>
					<select id="dateLigne" style="display:inline-block">
						<option value="" >Choisissez</option> 	<!-- disabled selected  -->
					</select>
					<label for="adddateLigne">nouvelle date</label>
					<input id="adddateLigne" style="display:inline-block"/>
										
				</div>					
				<div id="dateFront-show" class="col s12" style="display:inline-block" >					
					<button id='dateFront-show-ligne' title='affiche le front'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png'>
					</button>
				</div>

				<div id="Front-action" class="col s12" style="display:inline-block" >					
					<div id="dateFront-action" class="col s12" style="display:inline-block" >					
						<button id='Front-show-ligne' title='affiche le front'/> 
							<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png'>
						</button>
					</div>
					<button id='Front-add-button' title='ajoute un front'/> 
						<img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png'>
					</button>
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
		</div>
		
			
		<?php
		return ob_get_clean();
	}
}