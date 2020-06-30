<?php

session_name("PortfolioSE");
session_start();

function sendRequest($rqt, $db, $formInput, $type){
    $gotValue = false;
    $rqtHolder = $db->prepare($rqt);
    $rqtHolder->execute($formInput);
    $tab = [];
    while ($ligne = $rqtHolder->fetch($type)) {
        $gotValue = true;
        foreach ($ligne as $val) {
            array_push($tab, $val);
        }
    }
    // Si aucune ligne n'a été lu renvoie false, sinon renvoie un tableau constituer des valeurs retrouné
    return ($gotValue) ? $tab : $gotValue;
}

if(!extension_loaded('pdo')){
    echo "<script>alert('Tu n\'as pas l\'extension dégage')</script>";
    return;
}

include_once 'assets/PHP/Router/Route.php';