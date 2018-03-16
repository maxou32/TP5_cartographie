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
				/*$(function(){
					setInterval(function(){
						$(".slideshow ul").animate({marginLeft:-700},800,function(){
							$(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
						})
					}, 2500);
				});
				*/
					// Set the initial state: Hide all but the first slide
					$('.slideshow').find('> div:eq(0)').nextAll().css({'opacity':'0','display':'none'});

					// On click of a controller link...
					$('.controls > a').click(function(event) {
						event.preventDefault();

						// Get the div containing the clicked link...
						var currentslide = $(this).parents('div:first');

						// ... and get the index of that div
						var currentposition = $('.slideshow div').index(currentslide);

						// Use that index to get the slide we'll be fading to
						var nextposition = ($(this).attr('class')=='next') ? currentposition+1 : currentposition-1;

						// Fade the current slide out...
						$('.slideshow div:eq('+currentposition+')').animate({opacity: 0}, 1000, function() {

							// ... and hide it.
							$('.slideshow div:eq('+currentposition+')').css('display','none');

							// Show the next slide...
							$('.slideshow div:eq('+nextposition+')').css('display','block');

							// ... and fade it in.
							$('.slideshow div:eq('+nextposition+')').animate({opacity: 1}, 1000);
						  }
						);
				});
			});
			
			
		</script>
			<div class="row">	
				<div class ="slideshow col m6 s12"> 
					<div>
						<img src="public/media/FontsBrun1.jpg" alt="1° jour" width="700" height="400" />
							<p class="controls"><a href="#2" class="next">Next</a></p>
					</div>
					<div>
						<img src="public/media/FontsBrun2.jpg" alt="2° jour" width="700" height="400" />
						<p class="controls"><a href="#1" class="prev">Prev</a> /
							<a href="#3" class="next">Next</a></p>
					</div>
					<div>
						<img src="public/media/FontsBrun3.jpg" alt="3° jour" width="700" height="400" />
						<p class="controls"><a href="#2" class="prev">Prev</a>/
							<a href="#4" class="next">Next</a></p>
					</div>
					<div>
						<img src="public/media/FontsBrun4.jpg" alt="4° jour" width="700" height="400" />
						<p class="controls"><a href="#3" class="prev">Prev</a>/
							<a href="#5" class="next">Next</a></p>
					</div>
					<div>
						<img src="public/media/FontsBrun5.jpg" alt="5° jour" width="700" height="400" />
						<p class="controls"><a href="#4" class="prev">Prev</a>
					</div>
				</div>
				
				<div class="col m6 s12">
					<h3 class="center <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-5">Bonjour sur le site de gestion des fronts.</h3>
					<p>Inscrivez-vous pour pouvoir créer et faire évoluer les conflits que vous étudiez.</p>
					<p>Après avoir défini, la zone dans laquelle le conflit s'est déroulé vous pourrez enregistrer les évolutions des fronts jours après jour.
					Ainsi, il vous sera possible de présenter vos exposés à l'aide de ce support pédagogique moderne.</p>
					<p>Dans un premier temps, consultez ci-dessous les zones de conflit déjà explorées à l'aide de la carte interactive.  Une fois inscrit vous pourrez créer l'évolution des fronts que vous étudiez.</p>
					<p>Faites défiler les images ci-jointes pour voir évoluer le front à côté de Brin sur Seille (évolution purement fictive).</p>
					
					
				</div>
			</div>
		<h2 class="center col s12 <?= $datas['style']['couleurFormeLibre'] ?>-text darken-text-5">Implantation des différents conflits. </h2>
			<?= $datas['maCarte'] ?>
		

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
