<?php

require_once 'myPDO.param.php';


class Theme
{
	private $id_theme;
	private $nom_theme;

	public function getIdTheme(){
		return $this->id_theme;
	}

	public function getNomTheme(){
		return $this->nom_theme;
	}

/**
** Méthodes de classes
**/

/**
** Récupère tous les thèmes
**/
	public static function getAllThemes(){
		$pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM theme 
SQL
	);
		$pdo->setFetchMode(PDO::FETCH_CLASS,__CLASS__);
		$pdo->execute();
		if(($liste = $pdo->fetchAll()) !== false){
	    		return $liste;
	    } 
	    	else{
	    		throw new Exception('Aucune thème enregistré.');
	    }
	}

/**
** Récupère un thème spécifique
**/

	public static function getTheme($id){
			$pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM theme
			WHERE id_theme = ? 
SQL
	);
		$pdo->setFetchMode(PDO::FETCH_CLASS,__CLASS__);
		$pdo->execute(array($id));
		$elt = $pdo->fetch();
		if($elt !== false){
        return $elt;
      }
      	else{
      		throw new Exception('Aucun thème correspondant n\'a été trouvé');
      	}
	}

/**
** Récupère toutes les questions
**/
	public static function getAllQuestions(){
		$pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM question 
SQL
	);
		$pdo->setFetchMode(PDO::FETCH_CLASS,'question');
		$pdo->execute();
		if(($liste = $pdo->fetchAll()) !== false){
	    		return $liste;
	    } 
	    	else{
	    		throw new Exception('Aucune question enregistrée.');
	    }
	}

/**
** Méthodes d'instance
**/
		public function getQuestions(){
		$pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM question
			WHERE id_theme = ? 
SQL
	);
		$pdo->setFetchMode(PDO::FETCH_CLASS,'question');
		$pdo->execute(array($this->getIdTheme()));
		if(($liste = $pdo->fetchAll()) !== false){
	    		return $liste;
	    } 
	    	else{
	    		throw new Exception('Aucune question enregistrée.');
	    }
	}


}