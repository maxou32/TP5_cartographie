<?php 

	
class AdminFrontView extends View{	
	public function __construct($template){
		$this->template =$template;
	}

	public function show($params,$datas){		
		ob_start(); 
		
		?>
		<script language="javascript" type="text/javascript">
			function changeStatus($chapter,$status) {
				document.getElementById($chapter).value=$status;
				document.getElementById("action"+$chapter).checked=true;
			}
			function detruit($chapter) {
				document.getElementById("action"+$chapter).checked=true;
			}
		</script>
		<div class="row">
			<div class="card-panel col s12 m8 offset-m2">
				<form method="post" action="index.php?_validStatusChapters" class="formChapitre " >
						
					<div >
					<?php
					for($i=0;$i<count($datas);$i++)
					{
						?>
						<div class="row card-panel orange lighten-5">
							<h5 class="center"><?= $datas[$i]->getNom() ?></h5>
							<div class="col m6 s12">
								<p id="content"><?= $datas[$i]->getDescription() ?> </p>
							</div>
							<div class="center-align col m6 s12">
								<div class="col m12 s12">
									<br />
									<label for="<?= $datas[$i]->getIdFront() ?>"  >Statut de ce front </label>
									<input name="<?=  $datas[$i]->getIdFront()  ?>" type="hidden" id="<?= $datas[$i]->getIdFront() ?>" value="<?=  $datas[$i]->getValide()  ?>" />
									<div>
									<?php
										foreach ($params['status'] as $key => $value){
											?>
											<input name="<?= "R".$datas[$i]->getIdFront() ?>" class="with-gap" type="radio" id="<?="valueChapters".$datas[$i]->getIdFront().$key ?>" 
												<?php if($datas[$i]->getValide()==$key){echo "checked";} ?> 
												onClick='javascript:changeStatus("<?= $datas[$i]->getIdFront() ?>","<?=$key ?>")' />
											<label for="<?="valueChapters".$datas[$i]->getIdFront().$key ?>"  >
											<?= $value ?></label>
											<?php
										}
									?>
									</div>
								</div>
								
								<div class="row">
									<input  name="<?= "D".$datas[$i]->getIdFront() ?>" type="checkbox" id="<?="D".$datas[$i]->getIdFront()?>" value="<?="D".$datas[$i]->getIdFront() ?>" onClick='javascript:detruit(<?= $datas[$i]->getIdFront() ?>)'/> 
										<label  class="red-text" for="<?="D".$datas[$i]->getIdFront()?>" >  Supprimer ce front</label>
									<input  type="checkbox" name="actionAFaire[]" id="<?= "action".$datas[$i]->getIdFront() ?>" value="<?= $datas[$i]->getIdFront() ?>" />	
								</div>
							</div>
								</div>

						<?php 
					}
					?>
					</div>
					<div class="row">
						<span  class="col m4 s12 offset-m4 center-align waves-effect waves-light btn-large blue ">
							<input type="submit" name="sousAction" value="Mettre à jour" ><i class="material-icons left">build</i>

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


		
		