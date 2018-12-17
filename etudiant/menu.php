<?php

require_once '../class/user.class.php';
require_once '../class/webpage.class.php';
require_once '../include/header.php';
session_start();
$user = User::searchFromLogin($_SESSION['pseudo']);
$page = new WebPage("Menu étudiant");

$page->appendCssUrl("../css/demo.css");
$page->appendCssUrl("../css/style.css");
$page->appendCssUrl("../css/style2.css");

$page->appendContent("Bienvenue ".$user->getPrenom()." ".$user->getNom());

$page->appendContent(<<<HTML
	<br>
	<a href="questionnaire.php?q=1"><button>Commencer le questionnaire</button></a>
HTML
);

echo $page->toHTML();