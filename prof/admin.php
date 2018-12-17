<?php
    /**
    * Created by PhpStorm.
    * User: pa500802
    * Date: 05/10/2017
    * Time: 11:42
    */
    include_once('../include/header.php');
    require_once ('../class/theme.class.php');
    require_once ('../class/question.class.php');

session_start();
    error_reporting(0);

if (isset($_SESSION['connected']))
    {
        ?>
        <h1 style="color:lightsteelblue; font-size:45px; text-decoration: underline;"> Bienvenue, <?php echo $_SESSION['username']; ?> !</h1></br></br>
        <br/>
        <a href="?action=addTheme"><button style="background-color: #91a3b0;">Creer un theme</button></a>
        <a href="?action=addQu"><button style="background-color: #91a3b0;">Creer une question</button></a>
        <a href="dashboard.php"><button style="background-color: #91a3b0;">Tableau de bord</button></a>
        <a href="selectionQuestions.php"><button style="background-color: #91a3b0;">Generer le questionnaire</button></a><br/><br/><br/>
        <?php

        if(isset($_SESSION['username'])){

            if(isset($_GET['action'])){

                if($_GET['action']=='addTheme') {
                    ?>
                    <form action="admin.php" method="post"></br>
                        <h1 style="font-size:25px; color:lightsteelblue;">Nom du thème: </h1><input type="text" name="theme"/></br></br>
                        <button style="background-color:rgb(61, 157, 179);" type="submit">Valider</button>
                    </form>

                <?php }
                if($_GET['action']=='addQu') {

                    try
                    {
                        $sql = 'SELECT * FROM theme';
                        $result = $pdo->query($sql);
                    }
                    catch (PDOException $e)
                    {
                        $error = 'Erreur pour trouver la table dans la base de données ' . $e->getMessage();
                        include 'error.php';
                        exit();
                    }
                    foreach ($result as $row)
                    {
                        $theme[] = array(
                            'id_theme' => $row['id_theme'],
                            'nom_theme' => $row['nom_theme']
                        );
                    }
                    ?>
                    <form action="?action=addRep" method="post"></br>
                    <select name="thm"><option>Choisir un theme</option>
                            <?php
                    foreach ($theme as $themes): ?>
                        <option value="<?php echo $themes['id_theme'];?>"><?php echo $themes['nom_theme'];?></option>
                    <?php endforeach; ?>
                    </select>
                        <h1 style="font-size:25px; color:lightsteelblue;">Nom de la question: </h1><input type="text" name="quest"/></br></br>
                        <h1 style="font-size:25px; color:lightsteelblue;">Bareme: </h1><input type="text" name="bareme"/></br></br>
                        <h1 style="font-size:25px; color:lightsteelblue;">Indice: </h1><input type="text" name="indice"/></br></br>
                        <button style="background-color:rgb(61, 157, 179);" type="submit">Ajouter une reponse</button>
                    </form>

                <?php }

                if($_GET['action']=='addRep') {
                    ?>
                    <form action="admin.php" method="post">
                        <h1 style="font-size:25px; color:lightsteelblue;"><strong>Intitulé de la reponse juste:</strong></h1></br>
                        <input type="text" name="repJuste"/></br></br></br>
                        <h1 style="font-size:25px; color:lightsteelblue;"><strong>Intitulé des réponses suivantes:</strong></h1></br>
                        <h1 style="font-size:25px; color:lightsteelblue;">Reponse 1 : </h1>
                        <input type="text" name="rep[]"/></br></br>
                        <div id="divReponses"></div>
                        <input id="rep" type="button" onclick="ajoutReponse();" value="Ajouter une reponse"/></br>
                        <button style="background-color:rgb(61, 157, 179);" type="submit">Valider</button>
                    </form>
                    <?php
            }
        }
    }} else
    echo "Accès refusé";
include_once('../include/footer.php');
?>
<script type="text/javascript" >

    var ajoutReponse = (function() {

        var numReponse = 1;

        return function() {

            numReponse++;

            var h1 = document.createElement('h1');
            h1.style = "font-size:25px; color:lightsteelblue;";
            h1.innerHTML = "Reponse " + numReponse + " :";

            var input = document.createElement('input');
            input.type = "text";
            input.name = "rep[]";
            var br = document.createElement('br');
            var br2 = document.createElement('br');

            document.getElementById('divReponses').appendChild(h1);
            document.getElementById("divReponses").appendChild(input);
            document.getElementById("divReponses").appendChild(br);
            document.getElementById("divReponses").appendChild(br2);

            return numReponse;
        }

    }) ();
</script>

<?php

try
{
    $sql = 'SELECT * FROM theme';
    $result = $pdo->query($sql);
}
catch (PDOException $e)
{
    $error = 'Erreur pour trouver la table dans la base de données ' . $e->getMessage();
    include 'error.php';
    exit();
}
foreach ($result as $row)
{
    $themes[] = array(
        'id_theme' => $row['id_theme'],
        'nom_theme' => $row['nom_theme']
    );
}
if (!$_GET['action']){
    ?> <label><strong>Liste des themes :</strong></label></br></br></br><?php
    foreach ($themes as $thms): ?>
        <div id="wrapper">

            <p><?php echo $thms['nom_theme']; ?></p>

            <?php $_SESSION['id_theme'] = $thms['id_theme']; ?>
        </div>
    <?php endforeach;

}

// creation de theme
$sql = 'SELECT * FROM theme';
$result = $pdo->query($sql);
foreach ($result as $row)
{

    $nomTheme[] = array(
        'nom_theme' => $row['nom_theme']
    );
}

if (isset($_POST['theme']))
{
    $verif = false;
    $listThemes = Theme::getAllThemes();
    foreach ($listThemes as $thm){
        if(strtoupper($thm->getNomTheme()) == strtoupper($_POST['theme'])){
            $verif = true;
        }
    }
    $theme = $_POST['theme'];
    if ($verif == false){
        $insert = $pdo->prepare("INSERT INTO theme VALUES(null, '$theme')"); //sensible a la casse les cotes ne fonctionnent pas
        $insert->execute();
    } else
?><script> alert('Theme deja existant');</script><?php
}

if (isset($_POST['quest']))
{
    //$verif = false;
    $id_theme=$_POST['thm'];
    $quest = $_POST['quest'];
    $bareme = $_POST['bareme'];
    $indice = $_POST['indice'];
        $insert = $pdo->prepare("INSERT INTO question VALUES(null, '$id_theme','0', '$quest', '$indice', '$bareme')"); //sensible a la casse les cotes ne fonctionnent pas
        $insert->execute();
}
if (isset($_POST['rep']))
{
    $repJuste = $_POST["repJuste"];


    /////////// Récupération réponse JUSTE
    try
    {
        $sql = 'SELECT MAX(id_question) FROM question';
        $result = $pdo->query($sql);
    }
    catch (PDOException $e)
    {
        $error = 'Erreur pour trouver la table dans la base de données ' . $e->getMessage();
        include 'error.php';
        exit();
    }
    foreach ($result as $row)
    {
        $idQ[] = array(
            'id_question' => $row['id_question']
        );
    }
    $id_quest = $row[0];
    $rep = $_POST['quest'];







    /////////////// RECUPERATION AUTRES reponses
    $reps = $_POST["rep"];
    for($i =0; $i< count($reps) ; $i++)
    {
        $insert = $pdo->prepare( "INSERT INTO reponse VALUES(null, '$id_quest', '$reps[$i]')");
        $insert->execute();
    }
    $insert = $pdo->prepare("INSERT INTO reponse VALUES(null, '$id_quest', '$repJuste')"); //sensible a la casse les cotes ne fonctionnent pas
    $insert->execute();
    try
    {
        $sql = 'SELECT MAX(id_reponse) FROM reponse';
        $result = $pdo->query($sql);
    }
    catch (PDOException $e)
    {
        $error = 'Erreur pour trouver la table dans la base de données ' . $e->getMessage();
        include 'error.php';
        exit();
    }
    foreach ($result as $reps)
    {
        $idRep[] = array(
            'id_reponse' => $row['id_reponse']
        );
    }
    $idRepJuste = $reps[0];
    $update = $pdo->prepare("UPDATE question
SET id_bonne_reponse = $idRepJuste where id_question = $id_quest");
    $update->execute();
}
//?>