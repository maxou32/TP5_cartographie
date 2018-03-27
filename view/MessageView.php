<?php 
	
class MessageView extends View
{
	public function __construct(){
		//echo "<br />construct Inscription View";
		
	}
	public function show($datas){
		//echo "<br />Inscription View avant obStart";
		ob_start();  
		?>
		<div class="row">
			<div class="card-panel orange lighten-5 col m6 offset-m3 s12">
				<div id="resultat"></div>
				<form  class="formUser" method="post" action="?action=envoiMessage.html">    
						<input id="nom" name="nom" type="text" class="validate"  title="Seuls les lettres et les chiffres sont admis" pattern="[a-zA-Z0-9éèêïë ]*" required />
						<label for="nom">nom*</label> 
						<input id="prenom" name="prenom" type="text" class="validate"  title="Seules les lettres et les chiffres sont admis" pattern="[a-zA-Z0-9éèêïë ]*" />
						<label for='prenom'>prénom</label>
						<input id="email" name="email" type="text" class="validate"  title="Seules les lettres et les chiffres sont admis" pattern="[a-z0-9]+[\.a-z0-9\-]*@[a-z0-9]+[\.a-z0-9\-]*" required/>
						<label for='email'>email*</label>
						<input id="objet" name="objet" type="text" class="validate"  title="Seules les lettres et les chiffres sont admis" pattern="[a-zA-Z0-9éèêïë ]*" required/>
						<label for='objet'>objet*</label>
						
						<input id="texte" name="texte" type="text" class="texteMessage"  title="Seules les lettres et les chiffres sont admis"   pattern="[a-zA-Z0-9éèêïë?:;.àù() ]*" required/>						
						<label for='texte'>Votre demande...*</label>
						
						<div class="row">
							<span  class=" waves-effect center-align waves-light  btn btn-large blue col m6 offset-m3 s12 ">
								<input id="submit" type="submit" name="sousAction" value="Envoyer votre demande" class="right-align"><i class="material-icons left">send</i>
							</span>
						</div>
						
					
				</form>
			</div>
		</div>		

		<?php 
		
		return ob_get_clean(); 

	}
}
