<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$json = file_get_contents('php://input');
$data = json_decode($json);

$connexion = new PDO("mysql:host=localhost:3306;dbname=mns_blog_2022;charset=UTF8","root",""); 
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "SELECT * 
    FROM article
    WHERE titre LIKE :recherche
    OR texte LIKE :recherche"
);

$requete->execute(
    ["recherche" => "%". $data->recherche."%"]
);

$listeArticle = $requete->fetchAll();

echo json_encode($listeArticle);