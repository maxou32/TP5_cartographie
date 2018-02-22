<?php

class AbonneManager extends Manager{

	public function __construct(){
		
	}

	public function add(Abonne $abonne)  {
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'abonne(nom, prenom, email, mdp, idavatar,  status, datecreation, idniveau) VALUES(:nom, :prenom, :email, :mdp, :idavatar, :status, now(), :idniveau)');

			$q->bindValue(':nom', $abonne->getNom(), PDO::PARAM_STR);
			//$q->bindValue(':datecreation', $abonne->getDatecreation(), \PDO::PARAM_INT);
			$q->bindValue(':prenom', $abonne->getPrenom(), PDO::PARAM_STR);
			$q->bindValue(':email', $abonne->getEmail(), PDO::PARAM_STR);
			$q->bindValue(':mdp', $abonne->getMdp(), PDO::PARAM_STR);
			$q->bindValue(':idavatar', $abonne->getIdAvatar(), PDO::PARAM_INT);
			$q->bindValue(':status', $abonne->getStatus(), PDO::PARAM_INT);
			$q->bindValue(':idniveau', $abonne->getIdNiveau(), PDO::PARAM_INT);
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			echo "AbonneManager : <pre>";print_r($e->getMessage());echo"</pre>";
			return 'Erreur : '.$e->getMessage();
		}	;	
	}

	public function delete($idabonne)  {
		try{
			$idabonne = (int) $idabonne;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'abonne WHERE idabonne = '.$idabonne);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($nom)  {
		try{
			$q = $this->dbConnect()->prepare('SELECT idabonne, nom,  prenom, email, mdp, idavatar, status, datecreation, idniveau FROM '.$this->prefix.'abonne WHERE nom = :nom');
			$q->bindValue(':nom', $nom, PDO::PARAM_STR);
			$q->execute();	
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new Abonne($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListValid()  {
		try{
			$abonnes = [];
			$q = $this->dbConnect()->query('SELECT idabonne, nom, prenom, email, idavatar,status, datecreation, idniveau FROM '.$this->prefix.'abonne WHERE status="valide" ORDER BY nom, prenom ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$abonnes[] = new Abonne($donnees);
			}

			return $abonnes;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}
	

	public function getListAll()  {
		try{
			$abonnes = [];
			$q = $this->dbConnect()->query('SELECT idabonne, nom, prenom, email, idavatar,status, datecreation, idniveau FROM '.$this->prefix.'abonne ORDER BY nom, prenom ASC ');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$abonnes[] = new Abonne($donnees);
			}
			return $abonnes;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(Abonne $abonne)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'abonne SET nom = :nom, prenom = :prenom,  idavatar= :idavatar, datecreation = :datecreation, email = :email, mdp = :mdp, status = :status, idniveau= :idniveau WHERE idabonne = :idabonne');

			$q->bindValue(':idabonne', $abonne->getIdabonne(), \PDO::PARAM_INT);
			$q->bindValue(':nom', $abonne->getNom(), \PDO::PARAM_STR);
			$q->bindValue(':prenom', $abonne->getPrenom(), \PDO::PARAM_STR);
			$q->bindValue(':datecreation', $abonne->getDatecreation(), \PDO::PARAM_INT);
			$q->bindValue(':status', $abonne->getStatus(), \PDO::PARAM_STR);
			$q->bindValue(':idavatar', $abonne->getIdavatar(), \PDO::PARAM_INT);
			$q->bindValue(':email', $abonne->getEmail(), \PDO::PARAM_STR);
			$q->bindValue(':mdp', $abonne->getMdp(), \PDO::PARAM_STR);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}
		
	public function getNbAbonneValide()  {
		try{
			$abonnes = [];
			$q = $this->dbConnect()->query('SELECT  COUNT(*) as nbAbonne FROM '.$this->prefix.'abonne WHERE status="valide" ');
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			return $donnees;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

}