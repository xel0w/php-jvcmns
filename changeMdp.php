<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");


include("jwt.php");

$json = file_get_contents('php://input');
$data = json_decode($json);
$mot = $data->mdp;
$mdp = password_hash($mot,PASSWORD_DEFAULT);

$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8", "root", "");
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


$requete = $connexion->prepare(
    "UPDATE users 
    SET usersMotDePasse = :mdp 
    WHERE usersId = :id"
);
$requete->execute([
    "mdp" => $mdp,
    "id" => $data->id
]);
