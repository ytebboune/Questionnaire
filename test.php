<?php

require_once 'class/question.class.php';
require_once 'class/reponse.class.php';
require_once 'class/webpage.class.php';

$page = new webpage("Test");
$questions = question::getAllQuestions();

$html='';

$html.=(<<<HTML
	<form name="toast" method="GET" action="check.php">
HTML
);
foreach ($questions as $question) {
	$reponses = Reponse::getReponsesFromQuestion($question->getIdQuestion());
	$html.=(<<<HTML
		<h2>{$question->getIntituleQuestion()}</h2>
HTML
);
	foreach ($reponses as $reponse) {
		$html.=(<<<HTML
			<div>
    	<input name="answer" type="radio" value="{$reponse->getIdReponse()}" id="toast">
    	<label for="mark">{$reponse->getIntituleReponse()}</label>
 			</div>
HTML
);	
	}
}
$page->appendContent($html);
echo $page->toHTML();