<?php

require_once 'myPDO.param.php' ;

class User {

    private $id_utilisateur = '';
    private $pseudo = '';
    private $mdp = '';
    private $nom_utilisateur = '';
    private $prenom_utilisateur = '';


    /**
     *	Accesseur sur le numAdmin de l'instance
     */
    public function getNum(){
        return $this->id_utilisateur;
    }

    /**
     *	Accesseur sur le login de l'instance
     */
    public function getPseudo(){
        return $this->pseudo;
    }

    /**
     *	Accesseur sur le mdp de l'instance
     */
    public function getNom(){
        return $this->nom_utilisateur;
    }

    /**
     *	Accesseur sur le mdp de l'instance
     */
    public function getPrenom(){
        return $this->prenom_utilisateur;
    }

    /**
     *	Accesseur sur le mdp de l'instance
     */
    public function getMdp(){
        return $this->mdp;
    }

    /**
     *	Méthode static avec 1 paramètre permettant la recherche d'un administrateur dans la table admin
     *	@param $login login de l'administrateur à chercher
     */
    public static function searchFromLogin($login){
        $pdo = myPDO::getInstance();
        $pdostat = $pdo->prepare(<<<SQL
        select *
        from utilisateur
        where Upper(pseudo) = Upper(?);
SQL
        );
        $pdostat->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        $pdostat->execute(array("$login"));
        if(($object = $pdostat->fetch()) !== false){
            return $object;
        }
    }

    public static function validateQuestion($id_etudiant, $id_question, $score){
        $pdo = myPDO::getInstance()->prepare(<<<SQL
			iNSERT INTO score VALUES(?,?,?)
SQL
        );
        $pdo->execute(array($id_question,$id_etudiant, $score));
    }
    public static function searchById($id){
        $pdo = myPDO::getInstance() ;
        $pdostat = $pdo->prepare(<<<SQL
        select *
        from utilisateur
        where id_utilisateur = ?;
SQL
        );
        $pdostat->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        $pdostat->execute(array("$id"));
        if(($object = $pdostat->fetch()) !== false){
            return $object;
        }
    }
}