<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$connexion = new PDO("mysql:host=localhost:3306;dbname=mns_blog_2022;charset=UTF8","root",""); 
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "SELECT * FROM article"
);

$requete->execute();

$listeArticle = $requete->fetchAll();

echo json_encode($listeArticle);