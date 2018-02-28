<?php

class ControlleurLigne  extends Controlleur {

	public function __construct(){

	}
	private function decoupeLigne($ligne){
		$result=[];
		
		$remplace = array(",LatLng(");			
		$latlngTemp=str_replace($remplace, '|', $ligne);
		
		$supprime = array("),",")"," ","LatLng(");			
		$latlngTemp=str_replace($supprime, '', $latlngTemp);

		echo "ControlleurLigne decoupe 1: <pre>";print_r($latlngTemp);"</pre>";
		
		$temp = explode('|',$latlngTemp);
		echo "<br />ControlleurLigne decoupe 2: <pre>";print_r($temp);"</pre>";
		/*for ($i=0; $i<count($temp);$i++){
			$elem =explode(',',$temp[$i]);
			echo "<br />ControlleurLigne decoupe 3: <pre>";print_r($elem);"</pre>";
			if (isset($elem['1']) ){
				$result['lat']=$elem['1'];
				$result[$i]=$result['lat'] ;
				$result['lng']=$elem['2'];
				$result[$i][$lng]=$result['lng'] ;
			}else{
				$result[$i][$lng]=Null;
			}
		}
		*/
		//echo "ControlleurLigne decoupe 7: <pre>";print_r($result);"</pre>";
		return $temp;	
	}
	private function paramLigne ($params){
		$i=0;
		foreach($params as $key=>$value){			
			if (substr($value,0,5)==='ligne'){
				$paramligne[$i]=substr($value,5);
				$i++;
			}
		}
			return $paramligne;
	}
	
	public function addLigne($paramsBrut){
		//existance Front ?
		//oui
		
		//non
		echo "<br />ControlleurLigne 0 : <pre>";print_r($paramsBrut);"</pre>";
		$params=$this->decoupeParam($paramsBrut['mesFronts']); 
		echo "<br />ControlleurLigne 1 : <pre>";print_r($params);"</pre>";			 
		$monFront = new ControlleurFront();
		$result=$monFront->addFront($params);
		
		
		
		echo "<br />ControlleurLigne 2 : <pre>";print_r($result);"</pre>";
		if(!$result['resultat']){
			echo"<br />ControlleurLigne erreur création Front";
		}else{
			//2 création de lignes de fronts
			$type=['Ami'=>1,'Ennemi'=>2,'Neutre'=>3];
			$idFront=$result['idFront'];
			$detailLigne=$this->paramLigne($params);
			//echo"<br />Controlleur Ligne  3: <pre>";print_r($detailLigne);echo"</pre>";
			for ($i=0;$i < $params['nbLignesFront'];$i++){
				$j=0;
				while ($j < count($detailLigne)){
					$elem =explode('>',$detailLigne[$j]);
					if ($elem['0']==$i){
						$caractLigne[$elem['1']]=isset($elem['2'])?$elem['2']:Null;
					}
					$j++;
				}
				echo"<br />Controlleur Ligne 3.5: <pre>";print_r($result);echo"</pre>";
			
				$donnees=array('couleur' => $caractLigne['couleur'],'type' => $caractLigne['type'], 'dateDebut'=> $params['dateDebut'],'dateFin'=> $params['dateFin'],'valide' => 0, 'idcontributeurfront'=>'5', 'idFront'=>$idFront );
				
				$maLigne=new LigneFrontManager();
				$result=$maLigne->add(new LigneFront($donnees));
				if (!$result['resultat']){
					echo"<br />ControlleurLigne erreur création ";
					/*$monError=new ControlleurErreur();
					$monError->setError(array("origine"=>CONTROLLEUR."ControlleurFront", "raison"=>"Ajoût d'un nouveau front", "numberMessage"=>21));
					*/
				}else{
					//2 création des points de ligne de fronts
					$result['coord']=$this->decoupeLigne($caractLigne['coord']);
					echo"<br />Controlleur Ligne  4: <pre>";print_r($result);echo"</pre>";
					$nbCoord=count($result['coord']);
					$coord=$result['coord'];
					$idlignefront=$result['idlignefront'];
					for($k=0; $k < $nbCoord; $k++){
						$elem =explode(',',$coord[$k]);
						echo"<br />Controlleur Ligne  5: <pre>";print_r($elem);echo"</pre>";
						$donnees=array('lat' => $elem['0'], 'lng' => $elem['1'], 'idmarqueur'=>$type[$caractLigne['type']], 'idlignefront'=>$idlignefront);
						$monControlleurPoint= new ControlleurPoint();
						$result=$monControlleurPoint->addPoint($donnees);
					}
				}
			}				
		}
	}
	
	
	public function supprimeLigne ($params){
		echo('Demande de suppression pour le front = '.$params['idLigne']."<br />");
		echo"<br />Controlleur Ligne 3.5: <pre>";print_r($params);echo"</pre>";
		$result=false;
		$maLigne= new LigneFrontManager;
		$result=$maLigne->delete($params['idLigne']);
		if($result){
			echo ("Success");
		}else{
			echo ("suppression impossible"); 
		}
	}
	
	
	public function LireLignesUnFront($idFront){
		$mesLignes=[];
		$maLigneFrontManager = new LigneFrontManager();
		$mesLignes=$maLigneFrontManager->getLigneUnFront($idFront);
		//echo"<br />Controlleur Ligne 5 =<pre>";print_r($mesLignes);echo"</pre>";
		
		for($i=0; $i < count($mesLignes);$i++){
			//echo"<br />Controlleur Ligne 6 =<pre>";print_r($mesLignes['info'][$i]);echo"</pre>";
			$id=$mesLignes[$i]['idlignefront'];
			$monControlleurPoint= new ControlleurPoint();
			$mesPoints=$monControlleurPoint->LirePointsUneLigne($id);
			//echo"<br />Controlleur ligne 7 =<pre>";print_r($mesPoints);echo"</pre>";
			$mesLignes[$i]['points']=$mesPoints;
		}
		//echo"<br />Controlleur ligne 8 =<pre>";print_r($mesLignes);echo"</pre>";
			
		
		return $mesLignes; 
	}
	
	public function LireLignesUnFrontSeul($params){
		//echo"<br />Controlleur Ligne 5 =<pre>";print_r($params);echo"</pre>";
		$mesLignes=[];
		$maLigneFrontManager = new LigneFrontManager();
		$mesLignes=$maLigneFrontManager->getLigneUneDate($params['iddatefront']);
		$temp=[];
		for($i=0; $i < count($mesLignes);$i++){
			//$id=$mesDatesFronts[$i]->getIddate();

			$temp[$i]=[];
			$temp[$i]['idlignefront']=$mesLignes[$i]->getIdlignefront();
			$temp[$i]['couleur']=$mesLignes[$i]->getCouleur();
			$temp[$i]['type']=$mesLignes[$i]->getType();
			$temp[$i]['valide']=$mesLignes[$i]->getValide();
			$temp[$i]['iddatefront']=$mesLignes[$i]->getIddatefront();
			$temp[$i]['idcontributeurfront']=$mesLignes[$i]->getIdcontributeurfront();
			
		}
		//echo "<br />ControlleurFront 3 : <pre>";print_r($temp);"</pre>";
		
		echo json_encode($temp);	
	}
	
}