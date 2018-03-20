<?php 

	
class AdminAbonneView extends View{	
	public function __construct($template){
		$this->template =$template;
	}

	public function show($params,$datas){		
		ob_start(); 
		
		?>
		<script language="javascript" type="text/javascript">
			function changeStatus($abonne,$status) {
				document.getElementById($abonne).value=$status;
				document.getElementById("action"+$abonne).checked=true;
			}
			function changeniveau($abonne,$niveau) {
				document.getElementById($abonne).value=$niveau;
				document.getElementById("action"+$abonne).checked=true;
			}
			function detruit($abonne) {
				document.getElementById("action"+$abonne).checked=true;
			}
		</script>			
		<div class="row">
			<div class="card-panel col s12 m8 offset-m2">
				<form method="post" action="index.php?_validabonnes" class="formChapitre " >
					<?php
					for($i=0;$i<count($datas);$i++)
					{
						?>
						<div  class="collection-item ">
							<div class="row card-panel orange lighten-5">
								<div class="col m4 s12 center-align">
									<h4 id="content"><?=$datas[$i]->getNom() ?> 
									<input name="<?=$datas[$i]->getIdAbonne()  ?>" type="hidden" id="<?= $datas[$i]->getIdAbonne() ?>"  />
									</h4>
								</div>
								<div class="col m3 offset-m1 s6 left-align">
									<?php
										foreach ($params['niveau'] as $key => $value){
											?>
											<input name="<?= "G".$datas[$i]->getIdAbonne() ?>"  class="blue"type="radio" id="<?="niveauabonnes".$datas[$i]->getIdAbonne().$key ?>" <?php if($datas[$i]->getIdNiveau()==$key){echo "checked";} ?> onClick='javascript:changeniveau("<?= $datas[$i]->getIdAbonne() ?>","<?=$key ?>")' value=" <?= $key ?>" />
											<label for="<?="niveauabonnes".$datas[$i]->getIdAbonne().$key ?>" ><?= $value ?></label>
											<?php
										}
									?>
									<br/>
								</div>
								<div class="col m2 offset-m1 s6 left-align">
									<?php
										foreach ($params['status'] as $key => $value){
											?>
											<input name="<?= "S".$datas[$i]->getIdAbonne() ?>" type="radio" id="<?="statusabonnes".$datas[$i]->getIdAbonne().$key ?>" <?php if($datas[$i]->getStatus()==$key){echo "checked";} ?> onClick='javascript:changeStatus("<?= $datas[$i]->getIdAbonne() ?>","<?=$key ?>")' value="<?= $key ?>" /> 
											<label for="<?="statusabonnes".$datas[$i]->getIdAbonne().$key ?>"  ><?= $value ?></label>
											<?php
										}
									?>
								</div>
							
								<div class="row">
									<input class="left-align" name="<?= "D".$datas[$i]->getIdAbonne() ?>" class="center-align " type="checkbox" id="<?="D".$datas[$i]->getIdAbonne()?>" value="<?="D".$datas[$i]->getIdAbonne() ?>" onClick='javascript:detruit("<?= $datas[$i]->getIdAbonne() ?>")'/> 
										<label class="red-text" for="<?="D".$datas[$i]->getIdAbonne()?>" >    Supprimer cet abonné</label>
									<input type="checkbox" name="actionAFaire[]" id="<?= "action".$datas[$i]->getIdAbonne() ?>" value="<?= $datas[$i]->getIdAbonne() ?>" />	
								</div>
							</div>
						</div>	
						<?php 
					}
					?>

					<div class="row">											
						<span  class="col m4 s12 offset-m4 center-align  waves-effect waves-light btn-large blue">
							<input type="submit" name="sousAction" value="Mettre à jour"><i class="material-icons left">build</i>
						</span>
					</div>			
				</form>
			</div>			
		</div>
		<?php
		$contentView=ob_get_clean(); 		
		$menuView=$this->renderTop();
		$asideView=Null;		
		$captionMessage = $this->captionMessage;
		$message=$this->message;
		$footerView=$this->renderBottom();	

		$monTemplate= new template($menuView,$asideView,$footerView,$contentView);
		$monTemplate->show(NULL,NULL);
	}
}	


		
		