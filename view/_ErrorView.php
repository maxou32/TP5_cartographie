<?php 
	
class _ErrorView {	
	private $leMessage;
	private $laRaison;
	
	public function __construct(){
	}
	
	public function hasError(){
		$monError=new ControlleurErreur();
		//ECHO "ERROR VIEW 0";
		if ($monError->getExisteError()) {
			$this->leMessage=$monError->getLibelleError();
			$this->laRaison=$monError->getRaisonError();
			$monError->deleteError();
			return true;
		}
		
	}
	
	
	public function show(){

		ob_start(); 
		?>
		<script type="text/javascript">
			$(document).ready(function(e){
				$('#modal1').css({visibility: 'visible',display:'inline-block'});
				setTimeout(function(){
				  $('#modal1').css({visibility: 'hidden',display:'none'});;
				}, 4000);
			});
			
	
		</script>

		<div id="modal1" class="modal card-panel hoverable">
			<div class="modal-content orange lighten-5">
				<h5><i class="material-icons">info</i>  <?php echo ($this->laRaison) ?></h5>
				<div class="divider"></div>
				<p><?php echo ($this->leMessage) ?></p>
			</div>
			<div class="progress orange lighten-5">
				<div class="indeterminate"></div>
			</div>
		</div>
			

		<?php
		$errorView=ob_get_clean();
		return $errorView;
	}
	

}
