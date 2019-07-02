<?php

    // Si un des champ est vide, redirige vers la page principale
    if(!isset($_POST["Message"]) || !isset($_POST["nom"]) || !isset($_POST["prenom"]) || !isset($_POST["Subject"])){
        echo "<p style='color: red; margin-top: 40vh; text-align:center; font-size:2vw;'>Veuillez compléter tous les champs</p>";
        header("Refresh:3; url=http://www.sacha-eghiazarian.fr#Contact");
        exit;
    }

    $params = parse_ini_file("db.ini");

    // Connexion a la base de données
    $db = new PDO($params["url"], $params["user"], $params["pass"]);

    // Insert le message dans la base de données
    $rqt = "INSERT INTO message (nom, prenom, sentDate, objet, message) VALUES (?,?, now(),?,?);";
    SendRequestTab($rqt, $db, [
        $_POST["nom"], $_POST["prenom"], $_POST["Subject"], $_POST["Message"]
    ], PDO::FETCH_NUM);

    // Envoie par mail le message envoyer
    mail("sacha.eghiazarian@ynov.com", $_POST["Subject"] . " - " . $_POST["nom"] . " " . $_POST["prenom"],
        $_POST["Message"], "From: sacha.eghiazarian@ynov.com");

    echo "Votre message à bien été envoyé";

    header("Refresh:3; url=http://www.sacha-eghiazarian.fr");

    /* Cette fonction execute la requête SQL envoyer, renvoie un tableau à double dimension des valeurs retourner,
    sinon retourne false si aucune valeur n'est trouver*/
    function SendRequestTab($rqt, $db, $formInput, $type){
        $gotValue = false;
        $rqtHolder = $db->prepare($rqt);
        $rqtHolder->execute($formInput);
        $tab = [];
        while ($ligne = $rqtHolder->fetch($type)) {
            $gotValue = true;
            $temp = [];
            foreach ($ligne as $val) {
                array_push($temp, $val);
            }
            array_push($tab, $temp);
        }
        // Si aucune ligne n'a été lu renvoie false, sinon renvoie un tableau constituer des valeurs retrouné
        return ($gotValue) ? $tab : $gotValue;
    }			