<?php
 
class FrontManager extends Manager{

	public function __construct(){
		
	}

	public function add(Front $front)  {
		$result=[];
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'front(nom,  description, dateDebut, dateFin, valide, idauteur) VALUES(:nom, :description, :dateDebut, :dateFin, :valide, :idauteur)');
			
			$q->bindValue(':dateDebut', $front->getDateDebut(), \PDO::PARAM_STR);
			$q->bindValue(':dateFin', $front->getDateFin(), \PDO::PARAM_STR);
			$q->bindValue(':valide', $front->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':nom', $front->getNom(), \PDO::PARAM_STR);
			$q->bindValue(':description', $front->getDescription(), \PDO::PARAM_INT);
			$q->bindValue(':idauteur', $front->getidauteur(), \PDO::PARAM_INT);
			$q->execute(); 
			
			$result['idFront']= $this->dbConnect()->lastInsertId();
			if($result['idFront']==0){
				$q = $this->dbConnect()->query('SELECT Max(idFront) as idMax from '.$this->prefix.'front');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				$result['idFront']= $donnees['idMax'];
			}
				
			$result['resultat']=true;
			
			return $result;
		}catch (PDOException  $e){ 
			$result['resultat']=false;
			echo $e;
			$result['Erreur']=$e->getMessage();
			return $result;
		}	;	
	}

	public function delete($idFront)  {
		try{
			$idFront = (int) $idFront;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'front WHERE idfront = '.$idFront);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getLigneUnFront($idFront)  {
		try{
			$idFront = (int) $idFront;
			$q = $this->dbConnect()->query('SELECT idfront, idauteur, dateDebut, dateFin, valide, nom, description,  idauteur FROM '.$this->prefix.'front WHERE idfront = '.$idFront);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new Front($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListAll()  {
		try{
			$front = [];
			$q = $this->dbConnect()->query('SELECT  idfront, idauteur, dateDebut, dateFin,  valide, nom, description FROM '.$this->prefix.'front ORDER BY Nom ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$front[] = new Front($donnees);
			}

			return $front;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(Front $front)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'front SET dateDebut = :dateDebut, dateFin= :dateFin, projection = :projection, valide = :valide, nom = :nom,  description= :description,  idauteur = :idauteur WHERE idFronts = :idFronts');

			$q->bindValue(':idFronts', $front->getIdFronts(), \PDO::PARAM_INT);
			$q->bindValue(':dateDebut', $front->getDateDebut(), \PDO::PARAM_DEC);
			$q->bindValue(':dateFin', $front->getDateFin(), \PDO::PARAM_DEC);
			$q->bindValue(':valide', $front->getValide(), \PDO::PARAM_STR);
			$q->bindValue(':nom', $front->getNom(), \PDO::PARAM_STR);
			$q->bindValue(':description', $front->getDescription(), \PDO::PARAM_STR);
			$q->bindValue(':iduteur', $front->getIdAuteur(), \PDO::PARAM_INT);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}


}