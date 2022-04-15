<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$json = file_get_contents('php://input');
$data = json_decode($json);

$connexion = new PDO("mysql:host=localhost:3306;dbname=mns_blog_2022;charset=UTF8","root",""); 
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "DELETE
    FROM article
    WHERE id = :id"
);

echo $requete->execute(
    ["id"=> $data->id]
);

