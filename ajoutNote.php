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
    "SELECT COUNT(*) AS nbr 
    FROM jeuxxusers
    WHERE jeuxId = :jeuxid
    AND usersId = :id"
);
$requete->execute([
    "jeuxid" => $data->jeuxId,
    "id" => $data->id
]);
$utilisateurs = $requete->fetch();
if ($utilisateurs['nbr'] != 0) {
    echo json_encode(["erreur" => "Vous avez deja donné une note pour ce jeu"]);
} else {
    $requete = $connexion->prepare(
        "INSERT INTO jeuxxusers (jeuxId, usersId, jeuxNote) 
    VALUES (:jeuxid, :id, :note)"
    );

    $requete->execute(
        [
            "jeuxid" => $data->jeuxId,
            "id" => $data->id,
            "note" => $data->note
        ]
    );
    echo json_encode(["status" => "ok"]);
}
