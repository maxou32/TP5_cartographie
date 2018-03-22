<?php 

class ParamView extends View
{	
	public function __construct(){
	}

	
	public function show($datas){
		//echo "debut controlleur carte-> execute carte<pre>";print_r($datas);echo"</pre>";
		ob_start();
			?>
			<script language="javascript" type="text/javascript">
				function changeParam($key) {
					document.getElementById("action"+$key).checked=true;
				}

			</script>
			<div class="row">
				<form method="post" action="?action=validparam" class="col m10 offset-m1 s12" >
					<div class ="col m6 s12">
					<table class="highlight centered">
						<thead>
							<tr>
								<th>Variables</th>
								<th>Valeurs</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								//for ($i=0; $i < count($datas); $i++){
								foreach ($datas['carte'] as $key => $value){
									?>
									<tr>
										<td><?= htmlspecialchars($key) ?> </td>
										<td>
											<input 	type="text" 
													id=<?="carte".htmlspecialchars($key) ?><?= htmlspecialchars($value) ?> 
													value="<?= htmlspecialchars($value) ?>">
											<input type="checkbox" name="actionAFaire[]" 
													type="checkbox" 
													id="<?= "action".htmlspecialchars($key) ?>" 
													value="<?= htmlspecialchars($key) ?>"
													onClick='javascript:changeParam("<?= htmlspecialchars($key) ?>")' />												
									
										</td>
									</tr>
									<?php							
								}
							?>
						</tbody>
					</table>
					</div>
					<div class = "col m6 s12">
						<table class="highlight centered">
							<thead>
								<tr>
									<th>Variable</th>
									<th>Valeur</th>
							  </tr>
							</thead>
							<tbody>
								<?php 
									//for ($i=0; $i < count($datas); $i++){
									foreach ($datas['style'] as $key => $value){
										?>
										<tr>
											<td><?= htmlspecialchars($key) ?> </td>
											<td>
												<input type="text" id="<?="style".htmlspecialchars($key) ?><?= htmlspecialchars($value) ?>"  value="<?= htmlspecialchars($value) ?>">
											</td>
									</tr>
										<?php							
									}
								?>
							</tbody>
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
		$paramView=ob_get_clean();
		return $paramView;

	}

}
