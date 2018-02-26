<?php
 
class DatesFrontManager extends Manager{

	public function __construct(){
		
	}

	public function add(datesfront $datesfront)  {
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'datesfront(description, valide, numordre, date,idfront) VALUES(:description, :valide, :numordre, :date, :idfront)');

			$q->bindValue(':description', $datesfront->getDescription(), \PDO::PARAM_STR);
			$q->bindValue(':valide', $datesfront->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':numordre', $datesfront->getNumordre(), \PDO::PARAM_INT);
			$q->bindValue(':date', $datesfront->getDate(), \PDO::PARAM_STR);
			$q->bindValue(':idfront', $datesfront->getIdfront(), \PDO::PARAM_INT);
			$q->execute();
			
			$result['iddatesfront']= $this->dbConnect()->lastInsertId();
			if($result['iddatesfront']==0){
				$q = $this->dbConnect()->query('SELECT Max(iddatesfront) as idMax from '.$this->prefix.'datesfront');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				echo"<br />datesfronttManager Front<pre>";print_r($donnees);echo"</pre>";
				$result['iddatesfront']= $donnees['idMax'];
			}
			$result['resultat']=true;
			
			return $result;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;	
	}

	public function delete($iddatesfront)  {
		try{
			$iddatesfront = (int) $iddatesfront;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'datesfront WHERE idDate = '.$iddatesfront);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($iddatesfront)  {
		try{
			$iddatesfront = (int) $iddatesfront;
			$q = $this->dbConnect()->query('SELECT idDate, valide, numordre, date,  description,  idfront FROM '.$this->prefix.'datesfront WHERE idDate = '.$iddatesfront);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new datesfront($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getdatesfrontUnFront($idFront)  {
		try{
			$idFront = (int) $idFront;
			$q = $this->dbConnect()->query('SELECT idDate, valide, numordre, date,  description, idfront FROM '.$this->prefix.'datesfront WHERE idfront = '.$idFront);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return $donnees;
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListAll()  {
		try{
			$datesfront = [];
			$q = $this->dbConnect()->query('SELECT  idDate, valide, numordre, date, idfront, description FROM '.$this->prefix.'datesFront ORDER BY iddate ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$datesfront[] = new DatesFront($donnees);
			}
			
			return $datesfront;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		};
	}

	public function update(datesfront $datesfront)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'datesfront SET valide = :valide, numordre= :numordre, date = :date, idfront = :idfront WHERE idDate = :idDate');

			$q->bindValue(':idDate', $datesfront->getIddatesfront(), \PDO::PARAM_INT);
			$q->bindValue(':valide', $datesfront->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':description', $datesfront->getDescription(), \PDO::PARAM_STR);
			$q->bindValue(':numordre', $datesfront->getNumordre(), \PDO::PARAM_INT);
			$q->bindValue(':date', $datesfront->getDate(), \PDO::PARAM_STR);
			$q->bindValue(':idfront', $datesfront->getIdfront(), \PDO::PARAM_INT);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

}