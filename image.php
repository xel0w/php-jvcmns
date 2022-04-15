<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include("jwt.php");

$json = file_get_contents('php://input');
$data = json_decode($json);


$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8", "root", "");

$requete = $connexion->prepare(
    "UPDATE users 
    SET usersProfilPicture = :image
     WHERE usersId = :id"
);

$requete->execute(
[
    "namefile" => $data->image,
    "id" => $data->id
]
);

$utilisateur = $requete->fetch();