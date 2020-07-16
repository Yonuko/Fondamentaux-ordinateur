<?php

    $requestParam = $request->getBody();

    $rqt = "SELECT password FROM users WHERE email = ?;";
    $passwordHash = sendRequest($rqt, [$requestParam["login"]], PDO::FETCH_NUM)[0][0];

    // Si l'email est fausse on vérifie qu'il ne sagit pas du nom
    if(is_null($passwordHash)){
        $rqt = "SELECT password FROM users WHERE name = ?;";
        $passwordHash = sendRequest($rqt, [$requestParam["login"]], PDO::FETCH_NUM)[0][0];
    }

    if(is_null($passwordHash)){
        $_SESSION["misstake"] = "login";
        header("Location:http://localhost/portfolio/login");
        return;
    }

    if(password_verify($requestParam["password"], $passwordHash)){
        unset($_SESSION["misstake"]);
        $rqt = "SELECT name FROM users WHERE email = ?;";
        $_SESSION["name"] = sendRequest($rqt, [$requestParam["login"]], PDO::FETCH_NUM)[0][0];
        if(is_null($_SESSION["name"])){
            $_SESSION["name"] = $requestParam["login"];
            $rqt = "SELECT user_id FROM users WHERE name = ?;";
            $_SESSION["id"] = sendRequest($rqt, [$requestParam["login"]], PDO::FETCH_NUM)[0][0];
        }else{
            $rqt = "SELECT user_id FROM users WHERE email = ?;";
            $_SESSION["id"] = sendRequest($rqt, [$requestParam["login"]], PDO::FETCH_NUM)[0][0];
        }
        header("Location:http://localhost/portfolio/admin");
        return;
    }else{
        $_SESSION["misstake"] = "password";
        header("Location:http://localhost/portfolio/login");
        return;
    }