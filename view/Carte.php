<?php

class Carte{
	private $_idcarte;
	private $_zoom;
	private $_lat;
	private $_lng;
	private $_projection;
	private $_layeroption;
	private $_nom;
	private $_idfront;
	
	// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
	public function __construct(array $donnees)   {
		$this->hydrate($donnees);   
	} 
  
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// On récupère le zoom du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
				
			// Si le setter correspondant existe.
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
	// Liste des getters  
	public function getIdCartes()  { return $this->_idcarte;}  
	public function getZoom()  {return $this->_zoom;}  
	public function getLat()  {return $this->_lat; }  
	public function getLng()  {  return $this->_lng;  }  
	public function getProjection()  {return $this->_projection;}  
	public function getLayerOption()  {return $this->_layeroption; }  
	public function getNom()  {  return $this->_nom;  }  
	public function getIdFront()  {  return $this->_idfront;  }  

	
	// Liste des setters
	public function setIdcarte($idcarte){
		// On convertit l'argument en zoombre entier.
		$idcarte = (int) $idcarte;
		// On vérifie ensuite si ce zoombre est bien strictement positif.
		if ($idcarte > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idcarte = $idcarte;
		}
	}
	  
	public function setZoom($zoom){
		if (is_string($zoom))
		{
			$this->_zoom= $zoom;
		}
	}
	  
	public function setLat($lat){
		$this->_lat= $lat;
	}
	  
	public function setlng($lng){

		$this->_lng= $lng;
	}
	
	public function setProjection($projection){
		if (is_string($projection))
		{
			$this->_projection= $projection;
		}
	}
		
	public function setNom($nom){
		if (is_string($nom))
		{
			$this->_nom= $nom;
		}
	}
	public function setIdfront($idfront){
		// On convertit l'argument en zoombre entier.
		$idfront = (int) $idfront;
		// On vérifie ensuite si ce zoombre est bien strictement positif.
		if ($idfront > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idfront = $idfront;
		}
	}
	  
}