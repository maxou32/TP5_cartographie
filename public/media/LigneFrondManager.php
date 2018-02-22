<?php
 
class LigneFrontManager extends Manager{

	public function __construct(){
		
	}

	public function add(LigneFront $lignefront)  {
		$result=[];
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'lignefront(nom, dateDebut, dateFin, valide, idfront, idcontributeurfront ) VALUES(:nom, :dateDebut, :dateFin, :valide, :idfront :idcontributeurfront)');
			
			$q->bindValue(':dateDebut', $lignefront->getDateDebut(), \PDO::PARAM_STR);
			$q->bindValue(':dateFin', $lignefront->getDateFin(), \PDO::PARAM_STR);
			$q->bindValue(':valide', $lignefront->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':couleur', $lignefront->getCouleur(), \PDO::PARAM_STR);
			$q->bindValue(':idfront', $lignefront->getIdFront(), \PDO::PARAM_INT);
			$q->bindValue(':idcontributeurfront', $lignefront->getIdContributeurFront(), \PDO::PARAM_INT);
			$q->execute(); 
			
			$result['idlignefront']= $this->dbConnect()->lastInsertId();
			if($result['idlignefront']==0){
				$q = $this->dbConnect()->query('SELECT Max(idlignefront) as idMax from '.$this->prefix.'lignefront');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				$result['idlignefront']= $donnees['idMax'];
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

	public function delete($idlignefront)  {
		try{
			$idlignefront = (int) $idlignefront;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'lignefront WHERE idlignefront = '.$idlignefront);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($idfront)  {
		try{
			$idfront = (int) $idfront;
			$q = $this->dbConnect()->query('SELECT idlignefront, dateDebut, dateFin, valide, couleur,  idfront, idcontributeurfront FROM '.$this->prefix.'lignefront WHERE idlignefront = '.$idlignefront);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new LigneFront($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListAll()  {
		try{
			$lignefront = [];
			$q = $this->dbConnect()->query('SELECT idlignefront, dateDebut, dateFin, valide, couleur,  idfront, idcontributeurfront FROM '.$this->prefix.'lignefront ORDER BY Nom ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$lignefront[] = new LigneFront($donnees);
			}

			return $lignefront;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(LigneFront $lignefront)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'lignefront SET dateDebut = :dateDebut, dateFin= :dateFin,  valide = :valide, couleur = :couleur, idfront = :idfront, idcontributeurfront= :idcontributeurfront WHERE idlignefront = :idlignefront');

			$q->bindValue(':idLigneFront', $lignefront->getIdLigneFront(), \PDO::PARAM_INT);
			$q->bindValue(':dateDebut', $lignefront->getDateDebut(), \PDO::PARAM_DEC);
			$q->bindValue(':dateFin', $lignefront->getDateFin(), \PDO::PARAM_DEC);
			$q->bindValue(':valide', $lignefront->getValide(), \PDO::PARAM_STR);
			$q->bindValue(':couleur', $lignefront->getCouleur(), \PDO::PARAM_STR);
			$q->bindValue(':idauteur', $lignefront->getIdAuteur(), \PDO::PARAM_INT);
			$q->bindValue(':idcontributeurfront', $lignefront->getIdContributeurFront(), \PDO::PARAM_INT);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}


}