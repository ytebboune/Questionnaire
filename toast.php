
<?php

require_once('class/question.class.php');
/*var_dump($_POST);
for ($i = 0; $i < count($_POST['test']); $i++){
echo $_POST['test'][$i]; // correspondra à value des checkboxes
// reste plus qu'a faire une requete update ou insert
}
*/
Question::getIdQuestionFromJSON(2);
