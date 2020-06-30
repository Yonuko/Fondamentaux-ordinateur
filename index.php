<?php

session_name("PortfolioSE");
session_start();

if(!extension_loaded('pdo')){
    echo "<script>alert('Tu n\'as pas l\'extension dégage')</script>";
    return;
}

include_once 'assets/PHP/Router/Route.php';