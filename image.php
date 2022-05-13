<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include("jwt.php");

$json = file_get_contents('php://input');
$data = json_decode($json);


$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8", "root", "");
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "UPDATE users 
    SET usersProfilPicture = :namefile 
    WHERE usersId = :id"
);


$requete->execute(
    [
        "namefile" => $data->namefile,
        "id" => $data->id
    ]
);
$utilisateurs = $requete->fetch();

$requete = $connexion->prepare(
    "SELECT usersId, usersPseudo, usersAdmin, usersActif, usersProfilPicture, usersMail
         FROM users 
         WHERE usersId = :id"
);

$requete->execute(
    [
        "id" => $data->id
    ]
);
$utilisateur = $requete->fetch();
echo json_encode(["token" => getJwt($utilisateur), "profilPicture" => $data->namefile]);


    // "UPDATE users 
    // SET usersProfilPicture = :namefile 
    // WHERE usersId = :id"