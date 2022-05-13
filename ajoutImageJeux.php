<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

if($_FILES){
    $target_dir = "uploads/jeux/";
    echo $target_file = $target_dir . basename($_FILES["myFile"]["name"]);
    move_uploaded_file($_FILES["myFile"]["tmp_name"], $target_file);
    echo json_encode(["erreur"=>"ok"]);
}
