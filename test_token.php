<?php

    include("jwt.php");

    //$_POST['pseudo'] +++ $_POST['mdp]

    //recherche l'utilisateur dans bdd

    //c'est un admin + son id est 42

    // echo getJwt([
    //     "id" => 42,
    //     "admin" => true
    // ]);
    echo isJwtValid("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6NDMsImFkbWluIjp0cnVlfQ.CN4R9GJ-phvks3l-XZhI2reuCWuEJdTL7FzmylbUTdw");