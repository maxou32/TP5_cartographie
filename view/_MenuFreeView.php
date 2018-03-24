<?php 

class _MenuFreeView extends View
{	

	public function __construct(){
		
	}
	public function show($datas){

		ob_start(); 
		?>
		<script>
			 $(document).ready(function(e){
				$(".button-collapse").sideNav();
			});
		</script>
			<nav class="navbar-fixed">
				<div id="menu" class="nav-wrapper <?= $datas['style']['couleurFondLibre'] ?> darken-1  <?= $datas['style']['couleurTexteLibre'] ?> darken-text-5 " >
					
					<a href="#" data-activates="menuMobile" id="menuReduit" class="button-collapse">
						<i class="material-icons">menu</i>
					</a>	
					<ul id="menuGeneral" class="left hide-on-med-and-down">
						<li><a href="?action=accueil.html" ><i class="material-icons left">home</i>Accueil</a></li>
						<li><a href="?action=leaflet2.html" >Zones de conflit</a></li>
						<li><a href="?action=demandeMessage.html">Contactez moi</a></li>
						<li><a href="?action=inscription.html"> Inscrivez-vous</a></li>
						<li class="divider"></li>
						<li><a href="?action=accesreserve.html" >Gestion des conflits</a></li>
					
					</ul>
					<ul id="menuMobile" class="side-nav active" >
						<li><a class="no-padding" href="?action=accueil.html" ><i class="material-icons left">home</i>Accueil</a></li>
						<li><a class="no-padding" href="?action=leaflet2.html" >Zones de conflit</a></li>
						<li><a class="no-padding" href="?action=demandeMessage.html">Contactez moi</a></li>
						<li><a class="no-padding" href="?action=inscription.html"> Inscrivez-vous</a></li>
						<li class="divider"></li>
						<li><a class="no-padding" href="?action=accesreserve.html" >Gestion des conflits	</a></li>
					</ul>
					<a href="http://web-max.fr" id= "logo" class="right  brand-logo">	
						<img src="public/media/WMlogo.png"	alt="web-max" style="height:65px;">		
					</a> 
				</div>
			</nav>
				
		
			
		<?php 
		$menuView=ob_get_clean(); 
		return $menuView;  
		
	}
}
