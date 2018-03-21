<?php 

	
class AdminAbonneView extends View{	
	public function __construct(){
		
	}

	public function show($datas){	
		//echo"<pre>";print_r($datas);echo"</pre>";
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
				<form method="post" action="?action=validabonnes" class="formChapitre " >
					<?php
					for($i=0;$i<count($datas['abonne']);$i++)
					{
						?>
						<div  class="collection-item ">
							<div class="row card-panel orange lighten-5">
								<div class="col m4 s12 center-align">
									<h4 id="content"><?=$datas['abonne'][$i]->getNom() ?> 
									<input name="<?=$datas['abonne'][$i]->getIdAbonne()  ?>" type="hidden" id="<?= $datas['abonne'][$i]->getIdAbonne() ?>"  />
									</h4>
								</div>
								<div class="col m3 offset-m1 s6 left-align">
									<?php
										foreach ($datas['niveau'] as $key => $value){
											?>
											<input name="<?= "N".$datas['abonne'][$i]->getIdAbonne() ?>"  class="blue"type="radio" id="<?="niveauabonnes".$datas['abonne'][$i]->getIdAbonne().$key ?>" <?php if($datas['abonne'][$i]->getIdNiveau()==$key){echo "checked";} ?> onClick='javascript:changeniveau("<?= $datas['abonne'][$i]->getIdAbonne() ?>","<?=$key ?>")' value=" <?= $key ?>" />
											<label for="<?="niveauabonnes".$datas['abonne'][$i]->getIdAbonne().$key ?>" ><?= $value ?></label>
											<?php
										}
									?>
									<br/>
								</div>
								<div class="col m2 offset-m1 s6 left-align">
									<?php
										foreach ($datas['status'] as $key => $value){
											?>
											<input name="<?= "S".$datas['abonne'][$i]->getIdAbonne() ?>" type="radio" 
												id="<?="statusabonnes".$datas['abonne'][$i]->getIdAbonne().$key ?>" 
												<?php 
												if($datas['abonne'][$i]->getStatus() === $key){
													echo "checked";
												}
												?> onClick='javascript:changeStatus("<?= 
												$datas['abonne'][$i]->getIdAbonne() ?>","<?=$key ?>")' value="<?= $key ?>" /> 
											<label for="<?="statusabonnes".$datas['abonne'][$i]->getIdAbonne().$key ?>"  ><?= $value ?></label>
											<?php
										}
									?>
								</div>
							
								<div class="row">
									<input class="left-align" name="<?= "D".$datas['abonne'][$i]->getIdAbonne() ?>" class="center-align " type="checkbox" id="<?="D".$datas['abonne'][$i]->getIdAbonne()?>" value="<?="D".$datas['abonne'][$i]->getIdAbonne() ?>" onClick='javascript:detruit("<?= $datas['abonne'][$i]->getIdAbonne() ?>")'/> 
										<label class="red-text" for="<?="D".$datas['abonne'][$i]->getIdAbonne()?>" >    Supprimer cet abonné</label>
									<input type="checkbox" name="actionAFaire[]" id="<?= "action".$datas['abonne'][$i]->getIdAbonne() ?>" value="<?= $datas['abonne'][$i]->getIdAbonne() ?>" />	
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

		return $contentView;
	}
}	


		
		