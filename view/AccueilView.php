<?php 

class AccueilView extends View
{	
	public function __construct(){
	}

	
	public function show($datas){
		ob_start(); 
		?>
		<script language="javascript" type="text/javascript">
			$(document).ready(function(){
				$('.carousel').carousel();
				$('.parallax').parallax();
				//$('.carousel .carousel-slider').carousel({fullWidth: true});
			});
		</script>
		<div id="btnCommande" style="position: absolute; margin: auto; z-index: 800; background-color: azure; padding : 10px; border-radius: 5px; ">

		</div>
			<div class="row">
			
			<div class ="carousel carousel-slider col s12" data-indicators="true" id="slide">
				<div class="carousel-fixed-item <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-5 center">
					<button id="addCarte" class=" blue lighten-5 center-align" formmethod ="post" style="width: 250px; height : 200px" formaction="?action=lireTousFronts" type="submit">Voir tous les fronts 
							<!-- <img src="public/sdk-ol/img/MarkerVert.png">  -->
					</button>
					<form method="post" action="?action=leaflet2.html/cible/Leaflet2">
						<input type="submit" name="sousAction"  value="Ajouter ce chapitre">
					</form>
				</div> 
				<div class="carousel-item center">
					<!-- <h2>1° étape</h2>
					<p >Rechercher les cartes ou les textes représentant le front</p> -->
					<img src="public/media/Carte05_Pompey_Toulv2.jpg" style="width:100%;">
				</div> 
				<div class="carousel-item  center" >
					<img src="public/media/FrontsBrun.jpg" style="width:100%;">
				</div> 
				<div class="carousel-item">
					<img src="public/media/FrontsChambrey.jpg" style="width:100%;">
				</div> 
			</div>
				
		</div>
		<h2 class="center <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-5">les dernières réalisations</h2>
		<div class="row">
			<div class ="col s12" id="panneauCartesRecentes">
				<div class ="col m4 s12" id="panneau1">					
				  <div class="card ">
					<div class="card-image">
					  <img src="public/media/Carte05_Pompey_Toulv2.jpg" style="height:216px">
					  <span class="card-title text-black">Le front à Pompey</span>
					  <a href="?action=IGN.html" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>				  
					</div>
					<div class="card-content">
					  <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
					</div>
				  </div>            
				</div>
				<div class ="col m4 s12" id="panneau2">
				  <div class="card ">
					<div class="card-image">
					  <img src="public/media/FrontsChambrey.jpg">
					  <span class="card-title text-black">Le front à Chambrey</span>
					  <a  href="?action=leaflet1.html/cible/Leaflet1" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
					</div>
					<div class="card-content">
					  <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
					</div>
				  </div>
				</div>
				<div class ="col m4 s12" id="panneau3">
					<div class="card ">
						<div class="card-image">
						  <img src="public/media/FrontsBrun.jpg">
						  <span class="card-title text-black">Le front à Brun</span>
						  <a  href="?action=leaflet2.html/cible/Leaflet2" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
						</div>
						<div class="card-content">
						  <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
						</div>			
					</div>
				</div>
			</div>
			<h2 class="center <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-5">Contact</h2>
			<div class ="col s12" >
				<div class= "col s1 offset-s2 <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-4" id="Contact">
					<i class="large material-icons">email</i>
				
				</div>	
				<div class ="col  s1 offset-s3 <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-4" id="sInscrire">
					<i class="large  material-icons">person_add</i>
				
				</div>
				<div class ="col  s1 offset-s3 <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-4" id="accesReserve">
					<i class="large material-icons">photo</i>
				
				</div>				
			</div>
			<div class= "col s12"  id="reseauSociaux">
			</div>
			<div id='resultat'>
			</div>
		</div>
		<?php
		
		$accueilView=ob_get_clean();

		return $accueilView;

	}

}
