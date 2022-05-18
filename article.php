<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include("jwt.php");

$json = file_get_contents('php://input');
$data = json_decode($json);
$img = $data->photo;
$imgmodif = (explode("\\",$img)[2]);

$connexion = new PDO("mysql:host=localhost:3306;dbname=jvc_mns;charset=UTF8", "root", "");
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete = $connexion->prepare(
    "INSERT INTO jeux (jeuxTitre, jeuxGenre, jeuxNote, jeuxEditeur, jeuxAddedBy, jeuxPhoto)
    VALUES (:titre, :genre, :note, :editeur, :id, :photo)"
);

$requete->execute(
    [
        "titre" => $data->titre,
        "genre" => $data->genre,
        "note" => $data->note,
        "editeur" => $data->editeur,
        "id" => $data->id,
        "photo" => $imgmodif
    ]
);
$requete = $connexion->prepare(
    "INSERT INTO jeuxxusers (jeuxId, usersId, jeuxNote)
    VALUES (:jeuxId, :usersId, :jeuxNote)"
);
$requete->execute(
    [
        "jeuxId" => $connexion->lastInsertId(),
        "usersId" => $data->id,
        "jeuxNote" => $data->note,
    ]
);


echo json_encode(["ok" => "ok"]);
