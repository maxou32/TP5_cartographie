<?php 

	
class AdminFrontView extends View{	
	public function __construct(){
		
	}

	public function show($datas){		
		//echo"<pre>";print_r($datas);echo"</pre>";
		ob_start(); 
		
		?>
		<script>
			function changeValide($front, $valide) {
				document.getElementById("action"+$front).checked=true;
				document.getElementById($front).value=$valide;
			}
			function detruit($front) {
				document.getElementById("action"+$front).checked=true;
			}
		</script>
		<div class="row">
			<div class="card-panel col s12 m8 offset-m2">
				<form method="post" action="?action=validfront">
						
					<div>
					<?php
					for($i=0;$i<count($datas['front']);$i++)
					{
						?>
						<div class="row card-panel orange lighten-5">
							<h5 class="center"><?= htmlspecialchars($datas['front'][$i]->getNom()) ?></h5>
							<div class="col m6 s12">
								<p id="content"><?= htmlspecialchars($datas['front'][$i]->getDescription()) ?> </p>
							</div>
							<div class="left-align col m6 s12">
								<div class="left-align col m6 s12">
									<div class="left-align">
										<?php
											foreach ($datas['valide'] as $key => $value){
												?>
											<input name="<?= "V".htmlspecialchars($datas['front'][$i]->getIdfront()) ?>" type="radio" 
												id="<?="validefronts".htmlspecialchars($datas['front'][$i]->getIdfront()).$key ?>" 
												<?php 
												if(strval(htmlspecialchars($datas['front'][$i]->getValide())) === strval($key)){
													echo "checked";
												}
												?> onClick='javascript:changeValide("<?= htmlspecialchars($datas['front'][$i]->getIdfront()) ?>","<?=$key ?>")' value="<?= $key ?>" /> 
											<label for="<?="validefronts".htmlspecialchars($datas['front'][$i]->getIdfront()).$key ?>"><?= $value ?></label>
											<?php
											}
										?>
										<br/>
									</div>
								</div>
							
								<div class="row">
									<input  type="checkbox" name="actionAFaire[]" id="<?= "action".$datas['front'][$i]->getIdFront() ?>" value="<?= $datas['front'][$i]->getIdFront() ?>" />	
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

		return $contentView;
	}
}	


		
		