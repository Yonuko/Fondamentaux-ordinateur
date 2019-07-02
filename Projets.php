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
	
	<!-- Affiche le contenu du projet séléctionné -->
	<section class="Contenu">
		<?php 
			include("assets/PHP/ProjectDisplay.php");
		?>
	</section>
</body>
</html>
