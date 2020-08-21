<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/main.css">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/error.css">
    <title>Portfolio Sacha EGHIAZARIAN - Page introuvable</title>
</head>
<body>
    <header>
        <div class="menu">
            <a href="https://sacha-eghiazarian.fr">Accueil</a>
            <a href="https://sacha-eghiazarian.fr/blog">Blog</a>
            <a href="https://sacha-eghiazarian.fr/projects">Mes projets</a>
            <a href="https://sacha-eghiazarian.fr/skills">Mes compétences</a>
            <a href="https://sacha-eghiazarian.fr/contact">Contact</a>
            <?php 
                if(isset($_SESSION["name"]) && isset($_SESSION["id"])){
                    echo("<a href='https://sacha-eghiazarian.fr/admin'>Admin</a>");
                }
            ?>
        </div>
        <div class="burger">
            <div class="hamburger hamburger-one"></div>
        </div>
    </header>
    <main>
      <section class="error">
        <p class="error-code">404</p>
        <p class="error-message">La page que vous essayez d'atteindre n'existe pas</p>
      </section>
    </main>
    <footer>
        <div class="menu">
            <a href="https://sacha-eghiazarian.fr">Accueil</a>
            <a href="https://sacha-eghiazarian.fr/blog">Blog</a>
            <a href="https://sacha-eghiazarian.fr/projects">Mes projets</a>
            <a href="https://sacha-eghiazarian.fr/skills">Mes compétences</a>
            <a href="https://sacha-eghiazarian.fr/contact">Contact</a>
            <?php 
                if(isset($_SESSION["name"]) && isset($_SESSION["id"])){
                    echo("<a href='https://sacha-eghiazarian.fr/admin'>Admin</a>");
                }
            ?>
        </div>
    </footer>
    <script src="https://sacha-eghiazarian.fr/assets/script/burger.js"></script>
</body>
</html>