<?php
 
class MarqueurManager extends Manager{

	public function __construct(){
		
	}

	public function add(Marqueur $marqueur)  {
		$result=[];
		try{
			$q = $this->dbConnect()->prepare('INSERT INTO '.$this->prefix.'marqueur(libelle, couleur, idmarqueur, icone ) VALUES(:libelle, :couleur, :idmarqueur :icone)');
			
			$q->bindValue(':couleur', $marqueur->getCouleur(), \PDO::PARAM_STR);
			$q->bindValue(':libelle', $marqueur->getLibelle(), \PDO::PARAM_STR);
			$q->bindValue(':icone', $marqueur->getIcone(), \PDO::PARAM_STR);
			$q->execute(); 
			
			$result['idmarqueur']= $this->dbConnect()->lastInsertId();
			if($result['idmarqueur']==0){
				$q = $this->dbConnect()->query('SELECT Max(idmarqueur) as idMax from '.$this->prefix.'marqueur');
				$donnees = $q->fetch(\PDO::FETCH_ASSOC);
				$result['idmarqueur']= $donnees['idMax'];
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

	public function delete($idmarqueur)  {
		try{
			$idmarqueur = (int) $idmarqueur;
			$this->dbConnect()->exec('DELETE FROM '.$this->prefix.'marqueur WHERE idmarqueur = '.$idmarqueur);
			return true;			
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function get($idmarqueur)  {
		try{
			$idmarqueur = (int) $idmarqueur;
			$q = $this->dbConnect()->query('SELECT idmarqueur, couleur, libelle, icone FROM '.$this->prefix.'marqueur WHERE idmarqueur = '.$idmarqueur);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			if($donnees) {
				return new Marqueur($donnees);
			}else{
				return false;
			}
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function getListAll()  {
		try{
			$marqueur = [];
			$q = $this->dbConnect()->query('SELECT idmarqueur, couleur, libelle, icone FROM '.$this->prefix.'marqueur ORDER BY idmarqueur ASC');
			
			while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)){
				$marqueur[] = new Marqueur($donnees);
			}

			return $marqueur;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}

	public function update(Marqueur $marqueur)  {
		try{
			$q = $this->dbConnect()->prepare('UPDATE '.$this->prefix.'marqueur SET couleur = :couleur, libelle= :libelle,  icone= :icone WHERE idmarqueur = :idmarqueur');

			$q->bindValue(':idMarqueur', $marqueur->getIdMarqueur(), \PDO::PARAM_INT);
			$q->bindValue(':couleur', $marqueur->getCouleur(), \PDO::PARAM_STR);
			$q->bindValue(':libelle', $marqueur->getLibelle(), \PDO::PARAM_STR);
			$q->bindValue(':icone', $marqueur->getIcone(), \PDO::PARAM_STR);
			
			$q->execute();
			return true;
		}catch (PDOException  $e){ 
			return 'Erreur : '.$e->getMessage();
		}	;
	}


}