<?php 
	
class _FooterFreeView extends View
{	

	public function __construct(){
		
	}
	
	public function show($datas){
		ob_start(); 
		?>
			<footer id="footer" class="page-footer <?= $datas['style']['couleurFondLibre'] ?>  darken-1 <?= $datas['style']['couleurTexteLibre'] ?> darken-text-5 ">
				<div class="row row_footer">
					<div class="col l6 s12">
						<p ></p>
					</div>
					<div class="col l4 offset-l2 s12">
						<a class=" right" href="http://web-max.fr">© 2017 Copyright Web-Max</a>
					</div>
				</div>
			</footer>
		<?php
		return ob_get_clean(); 
	}
	
}