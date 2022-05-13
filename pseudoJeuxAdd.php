<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include("jwt.php");

$json = file_get_contents('php://input');
$data = json_decode($json);

$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8","root",""); 
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
"SELECT `usersPseudo` FROM users INNER JOIN jeux WHERE users.usersId = jeux.jeuxAddedBy"
);

$requete->execute();

$listePseudo = $requete->fetchAll();

echo json_encode($listePseudo);