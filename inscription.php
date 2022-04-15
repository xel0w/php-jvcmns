<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include("jwt.php");

$json = file_get_contents('php://input');
$data = json_decode($json);
$mot = $data->motDePasse;
$mdp = password_hash($mot,PASSWORD_DEFAULT);

$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8", "root", "");
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


$requete = $connexion->prepare(
    "SELECT COUNT(*) AS nbr 
    FROM users
    WHERE usersPseudo = :pseudo
    OR usersMail = :mail"
);
$requete->execute([
    "pseudo" => $data->pseudo,
    "mail" => $data->mail
]);
$utilisateurs = $requete->fetch();
if(!($utilisateurs['nbr'])==0){
    echo json_encode(["erreur" => "Pseudo ou Mail est déja utilisé"]);
}else{
    echo json_encode(["ok" => ""]);
}
    $requete = $connexion->prepare(
    "INSERT INTO users (usersPseudo, usersMotDePasse, usersMail)
    VALUES (:pseudo, :mot_de_passe, :mail)"
);

$requete->execute(
[
    "pseudo" => $data->pseudo,
    "mot_de_passe" => $mdp,
    "mail" => $data->mail,
]
);
