<?php 
	
class AccesReserveView extends View
{
	public function __construct(){
		//echo "<br />construct Inscription View";
		
	}
	public function show($datas){
		//echo "<br />Inscription View avant obStart";
		ob_start();  
		?>
		<script>
			$(document).ready(function(){
				$('#cercle').css('display','none');
				$('#cocheNom').css('display','none');
				$("#userName").blur(function(){
					$('#cercle').css('display','inline-block');
					$.post(
						'?action=verifUser/', // Adresse du script PHP controlant la saisie
						{
							username : $("#userName").val() 
						},

						function(data){
							if(data == 'Success'){ 
								$("#resultat").html("<p></p>");
								$('#cocheNom').css('display','inline-block');
								$("#userName").css('border-bottom-color', 'green');
								$("#userName").css('border-shadow-color', 'green');
								$("#userName").css('-webkit-box-shadow', '0px 1px 0px 0px #4caf50');
								$("#userName").css('border-shadow', '0px 1px 0px 0px #4caf50');
								$("#userName").css('box-shadow', '0px 1px 0px 0px #4caf5');
							 }else if(data == 'nothing'){
								 $("#resultat").html("<p>Nom inconnu...</p>");
								 
							}else{
								$("#resultat").html("<p>"+data+"</p>");
								$("#userName").css('border-bottom-color', 'red');
								$("#userName").css('border-shadow-color', 'red');
								$("#userName").css('-webkit-box-shadow', '0px 1px 0px 0px #F44336');
								$("#userName").css('border-shadow', '0px 1px 0px 0px #F44336');
								$("#userName").css('box-shadow', '0px 1px 0px 0px #F44336');
							};
							$('#cercle').css('display','none');
						},
						'text' // Format du retour 
					 );
				});		
			});

		</script>

		<div class="row">
			<div class="card-panel col m6 offset-m3 s12">
				<div id="resultat"></div>
				<form  class="formUser" method="post" action="?action=zonereservee.html">    
					<div class="row">
					<label for ="userName" class="col s12"> Nom *:</label>
					<input id="userName" name="userName" type="text"  class="form-control validate col m10 s10"  title="Seuls les lettres et les chiffres sont admis" pattern="[a-zA-Z0-9éèêïë ]*"       required />
					<input id="cocheNom" class="green-text" type="checkbox" id="test6" checked="checked" />
					<div id="cercle" class="preloader-wrapper small active">
						<div class="spinner-layer spinner-green-only">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<label for ="userPwd" class="col s12"> Mot de passe *:</label>	
						<input id="userPwd" name="userPwd" type="password" class="form-control validate col m10 s10"  pattern=".{5,}" title="Seules les lettres et les chiffres sont admis"   pattern="[a-zA-Z0-9éèêïë ]*" required/>
					</div>
					<span  class=" waves-effect center-align waves-light  btn btn-large blue col m6 offset-m3 s12 ">
						<input id="submit" type="submit" name="sousAction" value="Accéder à l'espace réservé" class="right-align"><i class="material-icons left">send</i>
					</span>
				</form>
			</div>
		</div>		

		<?php 
		
		return ob_get_clean(); 

	}
}