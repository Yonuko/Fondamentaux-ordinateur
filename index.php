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

// Garde en mémoire les utilisateurs qui sont arrivées sur le site et compte le nombre de page vues
$rqt = "INSERT INTO utilisateurs VALUES (?, ?, 0);";
sendRequest($rqt, [$_SERVER["REMOTE_ADDR"], date("y-m-d")], PDO::FETCH_ASSOC);
if(!(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0') && strpos($_SERVER['REQUEST_URI'], "admin") === false){
    $rqt = "UPDATE utilisateurs SET views = views + 1 WHERE ip = ? AND login_date = ?;";
    sendRequest($rqt, [$_SERVER["REMOTE_ADDR"], date("y-m-d")], PDO::FETCH_ASSOC);
}

function needAdmin(){
    if(!isset($_SESSION["name"]) || !isset($_SESSION["id"])){
        $_SESSION["url"] = $_SERVER["REQUEST_URI"];
        header("location:https://sacha-eghiazarian.fr/login");
        return;
    }else{
        $_SESSION["url"] = null;
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