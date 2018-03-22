<?php

class Message{
	private $_idmessage;
	private $_nom;
	private $_prenom;
	private $_email;
	private $_objet;
	private $_texte;
	private $_datemessage;
	private $_lu;
	
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
	public function getIdMessage()  { return $this->_idmessage;}  
	public function getNom()  {return $this->_nom;}  
	public function getPrenom()  {return $this->_prenom; }  
	public function getEmail()  {  return $this->_email;  }  
	public function getObjet()  {  return $this->_objet;  }  
	public function getTexte()  {    return $this->_texte;  }
	public function getLu(){ return $this->_lu;}
	public function getDateMessage(){ return $this->_datemessage;}

	// Liste des setters

	public function setIdMessage($idmessage){
		// On convertit l'argument en nombre entier.
		$idmessage = (int) $idmessage;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($idmessage > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idmessage = $idmessage;
		}
	}
	  
	public function setNom($nom){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($nom))
		{
			$this->_nom= $nom;
		}
	}
	  
	public function setPrenom($prenom){
	   
	  if (is_string($prenom))	{
			$this->_prenom= $prenom;
		}
	}
	  
	public function setEmail($email){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($email))
		{
			$this->_email= $email;
		}
	}
	
	public function setObjet($objet){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($objet))
		{
			$this->_objet= $objet;
		}
	}
		
	public function setTexte($texte){
		if (is_string($texte) )
		{
			$this->_texte= $texte;
		}
	}
	public function setDateMessage($datemessage){
		$this->_datemessage = $datemessage;
	}
	public function setLu($lu){
		// On convertit l'argument en nombre entier.
		$lu = (bool) $lu;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($lu > 0){
		  // Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_lu = $lu;
		}
	}
	
}