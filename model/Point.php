<?php

class Point{
	private $_idpoint;
	private $_lat;
	private $_lng;
	private $_idmarqueur;
	private $_idlignefront;
	
	// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
	public function __construct(array $donnees)   {
		$this->hydrate($donnees);   
	} 
  
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// On récupère le lat du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
				
			// Si le setter correspondant existe.
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
	// Liste des getters  
	public function getIdPoint()  { return $this->_idpoint;}  
	public function getLat()  {return $this->_lat;}  
	public function getLng()  {return $this->_lng; }  
	public function getIdMarqueur()  {return $this->_idmarqueur; }  
	public function getIdLigneFront()  {return $this->_idlignefront; }  

	
	// Liste des setters
	public function setIdPoint($idpoint){
		// On convertit l'argument en latbre entier.
		$idpoint = (int) $idpoint;
		// On vérifie ensuite si ce latbre est bien strictement positif.
		if ($idpoint > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idpoint = $idpoint;
		}
	}
	
	public function setLng($lng){
		$this->_lng= $lng;
	}
		
	public function setLat($lat){
		$this->_lat= $lat;
	}
	
	public function setIdMarqueur($idmarqueur){
		// On convertit l'argument en latbre entier.
		$idmarqueur = (int) $idmarqueur;
		// On vérifie ensuite si ce latbre est bien strictement positif.
		if ($idmarqueur > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idmarqueur = $idmarqueur;
		}
	}
	  
	public function setIdLigneFront($idlignefront){
		// On convertit l'argument en latbre entier.
		$idlignefront = (int) $idlignefront;
		// On vérifie ensuite si ce latbre est bien strictement positif.
		if ($idlignefront > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idlignefront= $idlignefront;
		}
	}
	  
	  
}