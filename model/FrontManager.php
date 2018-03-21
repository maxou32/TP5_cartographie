<?php
 
class FrontManager extends Manager{

	public function __construct(){
		
	}

	public function add(Front $front)  {
		$result=[];
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'front(nom,  description, zoom, lat, lng, valide, idauteur) VALUES(:nom, :description, :zoom, :lat, :lng, :valide, :idauteur)');
			
			$q->bindValue(':zoom', $front->getZoom(), \PDO::PARAM_INT);
			$q->bindValue(':lat', $front->getLat(), \PDO::PARAM_STR);
			$q->bindValue(':lng', $front->getLng(), \PDO::PARAM_STR);
			$q->bindValue(':valide', $front->getValide(), \PDO::PARAM_BOOL);
			$q->bindValue(':nom', $front->getNom(), \PDO::PARAM_STR);
			$q->bindValue(':description', $front->getDescription(), \PDO::PARAM_INT);
			$q->bindValue(':idauteur', $front->getIdauteur(), \PDO::PARAM_INT);
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
			$q = $this->dbConnect()->query('SELECT idfront, idauteur, zoom, lat, lng, valide, nom, description,  idauteur FROM '.$this->prefix.'front WHERE idfront = '.$idFront);
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
			$q = $this->dbConnect()->query('SELECT  idfront, idauteur, zoom, lat, lng,  valide, nom, description FROM '.$this->prefix.'front ORDER BY Nom ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$front[] = new Front($donnees);
			}

			return $front;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListValide()  {
		try{
			$front = [];
			$q = $this->dbConnect()->query('SELECT  idfront, idauteur, zoom, lat, lng,  valide, nom, description FROM '.$this->prefix.'front WHERE valide = 1 ORDER BY Nom ASC');
			
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
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'front SET zoom = :zoom, lat= :lat, lng = :lng,  valide = :valide, nom = :nom,  description= :description,  idauteur = :idauteur WHERE idfront = :idfront');

			$q->bindValue(':idfront', $front->getIdFront(), \PDO::PARAM_INT);
			$q->bindValue(':zoom', $front->getZoom(), \PDO::PARAM_INT);
			$q->bindValue(':lat', $front->getLat(), \PDO::PARAM_STR);
			$q->bindValue(':lng', $front->getLng(), \PDO::PARAM_STR);
			$q->bindValue(':valide', $front->getValide(), \PDO::PARAM_STR);
			$q->bindValue(':nom', $front->getNom(), \PDO::PARAM_STR);
			$q->bindValue(':description', $front->getDescription(), \PDO::PARAM_STR);
			$q->bindValue(':idauteur', $front->getIdAuteur(), \PDO::PARAM_INT);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}
	
	public function updateValide(Front $front)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'front SET valide = :valide WHERE idfront = :idfront');

			$q->bindValue(':idfront', $front->getIdFront(), \PDO::PARAM_INT);
			$q->bindValue(':valide', $front->getValide(), \PDO::PARAM_STR);
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}


}