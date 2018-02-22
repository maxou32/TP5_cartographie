<?php
class View
{

    protected $template;
    protected $params;
	protected $userName;
	protected $menuView;
	protected $contentView;
	protected $footerView;
	protected $avecParam;
	protected $captionMessage;
	protected $message;
	protected $imageBackGround;
	
    public function __construct(){
        $this->template = "";
		$this->userName="";
		$this->menuView="";
		$this->footerView="";
		
    }
	
	public function setMenuView($menuView){
		$this->menuView=$menuView;
		return true;
	}
		
	protected function renderBottom(){	
		$monFooterView = new _footerView(NULL);
		return $monFooterView->show(NULL);
    }
	
	public function montre($datas){
		//echo "<br /> montre de View";
		$menuView=$this->menuView;
		$footerView=$this->renderBottom();
		$contentView=$this->show(Null);
		$monTemplate= new template($menuView,$footerView,$contentView);
		$monTemplate->show(null);
	}
	
}