<?php


class Manager{
	protected $maConfig;
	protected $prefix;

public function __construct(){
	

}	
	
    protected function dbConnect()
    {
		try
		{
			$this->maConfig = new Config();
			$this->prefix	= $this->maConfig->getPrefixe();
			$db = new \PDO($this->maConfig->getConnect(), $this->maConfig->getLogin(), $this->maConfig->getPassword());
			$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $db;
		}
		catch (PDOException $e)
		{
			$monError=new ErrorController();
			$monError->setError(array("origine"=> LIB."router/router", "raison"=>"Accès aux données", "numberMessage"=>60));		
			header('Location: index.php');	
			exit;
		}
    }
}