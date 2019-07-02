<?php
	session_name("PortfolioSE");
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="fr">
<head>
	<link rel="stylesheet" href="./assets/styles/main.min.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Admin Connection</title>
</head>
<body>

    <?php
    // Ajoute les bouttons de retour vers le dashboard lorsque l'on est connecté.
    if(isset($_SESSION["login"])){
        echo "<span style='width: 100vw; background-color: grey; height: 4vh; position: fixed; padding: 0.2%;'>
                <form action='#' method='post'>
                    <input type='submit' name='dash' value='DashBoard'>
                    <input type='submit' name='comp' value='Compétences'>
                    <input type='submit' name='projets' value='Projets'>
                    <input type='submit' name='disconnect' value='Deconnexion'>
                </form>
              </span>";
        /*Gère les bouttons de retour, en fonction du boutton cliqué*/
        if(isset($_POST["disconnect"]) && $_POST["disconnect"]){
            // Deconnecte l'utilisateur
            session_unset();
            session_destroy();
            header("Refresh: 0");
        }else if(isset($_POST["dash"]) && $_POST["dash"]){
            // Redirige vers le dashBoard
            $_SESSION["page"] = 0;
            header("Location: Admin.php");
        }else if(isset($_POST["comp"]) && $_POST["comp"]){
            // Redirige vers l'onglêt compétences
            $_SESSION["page"] = 3;
            header("Location: Admin.php");
        }else if(isset($_POST["projets"]) && $_POST["projets"]){
            // Redirige vers l'onglet projets
            $_SESSION["page"] = 4;
            header("Location: Admin.php");
        }
    }

    $debug = parse_ini_file("./assets/PHP/debug.ini");
    $params = parse_ini_file("./assets/PHP/db.ini");

    error_reporting(E_ALL);
    ini_set("display_errors", (bool)$debug["production"]);

    // Connexion a la base de données
    $db = new PDO($params["url"], $params["user"], $params["pass"]);

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

    ?>

    <!-- Cette partie gère la zone d'accueil -->
    <header>
        <section>
            <!-- Liste des boutons du menu -->
            <nav id="Boutton">
                <ul>
                    <li><a href="index.php" style="font-size: 5vh;
            color : #74c2f2;
            font-weight: bold;">Sacha EGHIAZARIAN</a></li>
                    <li><a href="index.php#A-propos">A propos</a></li>
                    <li><a href="index.php#Competence">Mes Compétences</a></li>
                    <li><a href="index.php#Projets">Mes projets</a></li>
                    <li><a href="index.php#Contact">Contact</a></li>
                </ul>
            </nav>
        </section>
    </header>

    <section class="Contenu" style="width:70%; margin-bottom: 10vh;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <img src="assets/images/CV/CVHeader.png">
                    <p style="width: auto; text-align: right;left:-34%; top: -39%; font-size: 26px; color: white;
                    font-family: 'Arial'; position: relative;"><b>
                    <?php
                    // Affiche dynamiquement mon niveau d'étude actuelle
                    $rqt = "SELECT * FROM CV_Formation;";
                    $subText = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                    echo $subText[0][0];
                    ?>
                    </b></p>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <img src="assets/images/CV/compCV.PNG">
                    <?php
                    // Affiche dynamiquement mes compétences opérationnelle
                    $rqt = "SELECT * FROM comp_fonctionnelle_cv;";
                    $compFonctionnelle = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                    $compFonctionnelle = $compFonctionnelle[0][0];
                    echo "<p style='font-size: 12px;'>$compFonctionnelle</p>";
                    ?>
                </div>
                <div class="col-4">
                    <img src="assets/images/CV/ExpCV.PNG">
                    <?php
                    // Affiche dynamiquement mes expériences professionnelle
                    $rqt = "SELECT * FROM experience_cv;";
                    $exps = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                    for($i = 0; $i < sizeof($exps); $i++){
                        $socityName = explode("-", $exps[$i][1])[0];
                        $name = str_replace($socityName, "", $exps[$i][1]);
                        $message = $exps[$i][2];
                        $link = $exps[$i][3];
                        echo "<p><b><a href='$link' style='text-decoration: underline; color: red; font-size: 20px;'>$socityName</a></b>$name</p>
                        <p>$message</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <img src="assets/images/CV/DiplomeCV.PNG">
                    <?php
                    // Affiche dynamiquement mes diplomes
                    $rqt = "SELECT * FROM diplomes;";
                    $diplome = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                    for($i = 0; $i < sizeof($diplome); $i++){
                        $date = $diplome[$i][1];
                        $info = $diplome[$i][2];
                        echo "- $date : $info";
                    }
                    ?>
                </div>
                <div class="col-8">
                    <img src="assets/images/CV/TechnoCV.PNG">
                    <?php
                    // Affiche dynamiquement mes compétences
                    $rqt = "SELECT * FROM certification;";
                    $certif = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                    $rqt = "SELECT * FROM competences WHERE `name` not in ((SELECT name FROM certification)) ORDER BY niveau DESC;";
                    $comps = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                    for($i = 0; $i < sizeof($certif); $i++){
                        $certifName = $certif[$i][1];
                        echo "<div class='container'>
                                <div class='row'>
                                    <div class='col'>
                                        $certifName
                                    </div>
                                    <div class='col-7'>
                                        Certifié
                                    </div>
                                </div>";
                    }
                    for($i = 0; $i < sizeof($comps); $i++){
                        $name = $comps[$i][1];
                        $niveau = $comps[$i][3];
                        echo "<div class='row'>
                                <div class='col'>
                                    $name
                                </div>
                                <div class='col-7'>";
                        if($niveau >= 90){
                            echo "Confirmé";
                        }else if($niveau >= 60){
                            echo "Intermediaire";
                        }else{
                            echo "Débutant";
                        }
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                    ?>
                </div>
            </div>
            <div class="row" style="margin-top: 5vh;">
                <div class="col-3" style="text-align: center;">
                    <img src="assets/images/CV/CVMail.PNG" alt="Pictogramme indiquant la présence de mon adresse mail">
                </div>
                <div class="col-3" style="text-align: center;">
                    <img src="assets/images/CV/PhoneCV.PNG" alt="Pictogramme indiquant la présence de mon numéro de téléphone">
                </div>
                <div class="col-3" style="text-align: center;">
                    <img src="assets/images/CV/LinkedInCV.PNG" alt="Pictogramme indiquant la présence de mon compte linkedIn">
                </div>
            </div>
            <div class="row">
                <div class="col-3" style="text-align: center;">
                    <a href="mailto:sacha.eghiazarian@ynov.com">sacha.eghiazarian@ynov.com</a>
                </div>
                <div class="col-3">
                    <p style="text-align: center;">0695209755</p>
                </div>
                <div class="col-3" style="text-align: center;">
                    <a href="https://www.linkedin.com/in/sacha-eghiazarian/">https://www.linkedin.com/</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
