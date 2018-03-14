<?php 
	
class _MenuPrivateView extends View
{	

	public function __construct(){
		
	}
	public function show($datas){

		ob_start(); 
		?>

		<script>
			 $(document).ready(function(e){
				$(".dropdown-button").dropdown();
				$(".button-collapse").sideNav();
			});
		</script>
		<div >
			<ul id="menuMobile" class="side-nav active" >
				<li ><a class="no-padding" href="index.php" ><i class="material-icons left">home</i>Accueil</a></li>
				<li ><a class="no-padding" href="?action=leaflet2.html/cible/Leaflet3" >Gestion des fronts</a></li>
				<li ><a class="no-padding" >Fichier JSON</a>
					<ul class="collapsible collapsible-accordion">
						<li><a href="?action=creerFrontsJSON">Maj Json</a></li>
						<li><a href="?action=lireTousFronts">Lire JSON</a></li>
					</ul>
				</li>
				
				<li >
					<ul class="collapsible collapsible-accordion">
						<li><a class="collapsible-header no-padding" href="#">Mon site<i class="material-icons right">arrow_drop_down</i></a>
							<div class="collapsible-body">
								<ul>
									<li><a href="index.php?adminChapter">Zones de conflits</a></li>
									<li><a href="index.php?adminComment" >Commentaires</a></li>
									<li><a href="index.php?adminUser" >Utilisateurs</a></li>
									
								</ul>
							</div>				  
						</li>
					</ul>
				</li>
				<li >
					<ul class="collapsible collapsible-accordion">
						<li><a class="collapsible-header no-padding" href="#">Bonjour, <?= $datas['nom'] ?><i class="material-icons right">arrow_drop_down</i></a>
							<div class="collapsible-body">
								<ul>
									<li><a href="index.php?askUpdateProfil" class="item_menu">Mon profil</a></li>
									<li class="divider"></li>
									<li><a href="index.php?abortAccess" class="item_menu">Me déconnecter</a></li>
								</ul>
							</div>				  
						</li>
					</ul>
				</li>
			</ul>
			<ul  class="dropdown-content active" id="dropdown-1">
				<li><a href="index.php?adminChapter">Zones de conflits</a></li>
				<li><a href="index.php?adminComment" >Commentaires</a></li>
				<li><a href="index.php?adminUser" >Utilisateurs</a></li>
			</ul>
			<ul  class="dropdown-content active" id="dropdown-2">
				<li><a href="index.php?askUpdateProfil" class="item_menu">Mon profil</a></li>
				<li class="divider"></li>
				<li><a href="?action=sortirZoneReservee.html" class="item_menu">Me déconnecter</a></li>
			</ul>
			<ul  class="dropdown-content active" id="dropdown-3">
				<li><a href="?action=creerFrontsJSON">Maj Json</a></li>
				<li><a href="?action=lireTousFronts">Lire JSON</a></li>
			</ul>
			
			<nav class="navbar-fixed">
				<div id="menu" class="nav-wrapper <?= $datas['style']['couleurFondReservee'] ?> <?= $datas['style']['couleurTexteReservee'] ?> darken-1">
					<a href="index.php" id= "logo" class="left brand-logo">	
						<img src="public/media/WMlogo.png"	alt="web-max"  class="logo" style="height:75px;">		
					</a> 
					<a href="#" data-activates="menuMobile" id="menuReduit" class="button-collapse">
						<i class="material-icons">Menu</i>
					</a>	
					<ul id="menuGeneral" class="right hide-on-med-and-down">
						<li ><a  href="index.php" ><i class="material-icons left">Home</i>Accueil</a></li>
						<li ><a  href="?action=leaflet2.html/cible/Leaflet3" >Zones de conflit</a></li>
						<li ><a >Fichier JSON</a>
							<ul class="collapsible collapsible-accordion">
								<li><a href="?action=creerFrontsJSON">Maj Json</a></li>
								<li><a href="?action=lireTousFronts">Lire JSON</a></li>
							</ul>
						</li>
						
						<li >
							<ul class="collapsible collapsible-accordion">
								<li><a class="collapsible-header" href="#">Mon site<i class="material-icons right">arrow_drop_down</i></a>
	  
								</li>
							</ul>
						</li>
						<li><a href="index.php"><i class="material-icons left">home</i>Accueil</a></li>
						<li><a href="index.php?askAddOneChapter" >Nouveau chapitre</a></li>
						<li><a data-activates="dropdown-1" class="dropdown-button" href="#">Gestion<i class="material-icons right">arrow_drop_down</i></a></li>
						<li><a<a data-activates="dropdown-3" class="dropdown-button" href="#">Fichier Json</a></li>
						<li><a data-activates="dropdown-2" class="dropdown-button" href="#">Bonjour <?= $datas['nom'] ?><i class="material-icons right">arrow_drop_down</i></a></li>
					</ul>
				</div>

			</nav>
			<p id="souslogoflottant"></p>												<!-- fin "flottage" du menu -->
		</div>
		

		<?php 
		return ob_get_clean(); 
		
	}
}
