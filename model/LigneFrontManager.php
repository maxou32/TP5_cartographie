<?php
 
class LigneFrontManager extends Manager{

	public function __construct(){
		
	}

	public function add(LigneFront $lignefront)  {
		$result=[];
		try{
			
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'lignefront (couleur, type, valide, iddatefront, idcontributeurfront ) VALUES (:couleur, :type, :valide, :iddatefront, :idcontributeurfront)');
			
			$q->bindValue(':couleur', $lignefront->getCouleur(), \PDO::PARAM_STR);
			$q->bindValue(':type', $lignefront->getType(), \PDO::PARAM_STR);
			$q->bindValue(':valide', $lignefront->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':iddatefront', $lignefront->getIddatefront(), \PDO::PARAM_INT);
			$q->bindValue(':idcontributeurfront', $lignefront->getIdContributeurFront(), \PDO::PARAM_INT);
			
			$q->execute(); 
			/*
			$result['idlignefront']= $this->dbConnect()->lastInsertId();
			if($result['idlignefront']==0){
				$q = $this->dbConnect()->query('SELECT Max(idlignefront) as idMax from '.$this->prefix.'lignefront');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				$result['idlignefront']= $donnees['idMax'];
			}
			*/	
			$result['resultat']=true;
			
			return $result;
		}catch (PDOException  $e){ 
			$result['resultat']=false;
			echo $e;
			$result['Erreur']=$e->getMessage();
			return $result;
		}	;	
	}
	public function getMaxId(){
		$q = $this->dbConnect()->query('SELECT Max(idlignefront) as idMax from '.$this->prefix.'lignefront');
		$donnees = $q->fetch(\PDO::FETCH_ASSOC);
		//echo"<br />datesfrontManager Front<pre>";print_r($donnees);echo"</pre>";
		$result['idlignefront']= $donnees['idMax'];
		return $result['idlignefront'];
	}

	public function delete($iddatefront)  {
		try{
			$iddatefront = (int) $iddatefront;
			//echo 'DELETE FROM '.$this->prefix.'lignefront WHERE idlignefront = '.$iddatefront ; 
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'lignefront WHERE iddatefront = '.$iddatefront);
			return true;			
		}catch (PDOException  $e){ 
			echo $e;
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($idfront)  {
		try{
			$idfront = (int) $idfront;
			$q = $this->dbConnect()->query('SELECT idlignefront, valide, couleur, type, iddatefront, idcontributeurfront FROM '.$this->prefix.'lignefront WHERE idlignefront = '.$idlignefront);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new LigneFront($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	
	}

	public function getLigneUneDate($iddatefront)  {
		try{
			$lignefront = [];
			$iddatefront = (int) $iddatefront;
			$q = $this->dbConnect()->query('SELECT idlignefront, valide, couleur, type, iddatefront, idcontributeurfront FROM '.$this->prefix.'lignefront WHERE iddatefront = '.$iddatefront);
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$lignefront[] = new LigneFront ($donnees);
			}
			return $lignefront;
			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	
	}
	public function getListAll()  {
		try{
			$lignefront = [];
			$q = $this->dbConnect()->query('SELECT idlignefront, valide, couleur, type, iddatefront, idcontributeurfront FROM '.$this->prefix.'lignefront ORDER BY Nom ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$lignefront[] = new LigneFront($donnees);
			}

			return $lignefront;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	
	}

	public function update(LigneFront $lignefront)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'lignefront SET  valide = :valide, couleur = :couleur, type = :type, iddatefront = :iddatefront, idcontributeurfront= :idcontributeurfront WHERE idlignefront = :idlignefront');

			$q->bindValue(':idLigneFront', $lignefront->getIdLigneFront(), \PDO::PARAM_INT);
			$q->bindValue(':valide', $lignefront->getValide(), \PDO::PARAM_STR);
			$q->bindValue(':couleur', $lignefront->getCouleur(), \PDO::PARAM_STR);
			$q->bindValue(':type', $lignefront->getType(), \PDO::PARAM_STR);
			$q->bindValue(':iddatefront', $lignefront->getIddatefront(), \PDO::PARAM_INT);
			$q->bindValue(':idcontributeurfront', $lignefront->getIdContributeurFront(), \PDO::PARAM_INT);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}


}