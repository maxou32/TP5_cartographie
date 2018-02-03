<?php
class View{
	protected $cible;
	
	public function __construct($cible){
		$this->cible=$cible;
	}
	
	public function render(){
		
		$tiny=REPPUBLIC."js/tinymce/tinymce.min.js";
		//echo"<br />View: <pre>";print_r($tiny);echo"</pre>";
		//echo "<br />view : '".$tiny."'";
		ob_start();
		include (VIEW.$this->cible.'.php');
		$content= ob_get_clean();
		include (VIEW."_template.php");
		
		//echo $content;
	}
}