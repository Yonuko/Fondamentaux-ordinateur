<?php

    $debug = parse_ini_file("debug.ini");
    ini_set("display_errors", (bool)$debug["production"]);

    // Vérifie que le navigateur support le PDO
    if (!extension_loaded ('PDO')) {
        echo "Erreur, impossible communiquer avec la base de données sur votre navigateur";
        return;
    }

    //Si les essaye n'ont pas été créer, les instanties
    if(!isset($_SESSION["essaie"])){
        $_SESSION["essaie"] = 5;
    }

	//Si il n'y a plus d'essaie deconnecte la personne
	if($_SESSION["essaie"] <= 1){
		echo "Vous n'avez plus le droit à aucun essaie";
		header("Refresh: 1.2; url=index.php");
		return;
	}

	// Parse le fichier de configuration, pour se connecter à la base de données
	$params = parse_ini_file("db.ini");

    // Connexion a la base de données
    $db = new PDO($params["url"], $params["user"], $params["pass"]);

    // Si il existe déjà une connexion, on affiche le dashBoard, sinon on affich le formulaire de connexion
	if(isset($_SESSION["login"]) && isset($_SESSION["id"])){
        include("dashboard.php");
	}else{
        // Affiche le formulaire de connexion
        HaveToLog();
    }
	
	// Si on appuie sur le boutton "se connecter"
    if(isset($_POST["connect"]) && $_POST["connect"] && $_SESSION["essaie"] > 0){
        connection($db);
    }
	
	// Gère la connexion
    function connection($db){

        //On vérifie que le login et le password existent est ne sont pas vide
        if(!isset($_POST['login']) || $_POST['login'] == "" || !isset($_POST["password"])){
            return;
        }

        // Vérifie que l'utilisateur existe
        $rqt = "SELECT * FROM administrator WHERE login = ?;";
        if(!SendRequest($rqt, $db, [$_POST['login']], PDO::FETCH_ASSOC)){
			$_SESSION["essaie"]--;
            echo "Login incorrect, il vous reste " . $_SESSION["essaie"] . " essaie(s)";
            return;
        }

        // Récupère les données de l'utilisateur
        $tab = SendRequest($rqt, $db, [$_POST['login']], PDO::FETCH_ASSOC);
        if(hash("sha512", $_POST["password"]) == $tab[2]){
            $_SESSION["login"] = $tab[1];
            $_SESSION["id"] = $tab[0];
            $_SESSION["page"] = 0;
			// Recharge la page pour actualiser la connexion
            header("Refresh:0");
        }else{
			$_SESSION["essaie"]--;
            echo "Mauvais mot de passe, il vous reste " . $_SESSION["essaie"] . " essaie(s)";
        }
    }

    // Affiche le formulaire de gestion
	function HaveToLog(){
        echo"
        <form action=\"#\" method=\"POST\" class='connexion'>
            <p>Connexion:</p>
            <input type=\"text\" name=\"login\"><br>
            <input type=\"password\" name=\"password\"><br>
            <input type=\"submit\" name=\"connect\" value=\"Se connecter\"><br><br>
        </form>";
    }
	
	/* Cette fonction execute la requête SQL envoyer, renvoie un tableau des valeurs retourner, sinon retourn false
	si aucune valeur n'est trouver*/
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