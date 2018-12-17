<?php
try
{
    $pdo = new PDO('mysql:host=localhost;dbname=progweb', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
    $error = 'Impossible de se connecter à la base de données'.$e->getMessage();
    exit();
}