<?php

require_once '../class/webpage.class.php';

$page = new webpage("Ajout des questions");
file_put_contents("./questions.json", json_encode($_GET, JSON_FORCE_OBJECT));
$page->appendJS(<<<JS
	alert("Questions ajoutées");
JS
);
header("Refresh: 0;url=selectionQuestions.php");
echo $page->toHTML();
