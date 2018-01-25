<?php
class View{
	protected $cible
	
	public function __construct($cible){
		$this->cible=$cible;
	}
	
	public function render(){
		ob_start();
		include (VIEW.$this->cible.'.php');
		$content= ob_get_clean();
		include (VIEW."_template.php");
		
		echo $content;
	}
}