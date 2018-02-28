<?php
 
class CarteManager extends Manager{

	public function __construct(){
		
	}

	public function add(Carte $carte)  {
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'carte(zoom, lat, lng, projection, layeroption, nom, idfront) VALUES(:zoom, :lat, :lng, :projection, :layeroption, :nom, :idfront)');

			$q->bindValue(':zoom', $carte->getZoom(), \PDO::PARAM_INT);
			$q->bindValue(':lat', $carte->getLat(), \PDO::PARAM_STR);
			$q->bindValue(':lng', $carte->getLng(), \PDO::PARAM_STR);
			$q->bindValue(':projection', $carte->getProjection(), \PDO::PARAM_STR);
			$q->bindValue(':layeroption', $carte->getLayeroption(), \PDO::PARAM_STR);
			$q->bindValue(':nom', $carte->getNom(), \PDO::PARAM_STR);
			$q->bindValue(':idfront', $carte->getIdfront(), \PDO::PARAM_INT);
			$q->execute();
			
			$result['idCarte']= $this->dbConnect()->lastInsertId();
			if($result['idCarte']==0){
				$q = $this->dbConnect()->query('SELECT Max(idcarte) as idMax from '.$this->prefix.'carte');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				echo"<br />CartetManager Front<pre>";print_r($donnees);echo"</pre>";
				$result['idCarte']= $donnees['idMax'];
			}
			$result['resultat']=true;
			
			return $result;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;	
	}

	public function delete($idcarte)  {
		try{
			$idcarte = (int) $idcarte;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'carte WHERE idcarte = '.$idcarte);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($idcarte)  {
		try{
			$idcarte = (int) $idcarte;
			$q = $this->dbConnect()->query('SELECT idcarte, lat, lng, projection, layeroption, nom, zoom,  idfront FROM '.$this->prefix.'carte WHERE idcarte = '.$idcarte);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new Carte($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getCarteUnFront($idFront)  {
		try{
			$idFront = (int) $idFront;
			$q = $this->dbConnect()->query('SELECT idcarte, lat, lng, projection, layeroption, nom, zoom, idfront FROM '.$this->prefix.'carte WHERE idfront = '.$idFront);
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
			$carte = [];
			$q = $this->dbConnect()->query('SELECT  idcarte, lat, lng, projection, layeroption, nom, zoom, idfront FROM '.$this->prefix.'carte ORDER BY idcarte ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$carte[] = new Carte($donnees);
			}

			return $carte;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(Carte $carte)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'carte SET lat = :lat, lng= :lng, projection = :projection, layeroption = : layeroption, nom = :nom, idfront = :idfront WHERE idcarte = :idcarte');

			$q->bindValue(':idcarte', $carte->getIdcarte(), \PDO::PARAM_INT);
			$q->bindValue(':lat', $carte->getLat(), \PDO::PARAM_STR);
			$q->bindValue(':lng', $carte->getLng(), \PDO::PARAM_STR);
			$q->bindValue(':projection', $carte->getProjection(), \PDO::PARAM_STR);
			$q->bindValue(':layeroption', $carte->getlayeroption(), \PDO::PARAM_STR);
			$q->bindValue(':nom', $carte->getnom(), \PDO::PARAM_STR);
			$q->bindValue(':idfront', $carte->getIdfront(), \PDO::PARAM_INT);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

}