<?php
    session_name("PortfolioSE");
    session_start();

    // Parse le fichier de configuration, pour se connecter à la base de données
    $params = parse_ini_file("db.ini");

    $requestParam = $request->getBody();

    // Connexion a la base de données
    $db = new PDO($params["url"], $params["user"], $params["pass"]);

    $rqt = "SELECT password FROM users WHERE email = ?;";
    $passwordHash = sendRequest($rqt, $db, [$requestParam["login"]], PDO::FETCH_NUM)[0];

    if(is_null($passwordHash)){
        $_SESSION["misstake"] = "login";
        header("Location:http://localhost/portfolio/login");
        return;
    }

    if(password_verify($requestParam["password"], $passwordHash)){
        unset($_SESSION["misstake"]);
        $rqt = "SELECT name FROM users WHERE email = ?;";
        $_SESSION["name"] = $passwordHash = sendRequest($rqt, $db, [$requestParam["login"]], PDO::FETCH_NUM)[0];
        $rqt = "SELECT user_id FROM users WHERE email = ?;";
        $_SESSION["id"] = sendRequest($rqt, $db, [$requestParam["login"]], PDO::FETCH_NUM)[0];
        header("Location:http://localhost/portfolio/admin");
        return;
    }else{
        $_SESSION["misstake"] = "password";
        header("Location:http://localhost/portfolio/login");
        return;
    }

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