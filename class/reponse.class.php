<?php

require_once 'myPDO.param.php';

class Reponse{

    private $id_reponse;
    private $id_question;
    private $intitule_reponse;

    public function getIdReponse(){
        return $this->id_reponse;
    }

    public function getIdQuestion(){
        return $this->id_question;
    }

    public function getIntituleReponse(){
        return $this->intitule_reponse;
    }

    public static function getReponseFromId($id_reponse){
        $pdo = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM reponse
			WHERE id_reponse = ?
SQL
        );
        $pdo->setFetchMode(PDO::FETCH_CLASS,__CLASS__);
        $pdo->execute(array($id_reponse));
        $elt = $pdo->fetch();
        if($elt !== false){
            return $elt;
        }
        else{
            throw new Exception('Aucune réponse correspondante n\'a été trouvée');
        }
    }
}