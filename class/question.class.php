<?php

require_once 'myPDO.param.php';
require_once 'webpage.class.php';
require_once 'reponse.class.php';

class Question{
    private $id_question='';
    private $id_theme='';
    private $id_bonne_reponse='';
    private $intitule_question='';
    private $indice = '';
    private $scoreMax='';
    private $isIndiceShowed = false;

    public function getIdQuestion(){
        return $this->id_question;
    }

    public function getIdTheme(){
        return $this->id_theme;
    }

    public function getIdBonneReponse(){
        return $this->id_bonne_reponse;
    }

    public function getIntituleQuestion(){
        return $this->intitule_question;
    }

    public function getIndice(){
        $this->isIndiceShowed = true;
        return $this->indice;
    }

    public function getScoreMax(){
        return $this->scoreMax;
    }

    public function getIndiceStatut(){
        return $this->isIndiceShowed;
    }


    /**
     ** Methode de classe
     **/

    /**
     ** Récupère une question spécifique
     **/

    public static function getQuestion($id){
        $pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM question
			WHERE id_question = ? 
SQL
        );
        $pdo->setFetchMode(PDO::FETCH_CLASS,__CLASS__);
        $pdo->execute(array($id));
        $elt = $pdo->fetch();
        if($elt !== false){
            return $elt;
        }
        else{
            throw new Exception('Aucune question correspondant n\'a été trouvée');
        }
    }

    /**
     ** Récupère une l'id d'une question du fichier JSON en fonction de l'indice passé en paramètre
     **/

    public static function getIdQuestionFromJSON($indice){
        $json = file_get_contents('..\prof\questions.json', FILE_USE_INCLUDE_PATH);
        $questions = json_decode($json, true);
        if($indice <= count($questions['questions'])){
            return $questions['questions'][$indice-1];
        }
        else{
            $page = new webpage("Fin");
            $page->appendJS(<<<JS
				alert("Le questionnaire est terminé, merci de votre participation.");
JS
            );
            echo $page->toHTML();
            header('Refresh:0;url=menu.php');
        }
    }


    /**
     ** Methode d'instance
     **/


    /**
     ** Récupère les réponses de la question courante
     **/
    public function getAllReponses(){
        $pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM reponse
			WHERE id_question = ?
SQL
        );
        $pdo->setFetchMode(PDO::FETCH_CLASS,'reponse');
        $pdo->execute(array($this->getIdQuestion()));
        if(($liste = $pdo->fetchAll()) !== false){
            return $liste;
        }
        else{
            throw new Exception('Aucune réponses à la question enregistrée.');
        }
    }

    /**
     ** Récupère 3 réponses aléatoires contenant la bonne
     **/

    public function getThreeRdmReponses(){
        $arr = array();
        $pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM reponse
			WHERE id_reponse = ?
SQL
        );
        $pdo->setFetchMode(PDO::FETCH_CLASS,'reponse');
        $pdo->execute(array($this->getIdBonneReponse()));

        if(($bonneReponse = $pdo->fetch()) !== false){
            $reponses = $this->getAllReponses();
            foreach($reponses as $elementKey => $reponse) {
                if($reponse->getIdReponse() == $this->getIdBonneReponse()){
                    unset($reponses[$elementKey]);
                }
            }
            shuffle($reponses);
            $arr[] = $reponses[0];
            $arr[] = $reponses[1];
            $arr[] = $bonneReponse;
            shuffle($arr);
            return ($arr);
        }
        else{
            throw new Exception("Aucune bonne réponse pour cette question.");
        }
    }

    /**
     **
     **/
    public function isAlreadyValidated($id_utilisateur){
        $pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM score
			WHERE id_question = ?
			AND id_utilisateur = ?
SQL
        );
        $pdo->execute(array($this->getIdQuestion(),$id_utilisateur));
        $elt = $pdo->fetch();
        if($elt == false){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getAllScore(){
        $pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT SUM(scoreMax)
			FROM question
SQL
        );
        $pdo->execute();
        $res = $pdo->fetch();
        return $res;
    }
}	

