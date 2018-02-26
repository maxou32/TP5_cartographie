<?php

class DatesFront{
	private $_iddate;
	private $_description;
	private $_valide;
	private $_numordre;
	private $_date;
	private $_idfront;
	
	// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
	public function __construct(array $donnees)   {
		$this->hydrate($donnees);   
	} 
  
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// On récupère le description du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
				
			// Si le setter correspondant existe.
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
	// Liste des getters  
	public function getIddate()  { return $this->_iddate;}  
	public function getDescription()  {return $this->_description;}  
	public function getValide()  {return $this->_valide; }  
	public function getNumordre()  {  return $this->_numordre;  }  
	public function getDate()  {return $this->_date;}  
	public function getIdFront()  {  return $this->_idfront;  }  

	
	// Liste des setters
	public function setIddate($iddate){
		// On convertit l'argument en descriptionbre entier.
		$iddate = (int) $iddate;
		// On vérifie ensuite si ce descriptionbre est bien strictement positif.
		if ($iddate > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_iddate = $iddate;
		}
	}
	  
	public function setDescription($description){
		if (is_string($description))
		{
			$this->_description= $description;
		}
	}
	  
	public function setValide($valide){
		$this->_valide= $valide;
	}
	  
	public function setNumordre($numordre){

		$this->_numordre= $numordre;
	}
	
	public function setDate($date){
		if (is_string($date))
		{
			$this->_date= $date;
		}
	}
	
	public function setIdfront($idfront){
		// On convertit l'argument en descriptionbre entier.
		$idfront = (int) $idfront;
		// On vérifie ensuite si ce descriptionbre est bien strictement positif.
		if ($idfront > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idfront = $idfront;
		}
	}
	  
}