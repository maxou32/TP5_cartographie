<?php

class Marqueur{
	private $_idmarqueur;
	private $_couleur;
	private $_libelle;
	private $_icone;
	
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
	public function getIdMarqueur()  { return $this->_idmarqueur;}  
	public function getCouleur()  {return $this->_couleur;}  
	public function getLibelle()  {return $this->_libelle; }  
	public function getIcone()  {return $this->_icone; }  

	
	// Liste des setters
	public function setIdMarqueur($idmarqueur){
		// On convertit l'argument en couleurbre entier.
		$idmarqueur = (int) $idmarqueur;
		// On vérifie ensuite si ce couleurbre est bien strictement positif.
		if ($idmarqueur > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idmarqueur = $idmarqueur;
		}
	}
	
	public function setLibelle($libelle){
		$this->_libelle= $libelle;
	}
		
	public function setCouleur($couleur){
		$this->_couleur= $couleur;
	}
	
	 
	public function setIcone($idicone){
		$this->_idicone= $idicone;
	}
	  
	  
}