<?php 

class AccueilView extends View
{	
	public function __construct(){
	}

	
	public function show($datas){
		ob_start(); 
		?>
		<script>
			$(document).ready(function(){
				$('.slideshow').find('> div:eq(0)').nextAll().css({'opacity':'0','display':'none'});
				$('.controls > a').click(function(event) {
					event.preventDefault();
					var currentslide = $(this).parents('div:first');
					var currentposition = $('.slideshow div').index(currentslide);
					var nextposition = ($(this).attr('class')=='next') ? currentposition+1 : currentposition-1;
					$('.slideshow div:eq('+currentposition+')').animate({opacity: 0}, 1000, function() {
						$('.slideshow div:eq('+currentposition+')').css('display','none');
						$('.slideshow div:eq('+nextposition+')').css('display','block');
						$('.slideshow div:eq('+nextposition+')').animate({opacity: 1}, 1000);
					});
				});
			});
			
			
		</script>
			<div class="row">	
				<div class ="slideshow col m6 s12 center"> 
					<div>
						<img src="public/media/Front1.jpg" class="imgFront" alt="voir les fronts d'un conflit" />
							<p class="controls"><a href="#2" class="next"></a><a href="#3" class="next"><img src="public/sdk-ol/img/icons8-superieur-32.png" alt="Suivant"></a></p>
					</div>
					<div>
						<img src="public/media/Front2.jpg" class="imgFront" alt="1° jour"  />
						<p class="controls"><a href="#1" class="prev"><img src="public/sdk-ol/img/icons8-inferieur-32.png" alt="Précédent"></a><a href="#3" class="next"><img src="public/sdk-ol/img/icons8-superieur-32.png" alt="Suivant"></a></p>
					</div>
					<div>
						<img src="public/media/Front3.jpg" class="imgFront" alt="2° jour"  />
						<p class="controls"><a href="#2" class="prev"><img src="public/sdk-ol/img/icons8-inferieur-32.png" alt="Précédent"></a><a href="#4" class="next"><img src="public/sdk-ol/img/icons8-superieur-32.png" alt="Suivant"></a></p>
					</div>
					<div>
						<img src="public/media/Front4.jpg" class="imgFront" alt="3° jour" />
						<p class="controls"><a href="#3" class="prev"><img src="public/sdk-ol/img/icons8-inferieur-32.png" alt="Précédent"></a><a href="#5" class="next"><img src="public/sdk-ol/img/icons8-superieur-32.png" alt="Suivant"></a></p>
					</div>
					<div>
						<img src="public/media/Front5.jpg" class="imgFront" alt="4° jour" />
						<p class="controls"><a href="#4" class="prev"><img src="public/sdk-ol/img/icons8-inferieur-32.png" alt="Précédent"></a><a href="#5" class="next"><img src="public/sdk-ol/img/icons8-superieur-32.png" alt="Suivant"></a></p>
					</div>
					<div>
						<img src="public/media/Front6.jpg" class="imgFront"  alt="5° jour" />
						<p class="controls"><a href="#5" class="prev"><img src="public/sdk-ol/img/icons8-inferieur-32.png" alt="Précédent"></a>
					</div>
				</div>
				
				<div class="col m6 s12">
					<h3 class="center <?= htmlspecialchars($datas['style']['couleurFormeLibre']) ?>-text darken-text-5">Site de présentation de fronts.</h3>
					
					<p>Après avoir défini, la zone dans laquelle le conflit s'est déroulé vous pourrez enregistrer les évolutions des fronts jours après jours.
					Ainsi, il vous sera possible de présenter vos exposés à l'aide de ce support pédagogique moderne.</p>
					<p>Dans un premier temps, consultez <a href="?action=leaflet2.html"> les zones de conflit déjà explorées</a> à l'aide de la carte interactive. </p>
					<p>Faites défiler les images ci-jointes pour voir évoluer le front à côté de Brin sur Seille (évolution purement fictive).</p>
					<p>Pour pouvoir créer et faire évoluer des conflits <a href="?action=inscription.html/classe/InscriptionView/action/show">demandez votre inscription.</a></p>
					
				</div>
			</div>
		

		<h2 class="center <?= htmlspecialchars($datas['style']['couleurFormeLibre']) ?>-text darken-text-5">Contact et accès réservé</h2>
		<div class="row">
			<div class ="col s12" >
				<div class= "col s1 offset-s2 <?= htmlspecialchars($datas['style']['couleurFormeLibre']) ?>-text darken-text-4" id="Contact">
					<a href="?action=demandeMessage.html"><i class="large material-icons">email</i></a>
				</div>	
				<div class ="col s1 offset-s3 <?= htmlspecialchars($datas['style']['couleurFormeLibre']) ?>-text darken-text-4" id="sInscrire">
					<a href="?action=inscription.html/classe/InscriptionView/action/show"><i class="large  material-icons">person_add</i> </a>
				</div>
				<div class ="col s1 offset-s3 <?= htmlspecialchars($datas['style']['couleurFormeLibre']) ?>-text darken-text-4" id="accesReserve">
					<a href="?action=accesreserve.html/classe/AccesReserveView/action/show" ><i class="large material-icons">photo</i></a>
				</div>				
			</div>
		</div>
		
		<div id='resultat'>
		</div>
		
		<?php
		
		$accueilView=ob_get_clean();

		return $accueilView;

	}

}
