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
    "DELETE FROM jeux WHERE jeuxId = :jeuxId"
);

$requete->execute([
    "jeuxId" => $data->jeuxId
]);

