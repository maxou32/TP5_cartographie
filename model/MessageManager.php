<?php

class MessageManager extends Manager{

	public function __construct(){
		
	}

	public function add(Message $message)  {
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'message(nom, prenom, email, objet, texte, lu, datemessage) VALUES(:nom, :prenom, :email, :objet, :texte, :lu, now())');

			$q->bindValue(':nom', $message->getNom(), PDO::PARAM_STR);
			$q->bindValue(':prenom', $message->getPrenom(), PDO::PARAM_STR);
			$q->bindValue(':email', $message->getEmail(), PDO::PARAM_STR);
			$q->bindValue(':objet', $message->getObjet(), PDO::PARAM_STR);
			$q->bindValue(':texte', $message->getTexte(), PDO::PARAM_INT);
			$q->bindValue(':lu', $message->getLu(), PDO::PARAM_INT);
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			echo "MessageManager : <pre>";print_r($e->getMessage());echo"</pre>";
			return 'Erreur : '.$e->getMessage();
		}	;	
	}

	public function delete($idmessage)  {
		try{
			$idmessage = (int) $idmessage;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'message WHERE idmessage = '.$idmessage);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($nom)  {
		try{
			$q = $this->dbConnect()->prepare('SELECT idmessage, nom,  prenom, email, objet, texte, datemessage, lu FROM '.$this->prefix.'message WHERE nom = :nom');
			$q->bindValue(':nom', $nom, PDO::PARAM_STR);
			$q->execute();	
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new Message($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListValid()  {
		try{
			$messages = [];
			$q = $this->dbConnect()->query('SELECT idmessage, nom, prenom, email, texte, datemessage, lu FROM '.$this->prefix.'message WHERE status="valide" ORDER BY nom, prenom ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$messages[] = new Message($donnees);
			}

			return $messages;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}
	

	public function getListAll()  {
		try{
			$messages = [];
			$q = $this->dbConnect()->query('SELECT idmessage, nom, prenom, email, texte, datemessage, lu FROM '.$this->prefix.'message ORDER BY nom, prenom ASC ');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$messages[] = new Message($donnees);
			}
			return $messages;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(Message $message)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'message SET nom = :nom, prenom = :prenom,  texte= :texte, datemessage = :datemessage, email = :email, objet = :objet, status = :status, lu= :lu WHERE idmessage = :idmessage');

			$q->bindValue(':idmessage', $message->getIdmessage(), \PDO::PARAM_INT);
			$q->bindValue(':nom', $message->getNom(), \PDO::PARAM_STR);
			$q->bindValue(':prenom', $message->getPrenom(), \PDO::PARAM_STR);
			$q->bindValue(':datemessage', $message->getDatecreation(), \PDO::PARAM_STR);
			$q->bindValue(':texte', $message->getIdtexte(), \PDO::PARAM_STR);
			$q->bindValue(':email', $message->getEmail(), \PDO::PARAM_STR);
			$q->bindValue(':objet', $message->getObjet(), \PDO::PARAM_STR);
			$q->bindValue(':lu', $message->getIdNiveau(), \PDO::PARAM_BOLL);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}	
	
	public function updateLu(Message $message)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'message SET  lu= :lu WHERE idmessage = :idmessage');

			$q->bindValue(':idmessage', $message->getIdmessage(), \PDO::PARAM_INT);
			$q->bindValue(':lu', $message->getIdNiveau(), \PDO::PARAM_BOLL);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}
		
	

}