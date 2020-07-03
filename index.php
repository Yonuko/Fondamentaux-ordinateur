<?php

session_name("PortfolioSE");
session_start();

if(!extension_loaded('pdo')){
    echo "<script>alert('Tu n\'as pas l\'extension dégage')</script>";
    return;
}

// Parse le fichier de configuration, pour se connecter à la base de données
$params = parse_ini_file("assets/PHP/db.ini");

// Connexion a la base de données
$db = new PDO($params["url"], $params["user"], $params["pass"]);

function sendRequest($rqt, $formInput, $type){
    global $db;
    $gotValue = false;
    $rqtHolder = $db->prepare($rqt);
    $rqtHolder->execute($formInput);
    $tab = [];
    while ($ligne = $rqtHolder->fetch($type)) {
        $gotValue = true;
        array_push($tab, $ligne);
    }
    // Si aucune ligne n'a été lu renvoie false, sinon renvoie un tableau constituer des valeurs retrouné
    return ($gotValue) ? $tab : null;
}

function needAdmin(){
    if(!isset($_SESSION["name"]) || !isset($_SESSION["id"])){
        header("location:http://localhost/portfolio/login");
        return;
    }
}

include_once 'assets/PHP/Router/Request.php';
include_once 'assets/PHP/Router/Routeur.php';
$router = new Router(new Request);

// If there is method override, we change the method
if(isset($_POST["_method"])){
    header("Access-Control-Allow-Methods: POST");
}

include_once 'assets/PHP/Router/Route.php';