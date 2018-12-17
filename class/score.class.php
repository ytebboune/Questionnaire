<?php

require_once 'myPDO.param.php';
/*require_once '../include/header.php';*/

class Score
{
    private $id_question = '';
    private $id_utilisateur = '';
    private $score = '';

    public function getIdQuestion(){
        return $this->id_question;
    }

    public function getIdUser(){
        return $this->id_utilisateur;
    }

    public function getScore(){
        return $this->score;
    }

    public static function getAllScore() {
        $pdo = myPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM score
            ORDER BY id_utilisateur
SQL
        );
        $pdo->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        $pdo->execute();
        if (($liste = $pdo->fetchAll()) !== false) {
            return $liste;
        } else {
            return "Aucun score à afficher.";
        }
    }

    public static function getScoreById($id){
        $pdo = myPDO::getInstance()->prepare(<<<SQL
            SELECT SUM(score)
            FROM score
            WHERE id_utilisateur = ?
SQL
        );
        $pdo->execute(array($id));
        if (($liste = $pdo->fetch()) !== false) {
            return $liste;
        } else {
            return "Pas de score pour cet élève.";
        }
    }
}