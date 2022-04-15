<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("jwt.php");

$token = getBearerToken();

if($token && isJwtValid($token)){

    $utilisateur = getPayload($token);

    if($utilisateur->admin){


        $json = file_get_contents('php://input');

        $data = json_decode($json);

        $connexion = new PDO("mysql:host=localhost:3306;dbname=mns_blog_2022;charset=UTF8","root",""); 
        $connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $requete = $connexion->prepare("INSERT INTO article (titre, texte, sous_titre) VALUES (:titre, :texte, :sous_titre)");

        $requete->execute(
            [
                "titre" => $data->titre,
                "texte" => $data->texte,
                "sous_titre" => $data->sous_titre,
            ]
        );
        echo json_encode(["reponse" => "Article ajouté"]);
    }else{
        echo json_encode(["reponse" => "Droit insuffisants"]);
    }
}else{
    echo json_encode(["reponse" => "Vous n'êtes pas connecté"]);

}