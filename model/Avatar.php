<?php

class Avatar{
	private $_idavatar;
	private $_nom;
	private $_urlimage;
	private $_typemarque;
	
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
	public function getIdAvatars()  { return $this->_idavatar;}  
	public function getNom()  {return $this->_nom;}  
	public function getUrlImage()  {return $this->_urlimage; }  
	public function getTypeMarque()  {  return $this->_typemarque;  }  
	
	// Liste des setters

	public function setIdavatar($idavatar){
		// On convertit l'argument en nombre entier.
		$idavatar = (int) $idavatar;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($idavatar > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idavatar = $idavatar;
		}
	}
	  
	public function setNom($nom){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($nom))
		{
			$this->_nom= $nom;
		}
	}
	  
	public function setUrlimage($urlimage){
	   
	   $urlimage = (int) $urlimage;
		if ($urlimage >0)		{
			$this->_urlimage= $urlimage;
		}
	}
	  
	public function setTypemarque($typemarque){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($typemarque))
		{
			$this->_typemarque= $typemarque;
		}
	}
}