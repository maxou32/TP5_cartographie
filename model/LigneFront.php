<?php

class LigneFront{
	private $_idlignefront;
	private $_couleur;
	private $_type;
	private $_valide;
	private $_iddatefront;
	private $_idcontributeurfront;
	
	// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
	public function __construct(array $donnees)   {
		$this->hydrate($donnees);   
	} 
  
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// On récupère le couleur du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
				
			// Si le setter correspondant existe.
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
	// Liste des getters  
	public function getIdligneFront()  { return $this->_idlignefront;}  
	public function getCouleur()  {return $this->_couleur;}  
	public function getType()  {return $this->_type;}  
	public function getValide()  {return $this->_valide;}  
	public function getIddatefront()  {return $this->_iddatefront; }  
	public function getIdcontributeurfront()  {return $this->_idcontributeurfront; }  

	
	// Liste des setters
	public function setIdLigneFront($idlignefront){
		// On convertit l'argument en couleurbre entier.
		$idlignefront = (int) $idlignefront;
		// On vérifie ensuite si ce couleurbre est bien strictement positif.
		if ($idlignefront > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idlignefront = $idlignefront;
		}
	}
	
	public function setValide($valide){
		$this->_valide= $valide;
	}
		
	public function setCouleur($couleur){
		if (is_string($couleur))
		{
			$this->_couleur= $couleur;
		}
	}
		
	public function setType($type){

			$this->_type= $type;
	}
	
	public function setIddatefront($iddatefront){
		// On convertit l'argument en couleurbre entier.
		$iddatefront = (int) $iddatefront;
		// On vérifie ensuite si ce couleurbre est bien strictement positif.
		if ($iddatefront > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_iddatefront = $iddatefront;
		}
	}
	  
	public function setIdcontributeurfront($idcontributeurfront){
		// On convertit l'argument en couleurbre entier.
		$idcontributeurfront = (int) $idcontributeurfront;
		// On vérifie ensuite si ce couleurbre est bien strictement positif.
		if ($idcontributeurfront > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idcontributeurfront= $idcontributeurfront;
		}
	}
	  
	  
}