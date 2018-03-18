<?php
 
class DatesFrontManager extends Manager{

	public function __construct(){
		
	}

	public function add(datesfront $datesfront)  {
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'datesFront(description, valide, numordre, date,idfront) VALUES(:description, :valide, :numordre, :date, :idfront)');

			$q->bindValue(':description', $datesfront->getDescription(), \PDO::PARAM_STR);
			$q->bindValue(':valide', $datesfront->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':numordre', $datesfront->getNumordre(), \PDO::PARAM_INT);
			$q->bindValue(':date', $datesfront->getDate(), \PDO::PARAM_STR);
			$q->bindValue(':idfront', $datesfront->getIdfront(), \PDO::PARAM_INT);
			$q->execute();
			
			$result['iddate']= $this->dbConnect()->lastInsertId();
			if($result['iddate']==0){
				$q = $this->dbConnect()->query('SELECT Max(iddate) as idMax from '.$this->prefix.'datesFront');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				$result['iddate']= $donnees['idMax'];
			}
			$result['resultat']=true;
			
			return $result;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;	
	}
	
	public function getMaxId(){
		$q = $this->dbConnect()->query('SELECT Max(iddate) as idMax from '.$this->prefix.'datesFront');
		$donnees = $q->fetch(\PDO::FETCH_ASSOC);
		//echo"<br />datesfrontManager Front<pre>";print_r($donnees);echo"</pre>";
		$result['iddate']= $donnees['idMax'];
		return $result['iddate'];
	}

	public function delete($_iddate)  {
		try{
			$_iddate = (int) $_iddate;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'datesFront WHERE idDate = '.$_iddate);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($iddatesfront)  {
		try{
			$iddatesfront = (int) $iddatesfront;
			$q = $this->dbConnect()->query('SELECT idDate, valide, numordre, DATE_FORMAT( date, \'%d/%m/%Y\') as date,  description,  idfront FROM '.$this->prefix.'datesFront WHERE idDate = '.$iddatesfront);
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

	public function getListUnFront($idFront)  {
		try{
			$datesfront=[] ;
			$idFront = (int) $idFront;
			$q = $this->dbConnect()->query('SELECT idDate, valide, numordre, DATE_FORMAT( date, \'%d/%m/%Y\') as date,  description, idfront FROM '.$this->prefix.'datesFront WHERE idfront = '.$idFront.' ORDER BY date ASC');
			
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$datesfront[] = new DatesFront($donnees);
			}
			
			return $datesfront;
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
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'datesFront SET valide = :valide, description= :description, numordre= :numordre, date = :date, idfront = :idfront WHERE iddate = :idDate');

			$q->bindValue(':idDate', $datesfront->getIddate(), \PDO::PARAM_INT);
			$q->bindValue(':valide', $datesfront->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':description', $datesfront->getDescription(), \PDO::PARAM_STR);
			$q->bindValue(':numordre', $datesfront->getNumordre(), \PDO::PARAM_INT);
			$q->bindValue(':date', $datesfront->getDate(), \PDO::PARAM_STR);
			$q->bindValue(':idfront', $datesfront->getIdfront(), \PDO::PARAM_INT);
			
			$q->execute();
			$result['resultat']=true;
			return $result;
			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

}