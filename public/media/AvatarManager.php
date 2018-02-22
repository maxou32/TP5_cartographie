<?php
 
class AvatarManager extends Manager{
	
	public function __construct(){
		
	}

	public function add(Avatar $avatar)  {
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'avatar(nom, urlimage, typemarque) VALUES(:nom, :urlimage, :typemarque)');

			$q->bindValue(':nom', $avatar->getnom(), \PDO::PARAM_STR);
			$q->bindValue(':typemarque', $avatar->gettypemarque(), \PDO::PARAM_STR);
			$q->bindValue(':urlimage', $avatar->geturlimage(), \PDO::PARAM_STR);
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;	
	}

	public function delete($idavatar)  {
		try{
			$idavatar = (int) $idavatar;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'avatar WHERE idavatar = '.$idavatar);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($idavatar)  {
		try{
			$idavatar = (int) $idavatar;
			$q = $this->dbConnect()->query('SELECT idavatar, nom,  urlimage, typemarque FROM '.$this->prefix.'avatar WHERE idavatar = '.$idavatar);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new Avatar($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListAll()  {
		try{
			$avatar = [];
			$q = $this->dbConnect()->query('SELECT idavatar, nom, urlimage, typemarque FROM '.$this->prefix.'avatar ORDER BY nom ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$avatar[] = new Avatar($donnees);
			}

			return $avatar;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(Avatar $avatar)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'avatar SET nom = :nom, urlimage = :urlimage, typemarque = :typemarque WHERE idavatar = :idavatar');

			$q->bindValue(':idavatar', $avatar->getIdavatar(), \PDO::PARAM_INT);
			$q->bindValue(':nom', $avatar->getnom(), \PDO::PARAM_STR);
			$q->bindValue(':typemarque', $avatar->gettypemarque(), \PDO::PARAM_STR);
			$q->bindValue(':urlimage', $avatar->geturlimage(), \PDO::PARAM_STR);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	
	public function getNbAvatar()  {
		try{
			$avatar = [];
			$q = $this->dbConnect()->query('SELECT  COUNT(*) as nbAvatar FROM '.$this->prefix.'avatar WHERE typemarque ="avatar" ');
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			return $donnees;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}
	
	public function getNbMarqueur()  {
		try{
			$avatar = [];
			$q = $this->dbConnect()->query('SELECT  COUNT(*) as nbAvatar FROM '.$this->prefix.'avatar WHERE typemarque ="marqueur" ');
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			return $donnees;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

}