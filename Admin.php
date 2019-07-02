<?php
	session_name("PortfolioSE");
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="./assets/DashBoard CSS/main.css">
	<script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
  <title>Admin Connection</title>
</head>
<body>
    <main>
        <?php

        if(isset($_POST["acceuil"])){
            $_SESSION["page"] = 0;
        }else if(isset($_POST["pres"])){
            $_SESSION["page"] = 1;
        }else if(isset($_POST["cv"])){
            $_SESSION["page"] = 2;
        }else if(isset($_POST["comp"])){
            $_SESSION["page"] = 3;
        }else if(isset($_POST["proj"])){
            $_SESSION["page"] = 4;
        }

        // Gère les redirections en fonction de l'onglet actuel
        $redirect = ["index.php", "index.php#A-propos", "CV.php", "index.php#Competence", "index.php#Projets"];

        if(isset($_SESSION["login"]) && isset($_SESSION["id"])){
            echo "<section class='menu'>";
            echo "Connecté en temps que " . $_SESSION["login"];
            echo "<form action='#' method='post'>
                    <input type='submit' name='disconnect' value='Deconnexion'>
                    <input type='submit' name='goToSite' value='Voir le site'>
                  </from>";
            if(isset($_POST['disconnect']) && $_POST['disconnect']){
                session_unset();
                session_destroy();
                header("Refresh:0");
                return;
            }else if(isset($_POST['goToSite']) && $_POST['goToSite']){
                // Redirige vers le site
                $redirection = $redirect[$_SESSION['page']];
                header("Location: $redirection");
            }
            echo "<nav class=\"menu\">
                    <form action='#' method='post'>
                        <input type=\"submit\" name=\"acceuil\" value=\"Acceuil\"><br>
                        <input type=\"submit\" name=\"pres\" value=\"A propos\"><br>
                        <input type=\"submit\" name=\"cv\" value=\"CV\"><br>
                        <input type=\"submit\" name=\"comp\" value=\"Compétences\"><br>
                        <input type=\"submit\" name=\"proj\" value=\"Projets\"><br>
                        <input type='submit' name='goToSite' value='Retour au site'>
                    </form>
                </nav>
            </section>";
        }
        ?>

		<?php
			include("assets/PHP/Connexion.php");
		?>

	</main>
</body>
</html>
