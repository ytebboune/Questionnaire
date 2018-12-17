<?php

require_once('../class/webpage.class.php');
require_once('../class/question.class.php');
require_once('../class/reponse.class.php');
require_once('../class/user.class.php');
require_once('../include/header.php');


session_start();
$user = User::searchFromLogin($_SESSION['pseudo']);
$page = new WebPage("Questionnaire");


if((isset($_REQUEST['answer']))&&(isset($_SESSION['id']))&&(isset($_REQUEST['indiceShowed']))){
    $rep = Reponse::getReponseFromId($_REQUEST['answer']);
    $question = Question::getQuestion($rep->getIdQuestion());
    $score=0;
    if($_REQUEST['answer'] == $question->getIdBonneReponse()){
        $score = $question->getScoreMax() - $_REQUEST['indiceShowed'];
    }
    User::validateQuestion($_SESSION['id'], $question->getIdQuestion(), $score);
}

if(isset($_GET['q'])){
    $idx = $_GET['q'];
    $next = $idx+1;

    $idQuestion = Question::getIdQuestionFromJSON($idx);
    $question = Question::getQuestion($idQuestion);

    $scoreMax=$question->getScoreMax();

    $html=(<<<HTML
		<form name="questionnaire" method="POST" action="questionnaire.php?q={$next}">
		<h1>{$question->getIntituleQuestion()}<h1>
HTML
    );
    $reponses = $question->getThreeRdmReponses();
    foreach ($reponses as $reponse) {
        $html.=(<<<HTML
			<div>
			
</br>
			<label for="mark">{$reponse->getIntituleReponse()}</label>
    	<input name="answer" type="radio" value="{$reponse->getIdReponse()}" id="reponse">
    	</br>
 			</div></br></br>
HTML
        );
    }
    $html.=(<<<HTML
	  	<button type="submit">Envoyer</button>
	  	<button onclick="getIndice()" type="button">Avoir un indice</button>

<p id="indice"></p>
<input type="hidden" id="indiceScore" name="indiceShowed" value="0"></hidden>



<script>
function getIndice() {
    document.getElementById("indice").innerHTML = "{$question->getIndice()}";
  	document.getElementById("indiceScore").value = "1";
}
	</script>	
</form>

HTML
    );

    $page->appendContent($html);
    echo $page->toHTML();
}
else{
    $page->appendJs(<<<JS
        alert("Erreur lors du chargement du questionnaire.");    
JS
    );
    echo $page->toHTML();
    header('Refresh:0;url=menu.php');
}
