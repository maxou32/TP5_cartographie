<?php 

	
class _AdminChaptersView extends View{	
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
							<h5 class="center"><?= $datas[$i]->getTitle() ?></h5>
							<div class="col m6 s12">
								<?php 
								if(strlen($datas[$i]->getContent())>$params['nbCaracters']){
									$begin=substr($datas[$i]->getContent(),0,$params['nbCaracters']).'<a href="index.php?oneChapter/idchapter/'.$datas[$i]->getIdchapters().'">  (lire la suite...)</a>';
								}else{
									$begin='<a href="index.php?oneChapter/idchapter/'.$datas[$i]->getIdchapters().'">'.$datas[$i]->getContent().'</a>';
								}
								?>
								<p id="content"><?=$begin ?> </p>
							</div>
							<div class="center-align col m6 s12">
								<div class="col m12 s12">
									<br />
									<label for="<?= $datas[$i]->getIdchapters() ?>"  >Statut de ce chapitre </label>
									<input name="<?=  $datas[$i]->getIdchapters()  ?>" type="hidden" id="<?= $datas[$i]->getIdchapters() ?>" value="<?=  $datas[$i]->getStatus_IdStatus()  ?>" />
									<div>
									<?php
										foreach ($params['status'] as $key => $value){
											?>
											<input name="<?= "R".$datas[$i]->getIdchapters() ?>" class="with-gap" type="radio" id="<?="valueChapters".$datas[$i]->getIdchapters().$key ?>" 
												<?php if($datas[$i]->getStatus_IdStatus()==$key){echo "checked";} ?> 
												onClick='javascript:changeStatus("<?= $datas[$i]->getIdchapters() ?>","<?=$key ?>")' />
											<label for="<?="valueChapters".$datas[$i]->getIdchapters().$key ?>"  >
											<?= $value ?></label>
											<?php
										}
									?>
									</div>
									<label for="<?= "number".$datas[$i]->getIdchapters() ?>">Numéro d'ordre du chapitre</label>
									<input name="<?=  "number".$datas[$i]->getIdchapters()  ?>" class="center" type="text" id="<?= "number".$datas[$i]->getIdchapters() ?>" value="<?=  $datas[$i]->getNumber()  ?>" />
								</div>
								
								<div class="row">
									<input  name="<?= "D".$datas[$i]->getIdchapters() ?>" type="checkbox" id="<?="D".$datas[$i]->getIdchapters()?>" value="<?="D".$datas[$i]->getIdchapters() ?>" onClick='javascript:detruit(<?= $datas[$i]->getIdchapters() ?>)'/> 
										<label  class="red-text" for="<?="D".$datas[$i]->getIdchapters()?>" >  Supprimer ce chapitre</label>
									<input  type="checkbox" name="actionAFaire[]" id="<?= "action".$datas[$i]->getIdchapters() ?>" value="<?= $datas[$i]->getIdchapters() ?>" />	
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
		//$title="Voyage en Alaska"; 
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


		
		