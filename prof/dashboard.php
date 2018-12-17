<?php
require_once '../include/header.php';
require_once '../class/webpage.class.php';
require_once '../class/score.class.php';
require_once '../class/user.class.php';
require_once '../class/question.class.php';

$scores = Score::getAllScore();
$scoreMax = Question::getAllScore();
$page = new WebPage("Dashboard");
$scoreMax = $scoreMax["SUM(scoreMax)"];


$page->appendContent(<<<HTML
<table>
      <tr><th>Elève</th><th>Question</th><th>Score</th><th>Score total</th></tr>
    
HTML
);
for($i = 0;$i<count($scores);$i++){
    $test = User::searchById($scores[$i]->getIdUser())->getPseudo();
    $scoreEleve = Score::getScoreById(User::searchById($scores[$i]->getIdUser())->getNum());
    $scoreEleve = $scoreEleve["SUM(score)"];
    $page->appendContent("<tr><td>{$test}</td><td>{$scores[$i]->getIdQuestion()}</td><td>{$scores[$i]->getScore()}</td><td>{$scoreEleve}/{$scoreMax}</td></tr>");
}

$page->appendContent(<<<HTML
    </table>
HTML
);

echo $page->toHTML();

header("Refresh:10");