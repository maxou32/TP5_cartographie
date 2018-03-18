<?php

	
class ControlleurAccess {
	public function __construct(){
    
	}
	/**
     * mise à jour des éléments de session
     * @param object User $user user à stoker
     */
    public function updateSession(Abonne $abonne){
		//echo "enreg session";
		$_SESSION['nom']=$abonne->getNom();
		$_SESSION['IdAbonne']=$abonne->getIdAbonne();
		$_SESSION['mdp']=$abonne->getMdp();
		$_SESSION['autorizedAccess']=$abonne->getIdNiveau();
		$_SESSION['email']=$abonne->getEmail();
		$_SESSION['niveau']=$abonne->getIdNiveau();
		$_SESSION['Status']=$abonne->getStatus();
		//echo"<PRE> COntrollerACCESS : fin upDateSession";print_r($_SESSION);echo"</PRE>";
		
	}
	
     /**
     * Vérification des données de l'utilisateur
     * @param  array $params contient les infos de l'utilisateur à vérifier
     * @return array contenant le résultat et un libellé éventuel d'erreur
     */
	public function validAccesReserve($params){
		//echo"<PRE> COntroller : debut validAccessReserved <br/>";print_r($params);echo"</PRE>";
			
		if(isset($params['userName']) && isset($params['userPwd'])) {
			$monAbonneManager=new AbonneManager;
			$abonne=$monAbonneManager->get($params['userName']);
			//echo"<PRE> COntroller :  validAccessReserved abonne <br/>";print_r($abonne);echo"</PRE>";
			if(!$abonne){
				//echo"<PRE> COntroller : validAccessReserved inconnu";echo"</PRE>";
				$monError=new ControlleurErreur();
				$monError->setError(array("origine"=> CONTROLLEUR."ControllerAccess", "raison"=>"habilitation insuffisante", "numberMessage"=>12));
				header ("Location:?action=accesreserve.html/classe/AccesReserveView/action/show");
			}elseif(hash('sha256',$params['userPwd'])=== $abonne->getMdp()){

				if($abonne->getStatus() !== 'valide'){
					//echo"<PRE> COntroller : validAccessReserved non valide";echo"</PRE>";
					$monError=new ControlleurErreur();
					$monError->setError(array("origine"=> CONTROLLEUR."ControllerAccess", "raison"=>"Inscription non validée", "numberMessage"=>31));
					header ("Location:?action=accesreserve.html/classe/AccesReserveView/action/show");
				}else{
					//echo"<PRE> COntroller : validAccessReserved okay";echo"</PRE>";
					$this->updateSession($abonne);
					header ("Location:?action=leaflet2.html");				
				}
			}else{
				//echo"<PRE> COntroller :  validAccessReserved mdp faux";print_r($abonne);echo"</PRE>";
				$monError=new ControlleurErreur();
				$monError->setError(array("origine"=> CONTROLLEUR."ControllerAccess", "raison"=>"mot de passe incorrect", "numberMessage"=>10));
				header ("Location:?action=accesreserve.html/classe/AccesReserveView/action/show");	
			}
		}else{
			$monError=new ControlleurErreur();
			$monError->setError(array("origine"=> CONTROLLEUR."ControllerAccess", "numberMessage"=>11));
			//header ("Location:?action=accesreserve.html/classe/AccesReserveView/action/show");			
		}	
	}
    
    /**
     * Vérification de l'incription de l'utilisateur
     * @param  string $userName [nom de l'itulisateur
     * @return array resultat contenant le résultat et un message
     */
    public function estConnu($nom){
		//echo "Controlleur Acces est Connu";
		$monAbonneManager=new AbonneManager;
		$abonne=$monAbonneManager->get($nom);
		return !$abonne ? false :true ;
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
    public function sortirAccesReserve(){
		//echo "accessCONTROL : disconnect";
		// On le vide intégralement
		$_SESSION = array();
		// Destruction de la session
		session_destroy();
		// Destruction du tableau de session
		unset($_SESSION);
		header ("Location:?action=accueil.html");
	}

}				