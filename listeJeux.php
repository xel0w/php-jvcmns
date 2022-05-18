<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8","root",""); 
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "SELECT *, ROUND(COALESCE(AVG(ju.jeuxNote),0),1) AS moyenne FROM jeux j 
    JOIN users u
    ON j.jeuxAddedBy = u.usersId 
    LEFT JOIN jeuxxusers ju
    ON ju.jeuxId = j.jeuxId
    GROUP BY j.jeuxId
    ORDER BY jeuxTitre;"
);

$requete->execute();

$listeJeux = $requete->fetchAll();

echo json_encode($listeJeux);