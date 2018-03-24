<?php 

class VoirMessagesView extends View
{	
	public function __construct(){
	}

	
	public function show($datas){
		
		ob_start();
		//echo "debut vue voirMessagesView-> execute carte<pre>";print_r($datas['message']);echo"</pre>"; 
		?>
		<script>
		function changeLu($idMessage) {
			document.getElementById($idMessage).checked ? document.getElementById("_"+$idMessage).checked = false :document.getElementById("_"+$idMessage).checked = true;
		}
		
            
		</script>
			<div class="row">
				<form method="post" action="?action=noteMessageLu" class="col m10 offset-m1 s12">
					<div class ="col m10 offset-m1 s12">
					
					<?php
						for($i=0; $i< count($datas['message']); $i++){
							//echo "debut vue voirMessagesView-> execute carte<pre>";print_r($datas['message'][$i]);echo"</pre>"; 
							?>
							<ul class="collapsible popout"> 
								<li>
									<div class="collapsible-header row">
										<input class="col m12" name="<?= htmlspecialchars($datas['message'][$i]->getIdMessage()) ?>" type="checkbox" 
											id="<?= htmlspecialchars($datas['message'][$i]->getIdMessage()) ?>" 
											<?php 
											if(strval(htmlspecialchars($datas['message'][$i]->getLu())) === strval(true)){
												echo "checked";
											}else{
												echo "unchecked";
											}
											?> 
											onClick='javascript:changeLu("<?= htmlspecialchars($datas['message'][$i]->getIdMessage()) ?>")'
										/> 
										<label for="<?=htmlspecialchars($datas['message'][$i]->getIdMessage())?>">Lu  ?</label>
										
										<input class="col m12" name="<?= htmlspecialchars("_".$datas['message'][$i]->getIdMessage()) ?>" type="checkbox" 
											id="<?= htmlspecialchars("_".$datas['message'][$i]->getIdMessage()) ?>" 
											<?php 
											if(strval(htmlspecialchars($datas['message'][$i]->getLu())) == strval(true)){
												echo "unchecked";
											}else{
												echo "checked";
											}
											?> 
										/>
										<p class="col s6">objet : <?= htmlspecialchars($datas['message'][$i]->getObjet()) ?></p>
										
											
										<div class="col S12">
											<p >de : <?= htmlspecialchars($datas['message'][$i]->getNom()) ?>,  
											 <?= htmlspecialchars($datas['message'][$i]->getPrenom()) ?></p>
											<p >email : <?= htmlspecialchars($datas['message'][$i]->getEmail()) ?></p>
										</div>
									</div>
									<div class="collapsible-body">
										<span><?= htmlspecialchars($datas['message'][$i]->getTexte()) ?>
										</span>
									</div>
								</li>
								
							</ul>
							<?php	
								
						}
					?>	
					</table>	
					</div>
					<div class="row">											
						<span  class="col m4 s12 offset-m4 center-align  waves-effect waves-light btn-large blue">
							<input type="submit" name="sousAction" value="Mettre à jour"><i class="material-icons left">build</i>
						</span>
					</div>	
				</form>
			</div>
			<?php
		$listeMessageView=ob_get_clean();
		return $listeMessageView;

	}

}
