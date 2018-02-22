<?php

class Abonne{
	private $_idabonne;
	private $_nom;
	private $_prenom;
	private $_email;
	private $_mdp;
	private $_idavatar;
	private $_idniveau;
	private $_datecreation;
	private $_status;
	
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
	public function getIdAbonne()  { return $this->_idabonne;}  
	public function getNom()  {return $this->_nom;}  
	public function getPrenom()  {return $this->_prenom; }  
	public function getEmail()  {  return $this->_email;  }  
	public function getMdp()  {  return $this->_mdp;  }  
	public function getIdAvatar()  {    return $this->_idavatar;  }
	public function getDateCreation(){ return $this->_datecreation;}
	public function getIdNiveau(){ return $this->_idniveau;}
	public function getStatus(){ return $this->_status;}

	// Liste des setters

	public function setidabonne($idabonne){
		// On convertit l'argument en nombre entier.
		$idabonne = (int) $idabonne;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($idabonne > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idabonne = $idabonne;
		}
	}
	  
	public function setnom($nom){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($nom))
		{
			$this->_nom= $nom;
		}
	}
	  
	public function setprenom($prenom){
	   
	  if (is_string($prenom))	{
			$this->_prenom= $prenom;
		}
	}
	  
	public function setemail($email){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($email))
		{
			$this->_email= $email;
		}
	}
	
	public function setmdp($mdp){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($mdp))
		{
			$this->_mdp= $mdp;
		}
	}
		
	public function setidavatar($idavatar){
		if ($idavatar >= 0 )
		{
			$this->_idavatar= $idavatar;
		}
	}
	public function setidniveau($idniveau){
		// On convertit l'argument en nombre entier.
		$idniveau = (int) $idniveau;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($idniveau > 0){
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_idniveau = $idniveau;
		}
	}
	public function setdateCreation($dateCreation){
		// On convertit l'argument en nombre entier.
		$dateCreation = (int) $dateCreation;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($dateCreation > 0){
		  // Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_datecreation = $dateCreation;
		}
	}
	
	public function setStatus($status){
		if (is_string($status))
		{
			$this->_status = $status;
		}
	}

}