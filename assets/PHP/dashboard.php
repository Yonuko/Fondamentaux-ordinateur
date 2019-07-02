<?php

    include("assets/PHP/DashBoard/Competences.php");
    include("assets/PHP/DashBoard/Projets.php");
    include("assets/PHP/DashBoard/Presentation.php");
    include("assets/PHP/DashBoard/CV.php");

    $debug = parse_ini_file("debug.ini");
    $params = parse_ini_file("db.ini");

    error_reporting(E_ALL);
    ini_set("display_errors", (bool)$debug["production"]);

    // Connexion a la base de données
    $db = new PDO($params["url"], $params["user"], $params["pass"]);

    // Affiche le nom de l'utilisateur connecté et le boutton deconnexion
    if(isset($_SESSION["login"]) && isset($_SESSION["id"])){

        if((isset($_SESSION['page']) && $_SESSION['page'] == 1)){
            // Affiche l'onglet de présentation
            ShowPresentationForm($db);
            $_SESSION['page'] = 1;
        }else if((isset($_SESSION['page']) && $_SESSION['page'] == 2)){
            // Affiche l'onglet du CV
            ShowCVInfos($db);
            $_SESSION['page'] = 2;
        }else if((isset($_SESSION['page']) && $_SESSION['page'] == 3)) {
            //Affiche l'onglet des compétences
            ShowCompetences($db);
            $_SESSION['page'] = 3;
        }else if((isset($_SESSION['page']) && $_SESSION['page'] == 4)){
            // Affiche l'onglet des projets
            ShowProjects($db);
            $_SESSION['page'] = 4;
        }else if((isset($_SESSION['page']) && $_SESSION['page'] == 0)){
            // Affiche l'acceuil
            ManagementButtons($db);
        }
    }

    // Affiche la liste des onglets possible
    function ManagementButtons($db){
        if(isset($_POST["goMessage"])){
            $rqt = "SELECT * FROM message ORDER BY readed;";
            $messages = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
            for($i = 0; $i < sizeof($messages); $i++){
                $nom = $messages[$i][1];
                $prenom = $messages[$i][2];
                $date = $messages[$i][3];
                $objet = $messages[$i][4];
                $message = $messages[$i][5];
                $readed = $messages[$i][6];
                echo "<section style='text-align:center; border-style: solid; width: 60%; left: 20%; position: relative;'>";
                if($readed){
                    echo "<p style='font-size: 1.5vw;'>$objet</p><br>";
                }else {
                    echo "<p style='font-size: 1.5vw; color: red'>$objet</p><br>";
                }
                echo "
                        $message<br>
                        <p>$prenom $nom : $date</p><br><br>";
                echo "</section>";
            }
            exit;
        }

        $rqt = "SELECT count(*) FROM message WHERE readed = false;";
        $messageCount = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
        echo "<form action='#' method='post'>";
        if(!$messageCount){
            echo "Aucun nouveau message ";
        }else{
            echo "Vous avez " . $messageCount[0][0] . " message(s) en attente ";
            echo "<input type='submit' name='goMessage' value='messages'>";
        }
        echo "</form>";
    }

    // Affiche le boutton de retour
    function returnButton(){

        if(isset($_POST["return"])){
            $_SESSION['page'] = 0;
        }

        echo "<form action='#' method='POST'>
                <input type='submit' name='return' value='Retour'>
              </form><br>";
    }

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