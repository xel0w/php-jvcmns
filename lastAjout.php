<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8","root",""); 
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "SELECT * FROM jeux   
    ORDER BY jeuxId DESC LIMIT 1"
);

$requete->execute();

$listeJeux = $requete->fetchAll();

echo json_encode($listeJeux);