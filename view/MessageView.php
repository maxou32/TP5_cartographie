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
			<div class="card-panel col m6 offset-m3 s12">
				<div id="resultat"></div>
				<form  class="formUser" method="post" action="?action=envoiMessage.html">    
					<div class="row">
						<input id="nom" name="nom" type="text"  placeholder="Nom" class="form-control validate col m9 s10 offset-s1"  title="Seuls les lettres et les chiffres sont admis" pattern="[a-zA-Z0-9éèêïë ]*" required />
						<input id="prenom" name="prenom" type="text" placeholder="Prénom" class="form-control validate col m9 s10 offset-s1 "  title="Seules les lettres et les chiffres sont admis"   pattern="[a-zA-Z0-9éèêïë ]*" />
						<input id="email" name="email" type="text" placeholder="Email" class="form-control validate col m9 s10 offset-s1"  title="Seules les lettres et les chiffres sont admis"   pattern="[a-z0-9]+[\.a-z0-9\-]*@[a-z0-9]+[\.a-z0-9\-]*" required/>
						<input id="objet" name="objet" type="text" placeholder="Objet" class="form-control validate col m9 s10 offset-s1"  title="Seules les lettres et les chiffres sont admis"   pattern="[a-zA-Z0-9éèêïë ]*" required/>
						<input id="texte" name="texte" type="text" placeholder="texte" class="form-control validate col m9 s10 offset-s1"  title="Seules les lettres et les chiffres sont admis"   pattern="[a-zA-Z0-9éèêïë?:;.àù() ]*" required/>						
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