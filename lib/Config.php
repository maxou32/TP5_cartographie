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