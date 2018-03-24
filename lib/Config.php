<?php
 
// show errors if not in php.ini
//ini_set('display_errors','on');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

/**
*  Classe exploitant le fichier de config
*
*/
class Config{
	
	private $_data;
	
	/**
	 * ouverture du fichier de configuration 
	 * @private
	 */
	public function __construct()   {
		//echo "CONFIG construct<br/>";
		require_once "Spyc.php";
		$this->data = \Spyc::YAMLLoad('lib/config.yaml');
		$this->data['param'] = \Spyc::YAMLLoad('lib/param.yaml');
		$this->data['secu'] = \Spyc::YAMLLoad('lib/secu.yaml');
	}
	
    /**
     * Donne le login d'accès à la base de données
     * @return string nom de l'utilisateur
     */
    public function getLogin(){
		return $this->data['secu']["login"];
	}
	
	   /**
     * Donne le login d'accès à la base de données
     * @return string nom de l'utilisateur
     */
    public function getHost(){
		return $this->data['secu']["serveur"];
	}
	
    /**
     * donne le mot de passe d'accès à la base de données
     * @return string mot de passe
     */
    public function getPassword(){
		return $this->data['secu']["password"];
	}
	/**
     * donne les couleurs à employer
     * @return array des couleurs
     */
    public function getCouleur(){
		return $this->data['param']['style'];
	}
	/**
     * donne les propriétés de la carte
     * @return array des propriétés
     */	
	public function getProprieteLeaflet(){
		$resultat['zoom']= $this->data['param']['carte']['zoom'];
		$resultat['latCentre']= $this->data['param']['carte']['latCentre'];
		$resultat['lngCentre']= $this->data['param']['carte']['lngCentre'];
		$resultat['maxZoom']= $this->data['param']['carte']['maxZoom'];
		$resultat['boxZoom']= $this->data['param']['carte']['boxZoom'];
		$resultat['tileSize']= $this->data['param']['carte']['tileSize'];
		$resultat['attribution']= $this->data['param']['carte']['attribution'];
		$resultat['layer1']= $this->data['param']['carte']['layer1'];
		$resultat['layer2']= $this->data['param']['carte']['layer2'];
		$resultat['synchrone']= $this->data['param']['ajax']['synchrone'];
		return $resultat;
	}
    /**
     * donne le mot de passe d'accès à la base de données
     * @return string mot de passe
     */
    public function getPrefixe(){
		if($this->data['secu']["avecPrefixe"]){
			return $this->data['secu']["prefixe"];
		}else{
			return Null;
		}
	}

    /**
     * donne la chaîne de connexion
     * @return string connexion à la base de donnees
     */
    public function getConnect(){
		$connect='mysql:host='. $this->data['secu']["serveur"].';dbname='. $this->data['secu']["nom"];
		return $connect;
	}
	
    
	/**
     * donne l'adresse mail du site
     * @return string adresse mail
     */
    public function getMail(){
		return $this->data['secu']["mail"];
	}
    
	/**
		 * donne le chemin du fichier json
		 * @return string 
     */
	public function getFichierJSON(){
		return $this->data['secu']["frontJSON"];
	}
	
	
	/**
	 * recherche les éléments de la route demandée
	 * @param  string $theRoad nom de la route recherchée
	 * @return array  tableau avec les caractéristiques de la route
	 */
	public function getRoad($theRoad){
		try{
			if(isset($this->data[$theRoad])){
				return $this->data[$theRoad];
			}
		}catch(Exception $e){
			return false;
		}
	}
}			