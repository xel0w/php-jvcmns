<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include("jwt.php");

$json = file_get_contents('php://input');
$data = json_decode($json);
$mot = $data->motDePasse;


$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8", "root", "");
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "SELECT usersMotDePasse, usersId, usersPseudo, usersAdmin, usersActif, usersProfilPicture
     FROM users 
     WHERE usersPseudo = :pseudo"
);

$requete->execute(
    [
        "pseudo" => $data->pseudo
    ]
);

$utilisateur = $requete->fetch();

if (password_verify($mot, $utilisateur["usersMotDePasse"]))
{
  if ($utilisateur) {

    if($utilisateur['usersActif'] == 1) {
        echo json_encode(["token" => getJwt($utilisateur)]);
    } else {
        echo json_encode(["erreur" => "compte desactivé"]);
    }
}
}
else
{
    echo json_encode(["erreur" => "Mauvais mot de passe"]);
}
