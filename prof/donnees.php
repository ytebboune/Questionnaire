<?php
include_once('../include/header.php');
$post = $_POST;
var_dump($post);
$theme = $_POST['theme'];
var_dump($theme);
$insert = $pdo->prepare("INSERT INTO theme VALUES(null, '$theme')");
$insert->execute();

//$quest = $_POST["question"];
//$longueurQuestion = count($_POST["question"]);
//
//
//for ($i = 0; $i < $longueurQuestion ; $i++ ) {
//    $insert = $pdo->prepare("INSERT INTO question VALUES(null, 1, '$quest[$i]', 'Test', 5)");
//    $insert->execute();
//}
?>

<!--<form>-->
<!--    <h3>Intitulé de la question: </h3><input name="question"/><br/>-->
<!--    <h3>Indice: </h3><input type="text" name="theme"/></br></br>-->
<!--    <input type="submit" value="Generer"/>-->
<!--</form>-->
<?php
include_once('../include/footer.php');
?>