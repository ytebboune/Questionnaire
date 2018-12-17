<?php

require_once '../class/user.class.php';
require_once '../class/webpage.class.php';

//On cherche l'utilisateur
$user = User::searchFromLogin($_POST['username']);
$page = new WebPage("Connexion");
//Si il existe
if($user!==null){
    //On vérifie que le mdp correspond
    $mdp = $user->getMdp();
    var_dump($user);
    if(strcmp($mdp, $_POST['password']) == 0){
        $bool = true;
    }
    //A VOIR QUAND LES MDP SERONT HASHER
    //$bool = password_verify ( $_POST['mdp'] , $pswd );
}
else{
    $bool = false;
}

//Si tout est bon on parametre la session
if($bool){
    session_start();
    $_SESSION['id'] = $user->getNum();
    $_SESSION['pseudo'] = $user->getPseudo();
    $_SESSION['mdp'] = password_hash($mdp, PASSWORD_BCRYPT);

    //Si l'utlisateur veut rester connecter malgre la coupure auto de la session
    if(isset($_POST['stay'])){
        //On envoie des cookies avec les données (ici valide pendant 30 jours)
        setcookie('login', $user->getLogin(), time() + 3600*24*30, null, null, false, true);
        setcookie('mdp', password_hash($user->getMdp(), PASSWORD_BCRYPT), time() + 3600*24*30, null, null, false, true);
    }

    //On redirige
    header('Location: ../etudiant/menu.php');
    exit();
}
//En cas d'erreur dans le formulaire
else{
    $page->appendJs(<<<JS
        alert("Pseudo ou mot de passe incorrect.");    
JS
);
    echo $page->toHTML();
    header('Refresh:0;url=index.php');
    exit();
}