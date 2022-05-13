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
"SELECT *
FROM jeux
INNER JOIN users ON jeux.jeuxAddedBy = users.usersId
WHERE usersId = :id"
);

$requete->execute(
    [
        "id" => $data->id
    ]
);

$listeJeux = $requete->fetchAll();

echo json_encode($listeJeux);