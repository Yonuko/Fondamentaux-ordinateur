<?php

    // Si aucun projets ne correspond au paramètre de l'url, affiche un message d'erreur et redirige vers la page d'acceuil
    if(!isset($_GET["id"]) || !is_numeric($_GET["id"]) || $_GET["id"] <= 0){
        echo "<p style='text-align: center; top:30vh; font-size: 2vw; position:relative; color:red'>
                Aucun projet n'a été sélétionner, vous aller être rediriger vers la liste des projets
              </p>";
        header("Refresh: 3; url=index.php#Projets");
        return;
    }

    $debug = parse_ini_file("debug.ini");
    $params = parse_ini_file("db.ini");

    error_reporting(E_ALL);
    ini_set("display_errors", (bool)$debug["production"]);

    // Connexion a la base de données
    $db = new PDO($params["url"], $params["user"], $params["pass"]);

    // Affiche le projet séléctionner
    ShowCurrentProject($db);

    function ShowCurrentProject($db){

        $rqt = "SELECT * FROM projets WHERE projet_id = ?";
        $currentProject = SendRequest($rqt, $db, [$_GET["id"]], PDO::FETCH_NUM);
        if(!$currentProject){
            echo "<p style='text-align: center; top:30vh; font-size: 2vw; position:relative; color:red;'>
                    Aucun projet ne corresponds à la valeur sélétionnée, vous aller être rediriger vers la liste des projets
                  </p>";
            header("Refresh: 3; url=index.php#Projets");
            return;
        }

        // Affiche le projet séléctionné
        echo "<h1 style='text-align: center;font-size: 2vw;text-decoration: underline; padding-top:2%;'>$currentProject[1]</h1><br><br>";
        echo "<p style='width:90%;'>$currentProject[2]</p>";
        if($currentProject[5] == "Normal"){
            echo "Lien : <a href='$currentProject[3]'>$currentProject[3]</a>";
        }else if($currentProject[5] == "Video"){
            echo "<iframe src=\"$currentProject[3]\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen style='width: 30vw; height: 30vh;'></iframe>";
        }else if($currentProject[5] == "Image"){
            echo "<img src='$currentProject[3]' alt='Image de présentation du projet $currentProject[1]' style='width:30vw; height:auto'>";
        }
    }

    /* Cette fonction execute la requête SQL envoyer, renvoie un tableau à double dimension des valeurs retourner,
    sinon retourne false si aucune valeur n'est trouver*/
    function SendRequest($rqt, $db, $formInput, $type){
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