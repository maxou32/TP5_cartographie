<?php

class Front{
	private $_idfront;
	private $_nom;
	private $_description;
	private $_dateDebut;
	private $_dateFin;
	private $_valide;
	private $_idauteur;
	
	// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
	public function __construct(array $donnees)   {
		$this->hydrate($donnees);   
	} 
  
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// On récupère le nom du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
				
			// Si le setter correspondant existe.
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
	// Liste des getters  
	public function getIdFront()  { return $this->_idfront;}  
	public function getNom()  {return $this->_nom;}  
	public function getDescription()  {return $this->_description;}  
	public function getDateDebut()  {return $this->_dateDebut; }  
	public function getDateFin()  {  return $this->_dateFin;  }  
	public function getValide()  {return $this->_valide;}  
	public function getIdAuteur()  {return $this->_idauteur; }  

	
	// Liste des setters
	public function setIdfront($idfront){
		// On convertit l'argument en nombre entier.
		$idfront = (int) $idfront;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($idfront > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idfront = $idfront;
		}
	}
	  
	public function setZoom($nom){
		// On convertit l'argument en nombre entier.
		$zoom = (int) $zoom;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($zoom > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_zoom = $zoom;
		}
	}
	  
	public function setDateDebut($dateDebut){
		$this->_dateDebut= $dateDebut;
	}
	  
	public function setDateFin($dateFin){

		$this->_dateFin= $dateFin;
	}
	
	public function setValide($valide){
		$this->_valide= $valide;
	}
		
	public function setNom($nom){
		if (is_string($nom))
		{
			$this->_nom= $nom;
		}
	}
	
	public function setDescription($description){
		if (is_string($description))
		{
			$this->_description= $description;
		}
	}
	public function setIdAuteur($idauteur){
		// On convertit l'argument en nombre entier.
		$idauteur = (int) $idauteur;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($idauteur > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idauteur = $idauteur;
		}
	}
	  
}