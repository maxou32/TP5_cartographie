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
				$('.carousel.carousel-slider').carousel({fullWidth: true, padding:0},setTimeout(autoplay, 4500));
				function autoplay() {
					$('.carousel').carousel('next');
					setTimeout(autoplay, 4500);
				}
			});
			
		</script>
				
			<div class ="carousel carousel-slider" id="slide">
				<div class="carousel-item ">
					<img src="public/media/FontsBrun1.jpg">
				</div> 
				<div class="carousel-item" >
					<img src="public/media/FontsBrun2.jpg">
				</div> 
				<div class="carousel-item">
					<img src="public/media/FontsBrun3.jpg">
				</div> 
				<div class="carousel-item">
					<img src="public/media/FontsBrun4.jpg">
				</div> 
				<div class="carousel-item">
					<img src="public/media/FontsBrun5.jpg">
				</div> 
			</div>
		
		<h2 class="center <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-5">Implantation des différents conflits. </h2>
			<?= $datas['maCarte'] ?>
		</div>
		<!--
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
					  <a  href="?action=leaflet2.html/cible/Leaflet2" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
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
						  <a  href="?action=leaflet2.html/cible/Leaflet3" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
						</div>
						<div class="card-content">
						  <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
						</div>			
					</div>
				</div>
			</div>
		</div>
		-->
		<h2 class="center <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-5">Contact et accès réservé</h2>
		<div class="row">
			<div class ="col s12" >
				<div class= "col s1 offset-s2 <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-4" id="Contact">
					<a href="index.php?askSendMail"><i class="large material-icons">email</i></a>
				
				</div>	
				<div class ="col  s1 offset-s3 <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-4" id="sInscrire">
					<a href="?action=inscription.html/classe/InscriptionView/action/show"><i class="large  material-icons">person_add</i> </a>
				
				</div>
				<div class ="col  s1 offset-s3 <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-4" id="accesReserve">
					<a href="?action=accesreserve.html/classe/AccesReserveView/action/show" ><i class="large material-icons">photo</i></a>
				</div>				
			</div>
		</div>
		<div class= "col s12"  id="reseauSociaux">
		</div>
		<div id='resultat'>
		</div>
		
		<?php
		
		$accueilView=ob_get_clean();

		return $accueilView;

	}

}
