<?php
    session_name("PortfolioSE");
    session_start();
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <link rel="stylesheet" href="./assets/styles/main.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <meta charset="utf-8">
  <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
  <title>Portfolio Sacha EGHIAZARIAN Bachlor Informatique</title>
  <meta name="description" content="Je m'appelle Sacha EGHIAZARIAN, et voici mon Portfolio. Sur ce site vous pourrez trouver mon CV,
   mes différents projets ainsi que mes compétences." />
   <meta name="keywords" content="Informatique, étudiant, portfolio, Sacha, EGHIAZARIAN,ynov
   IngéSup, bachlor,Bravery of history, tripode, C, C#, HTML, PHP, JavaScript, Unity,
   CCNA1, Python">
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
    ini_set("display_errors", (bool)$debug["production"]);

    // Initialise la connexion avec la base de donnée
    $params = parse_ini_file("./assets/PHP/db.ini");
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

  <main>
    <!-- Cette partie gère la zone d'accueil -->
    <header>
      <section id="Accueil">
        <!-- Liste des boutons du menu -->
        <nav id="Boutton">
          <ul>
            <li><a href="#Accueil" style="font-size: 5vh;
            color : #74c2f2;
            font-weight: bold;">Sacha EGHIAZARIAN</a></li>
            <li><a href="#A-propos">A propos</a></li>
            <li><a href="#Competence">Mes Compétences</a></li>
            <li><a href="#Projets">Mes projets</a></li>
            <li><a href="#Contact">Contact</a></li>
          </ul>
        </nav>
      </section>
    </header>

    <!-- Cette section gère la partie "A-propos" -->
    <section id="A-propos">
      <!-- Cette section permet de déplacer le contenu général de la page internet -->
      <section class="Contenu">
        <br><br>
        <!-- Cette section gère le contenu de la partie "A propos" -->
        <section class="A-propos">
          <h1 class="title">A Propos</h1><br>
          <p>Je m'appelle Sacha EGHIAZARIAN, j'ai
		  <?php
                // Calcule dynamiquement mon âge actuel et l'affiche
                $today = date("d-m-Y");
				$diff = date_diff(date_create("20-11-2000"), date_create($today));
				echo $diff->format('%y');?>
			ans et voici mon Portfolio. Sur ce site vous pourrez trouver mon CV, mes différents projets,
            ainsi que mes compétences.<br>
            <?php
                // Affiche la valeur de la table a-propos
                $rqt = "SELECT * FROM a_propos;";
                echo SendRequestTab($rqt,$db, [], PDO::FETCH_NUM)[0][0];
            ?>
          </p>
          <form action="CV.php" method="post">
            <input type="submit" name="button" class="CVbutton" value="Voir mon CV" style="margin-bottom: 5vh;">
          </form>
        </section>
      </section>
    </section>

      <!-- Affiche une image -->
      <section id="Programming"></section>

      <section id='Competence'>

          <!-- Cette section permet de déplacer le contenu général de la page internet -->
          <section class="Contenu"><br><br>

              <!-- Cette section gère la partie "Mes compétences" -->
              <section class="competence">
                  <h3 class="title">Mes Compétences</h3><br><br>
                  <div class="container">
                      <div class="row">
                          <div class="col">
                              <p>Developpement:</p>
                              <?php
                              // Afficher toutes les compétences de type Dev
                              $rqt = "SELECT * FROM competences WHERE `type` = 'Dev' AND active = 1 ORDER BY niveau DESC;";
                              $competences = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                              for($i = 0; $i < sizeof($competences); $i++){
                                  $compNameDisplay = $competences[$i][1];
                                  $compName = str_replace(" ", "", $competences[$i][1]);
                                  $compLevel = $competences[$i][3];
                                  echo "<div class='progress Dev'>";
                                  echo "<div class=\"progress-bar\" role=\"progressbar\" data-max-value=\"$compLevel\" style=\"width: 1%\">$compNameDisplay</div>";
                                  echo "</div>";
                              }
                              ?>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col">
                              <p>Developpement Web:</p>
                              <?php
                              // Afficher toutes les compétences de type Web
                              $rqt = "SELECT * FROM competences WHERE `type` = 'Web' AND active = 1 ORDER BY niveau DESC;";
                              $competences = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                              for($i = 0; $i < sizeof($competences); $i++){
                                  $compNameDisplay = $competences[$i][1];
                                  $compName = str_replace(" ", "", $competences[$i][1]);
                                  $compLevel = $competences[$i][3];
                                  echo "<div class='progress Web'>";
                                  echo "<div class=\"progress-bar\" role=\"progressbar\" data-max-value=\"$compLevel\" style=\"width: 1%\">$compNameDisplay</div>";
                                  echo "</div>";
                              }
                              ?>
                          </div>
                          <div class="col">
                              <p>Infrastructure:</p>
                              <?php
                              // Afficher toutes les compétences de type Infra
                              $rqt = "SELECT * FROM competences WHERE `type` = 'Infra' AND active = 1 ORDER BY niveau DESC;";
                              $competences = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
                              for($i = 0; $i < sizeof($competences); $i++){
                                  $compNameDisplay = $competences[$i][1];
                                  $compName = str_replace(" ", "", $competences[$i][1]);
                                  $compLevel = $competences[$i][3];
                                  echo "<div class='progress Infra'>";
                                  echo "<div class=\"progress-bar\" role=\"progressbar\" data-max-value=\"$compLevel\" style=\"width: 1%\">$compNameDisplay</div>";
                                  echo "</div>";
                              }
                              ?>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col">
                              <p>Langues:</p>
                              <div class="progress Langue">
                                  <div class="progress-bar" role="progressbar" data-max-value="100" style="width: 1%">Français</div>
                              </div>
                              <div class="progress Langue">
                                  <div class="progress-bar" role="progressbar" data-max-value="90" style="width: 1%">Anglais</div>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col">
                              <p>Microsoft / Divers:</p>
                              <div class="progress Other">
                                  <div class="progress-bar" role="progressbar" data-max-value="80" style="width: 1%">Microsoft Excel</div>
                              </div>
                              <div class="progress Other" style="margin-bottom: 5vh;">
                                  <div class="progress-bar" role="progressbar" data-max-value="70" style="width: 1%;">Microsoft Word</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>
          </section>
      </section>

    <!-- Affiche une image -->
    <section id="Unity"></section>

    <section id="Projets">
      <!-- Cette section permet de déplacer le contenu général de la page internet -->
      <section class="Contenu"><br><br>
        <!-- Cette section gère la partie "Mes projets" -->
        <section class="Projets">

          <h2 class="title">Mes projets</h2><br><br>
            <div class="container">
              <div class="row">
                <?php
                    // Recupère la liste des projets
                    $rqt = "SELECT projet_id, name, logo FROM projets ORDER BY projet_id;";
                    $projets = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);

                    // Affiche tous les projets
                    for($i = 0; $i < sizeof($projets); $i++){
                        $projetID = $projets[$i][0];
                        $projetName = $projets[$i][1];
                        $img = $projets[$i][2];
                        // Classe les projets 3 par 3 sur une ligne
                        if($i % 3 == 0 && $i != 0){
                            // Ferme la ligne precedante, et créer la nouvelle
                            echo "</div><div class='row'>";
                        }
                        echo "<div class='col-4'>
                                <img src='$img' onmousedown='
                                window.location.href = \"Projets.php?id=$projetID\";
                                ' alt=\"Lien cliquable vers les infos concernant le projet " . $projetName . "\" style='margin-bottom: 5vh;'>
                                <p class='ProjectHover'>En savoir plus sur $projetName</p>
                              </div>";
                    }
                ?>
            </div>
          </section>
      </section>
    </section>

    <!-- Affiche une image -->
    <div id="ContactImage"></div>

    <!-- Ce footer gère la partie "Contact" -->
    <footer id="Contact">
      <section class="Contenu"><br><br>
        <h4 class="title">Contact</h4><br>
        <a class="MyMail" href="mailto:sacha.eghiazarian@ynov.com">
          <img src="./assets/images/Icons/iconfinder_Mail_194919.png" alt="M'envoyer un mail a l'address : sacha.eghiazarian@ynov.com">
        </a>
        <a class="LinkedIn" href="https://www.linkedin.com/in/sacha-eghiazarian-b3bba5170" target="_blank">
          <img src="./assets/images/Icons/iconfinder_LinkedIn_194920.png" alt="Compte LinkedIn : https://www.linkedin.com/in/sacha-eghiazarian-b3bba5170">
        </a>
        <button id="ContactButton" type="button" name="button">Me contacter</button>
        <form id="ContactMe" action="assets/PHP/sendMessage.php" method="post">
          <p>Contactez moi</p>
          <input type="text" name="prenom" placeholder=" Prénom...">
          <input type="text" name="nom" placeholder=" Nom...">
          <input type="text" name="Subject" placeholder=" Objet...">
          <textarea name="Message" rows="8" cols="80" placeholder=" Message..."></textarea>
          <script>
              CKEDITOR.replace("Message");
              CKEDITOR.config.width='50vw';
          </script>
          <br><br>
          <input type="submit" name="Envoyer" value="Envoyer">
        </form>
      </section>
    </footer>
  </main>

  <script type="text/javascript" src="assets/script/Animation.js"></script>
  <script type="text/javascript" src="assets/script/Contact.js"></script>
</body>
</html>
