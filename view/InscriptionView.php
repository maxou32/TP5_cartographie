<?php
	
class InscriptionView extends View
{
	public function __construct(){
		//echo "<br />construct Inscription View";
		
	}
	public function show($datas){
		ob_start(); 
		echo "<br />Inscription View avant obStart<pre>";print_r($datas);echo"</pre>";
		?>
			<script language="javascript" type="text/javascript">
				function verifPwd() {
						if (document.getElementById('userPwd').value != document.getElementById('confPwd').value){
							$('#modal').css({visibility: 'visible',display:'inline-block'});
							$('#bouton').css({visibility: 'hidden'});
							setTimeout(function(){
								$('#modal').css({visibility: 'hidden',display:'none'});;
								$('#bouton').css({visibility: 'visible',display:'inline-block'});
								}, 4000);
						}
					
				}
			</script>
			<div id="modal" class="modal card-panel hoverable" style="visibility : hidden;">
				<div class="modal-content ">
					<h5><i class="material-icons">info</i>Vérification mot de passe</h5>
					<div class="divider"></div>
					<p>Les deux mots de passe ne sont pas identiques, merci de recommencer.	</p>
				</div>
				<div class="progress">
					<div class="indeterminate"></div>
				</div>
			</div>
			<div class="row" >
				<form class="col m8 offset-m2 s12 card-panel orange lighten-5"  method="post" action="?action=enregistrement.html" >
					<!-- <input id="sousActionAdd" name="sousAction" type="hidden" value ="add" >  -->
					<div class="row" >
						<p class= "col m6 s12"><label for="userName">votre nom*</label>
						<input id="userName" name="userName" type="text"  class="form-control validate" pattern="[a-zA-Z0-9éèêïë ]*"  required /></p>
						<p class= "col m6 s12"><label for="firstName">votre prénom*</label>
						<input id="firstName" name="firstName" type="text"  class="form-control validate" pattern="[a-zA-Z0-9éèêïë ]*"  required /></p>
						<p class= "col m6 s12"><label for="userPwd">votre mot de passe*</label>
						<input id="userPwd" name="userPwd" type="password" class="form-control validate" pattern=".{5,}"    title="5 caractères minimum" required /><br /></p>
						<p class= "col m6 s12"><label for="confPwd">confirmez votre mot de passe*</label>
						<input id="confPwd" name="confPwd" type="password" class="form-control validate" pattern=".{5,}" title="5 caractères minimum" required onChange='verifPwd()'/><br /></p>
						<p class= "col m6 s12"><label for="mail">votre adresse mail*</label>
						<input id="mail" name="mail" type="email" class="form-control validate" required /></p>
						<p class= "col m6 s12"><label>choisissez un avatar</label></p>

					</div>					 
					<div class="row">	
						<span  id="bouton"  class="col m4 s12 offset-m4 center-align  waves-effect waves-light btn-large blue">
							<input type="submit" name="add" value="Soumettre" onLoad='verifPwd()'><i class="material-icons left">send</i>
						</span>					
					</div>	
				</form>
			</div>

	
		<?php
		return ob_get_clean();
	}
}