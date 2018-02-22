<?php
 
class PointManager extends Manager{

	public function __construct(){
		
	}

	public function add(Point $point)  {
		$result=[];
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'points(lat, lng, idmarqueur, idlignefront ) VALUES(:lat, :lng, :idmarqueur, :idlignefront)');
			
			$q->bindValue(':lng', $point->getLng(), \PDO::PARAM_STR);
			$q->bindValue(':lat', $point->getLat(), \PDO::PARAM_STR);
			$q->bindValue(':idmarqueur', $point->getidMarqueur(), \PDO::PARAM_INT);
			$q->bindValue(':idlignefront', $point->getIdLigneFront(), \PDO::PARAM_INT);
			$q->execute(); 
			
			$result['idpoint']= $this->dbConnect()->lastInsertId();
			if($result['idpoint']==0){
				$q = $this->dbConnect()->query('SELECT Max(idpoint) as idMax from '.$this->prefix.'points');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				$result['idpoint']= $donnees['idMax'];
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

	public function delete($idpoint)  {
		try{
			$idpoint = (int) $idpoint;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'points WHERE idpoint = '.$idpoint);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($idmarqueur)  {
		try{
			$idmarqueur = (int) $idmarqueur;
			$q = $this->dbConnect()->query('SELECT idpoint, lng, lat,idmarqueur, idlignefront FROM '.$this->prefix.'points WHERE idpoint = '.$idpoint);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new Point($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	
	public function getPointsUneLigne($idlignefront)  {
		try{
			//$point = [];
			$q = $this->dbConnect()->query('SELECT idpoint, lng, lat,  idmarqueur, idlignefront FROM '.$this->prefix.'points WHERE idlignefront = '.$idlignefront);
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$point[] = $donnees;
			}
			//echo"<br />Point Manager 1 = <pre>";print_r($point);echo"</pre>";
			return $point;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}
	
	
	public function getListAll()  {
		try{
			$point = [];
			$q = $this->dbConnect()->query('SELECT idpoint, lng, lat,  idmarqueur, idlignefront FROM '.$this->prefix.'points ORDER BY idpoint ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$point[] = new Point($donnees);
			}

			return $point;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(Point $point)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'points SET lng = :lng, lat= :lat,  idmarqueur = :idmarqueur, idlignefront= :idlignefront WHERE idpoint = :idpoint');

			$q->bindValue(':idPoint', $point->getIdPoint(), \PDO::PARAM_INT);
			$q->bindValue(':lng', $point->getlng(), \PDO::PARAM_DEC);
			$q->bindValue(':lat', $point->getlat(), \PDO::PARAM_DEC);
			$q->bindValue(':idmarqueur', $point->getIdMarqueur(), \PDO::PARAM_INT);
			$q->bindValue(':idlignefront', $point->getIdLigneFront(), \PDO::PARAM_INT);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}


}