<?php

require_once '../include/header.php';
require_once '../class/question.class.php';
require_once '../class/theme.class.php';
require_once '../class/webpage.class.php';


$page = new webpage("Test");

$themes = theme::getAllThemes();
$html = '';

$html.=(<<<HTML
	<form name="toast" method="GET" action="addSelectedOnes.php">
HTML
);
foreach ($themes as $theme) {
	$html.=(<<<HTML
	<div id="wrapper">
	<h2>{$theme->getNomTheme()}</h2>
</div>
		
HTML
);
	foreach ($theme->getQuestions() as $question) {
		$html.=(<<<HTML
			<label for="{$question->getIdQuestion()}">{$question->getIntituleQuestion()}</label>
			<input name="questions[]" value="{$question->getIdQuestion()}" type="checkbox">  </br></br></br>
			
HTML
	);
	}
}
$html.=(<<<HTML
	</br></br></br><button type="submit">Envoyer</button>
	</form>
HTML
);
$page->appendContent($html);
echo $page->toHTML();