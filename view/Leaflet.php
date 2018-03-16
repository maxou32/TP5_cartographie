<?php 

class LeafLet extends View
{	
	public function __construct(){ 
		
	}

	
	public function show($datas){
		//echo "<pre>";print_r($datas);echo"</pre>";
		ob_start(); 
		
		include ('leafletNew.php');
		
			
		return ob_get_clean();
	}
}