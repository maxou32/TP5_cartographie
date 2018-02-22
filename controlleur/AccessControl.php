<?php
namespace web_max\ecrivain\controler;
use web_max\ecrivain\lib\Config;
use web_max\ecrivain\model\ChaptersManager;
use web_max\ecrivain\model\UserManager;
use web_max\ecrivain\controler\ErrorController;
use web_max\ecrivain\model\User;
	
class AccessControl {
	public function __construct(){
    
	}
	    /**
     * mise à jour des éléments de session
     * @param object User $user user à stoker
     */
    public function updateSession(User $user){
		$_SESSION['user']=$user->getName();
		$_SESSION['userId']=$user->getIdusers();
		$_SESSION['userPwd']=$user->getPassword();
		$_SESSION['autorizedAccess']=$user->getGrade_IdGrade();
		$_SESSION['email']=$user->getEmail();
		$_SESSION['Grade_IdGrade']=$user->getGrade_IdGrade();
		$_SESSION['Status_IdStatus']=$user->getStatus_IdStatus();
	}
	
     /**
     * Vérification des données de l'utilisateur
     * @param  array $params contient les infos de l'utilisateur à vérifier
     * @return array contenant le résultat et un libellé éventuel d'erreur
     */
	public function validAccessReserved($params){
		//echo"<PRE> COntroller : debut validAccessReserved";print_r($params);echo"</PRE>";
			
		if(isset($params['userName']) && isset($params['userPwd'])) {
			$monUserManager=new UserManager;
			$user=$monUserManager->get($params['userName']);
			if(!$user){
				$monError=new ErrorController();
				$monError->setError(array("origine"=> "web_max\ecrivain\controler\accessControl", "raison"=>"habilitation insuffisante", "numberMessage"=>12));
				return false;
				header ("Location:index.php?askRegistration");
				exit;
			}elseif(hash('sha256',$params['userPwd'])==$user->getPassword()){

				if($user->getStatus_IdStatus() >1){
					$monError=new ErrorController();
					$monError->setError(array("origine"=> "web_max\ecrivain\controler\accessControl", "raison"=>"Inscription non validée", "numberMessage"=>31));
					return false;
				}else{
					$this->updateSession($user);
					return true;
				}
			}else{
				$monError=new ErrorController();
				$monError->setError(array("origine"=> "web_max\ecrivain\controler\accessControl", "raison"=>"mot de passe incorrect", "numberMessage"=>10));
				return false;	
			}
		}else{
			$monError=new ErrorController();
			$monError->setError(array("origine"=> "web_max\ecrivain\controler\accessControl", "numberMessage"=>11));
			//echo "Failed";
			return false;			
		}	
	}
    
    /**
     * Vérification de l'incription de l'utilisateur
     * @param  string $userName [nom de l'itulisateur
     * @return array resultat contenant le résultat et un message
     */
    public function isUnknown($userName){
		$monUserManager=new UserManager;
		$user=$monUserManager->get($userName);
		if(!$user){
			//echo 'existe pas ';
			return array("result"=>true, "message"=>'Vous devez vous incrire au préalable.');						
		}else{
			//echo 'existe oui ';
			return array("result"=>false, "message"=>'Vous êtes déjà inscrit.');			
		}
	}
		
    /**
     * Récupération du profil de l'utilisateur dans la session
     * @return array contenant les données de l'utilisateur
     */
    public function askUpdateProfil(){
		$monUserManager= new UserManager();
		$monUserManager->get($_SESSION['user']);
		$array["userName"]=$_SESSION['user'];
		$array["email"]=$_SESSION['email'];
		$array["action"]="update";
		return $array;
	}
	
    /**
     * Vérification du mot de passe
     * @param  string $password mot de passe saisi
     * @return array resultat contenant le résultat et un message
     */
    public function verifPassword($password){
		$longueur=strlen($password);
		if ($longueur<5) {
			return array("result"=>false, "message"=>'La taille de votre mot de passe est trop faible.');				
		}elseif(preg_match('#^(?=.[a-z])(?=.[A-Z])(?=.[0-9])#',$password)){
			return array("result"=>true,"message"=>"Mot de passe correct");
		}else{
			return array("result"=>false, "message"=>'Votre mot de passe contient des caractères interdits.');				
		}	
	}
	
    /**
     * Fonction de hashage
     * @param  string $password mot de passe
     * @return string mot de passe hashé
     */
    public function hashPassword($password){
		$password=hash('sha256',$password);
		return $password;
	}
    
	/**
	 * Vérification des droits d'accès
	 * @param  integer $requiredLevel Niveau requis
	 * @return boolean  indique si le niveau est suffiant ou pas
	 */
	public function verifAccessRight($requiredLevel){

		$requiredLevel=(INT) $requiredLevel;
		if(!isset($_SESSION['autorizedAccess'])){
			return false;
		}else{
			$userLevel=(INT) $_SESSION['autorizedAccess'];
			$requiredLevel=(INT) $requiredLevel;
			return  $userLevel >= $requiredLevel ;
		}
	}
	
    /**
     * deconnection de l'application
     * @return string deconnexion réalisée
     */
    public function disconnect(){
		//echo "accessCONTROL : disconnect";
		// On le vide intégralement
		$_SESSION = array();
		// Destruction de la session
		session_destroy();
		// Destruction du tableau de session
		unset($_SESSION);
		return "Disconnect OK";
	}

}				