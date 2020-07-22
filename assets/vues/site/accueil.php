<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/main.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/accueil.css">
    <title>Portfolio Sacha EGHIAZARIAN - Accueil</title>
</head>
<body>
    <header>
        <div class="menu">
            <a href="http://localhost/portfolio">Accueil</a>
            <a href="http://localhost/portfolio/blog">Blog</a>
            <a href="http://localhost/portfolio/projects">Mes projets</a>
            <a href="http://localhost/portfolio/skills">Mes compétences</a>
            <a href="http://localhost/portfolio/contact">Contact</a>
            <?php 
                if(isset($_SESSION["name"]) && isset($_SESSION["id"])){
                    echo("<a href='http://localhost/portfolio/admin'>Admin</a>");
                }
            ?>
        </div>
        <div class="burger">
            <div class="hamburger hamburger-one"></div>
        </div>
    </header>
    <div class="image">
        <div>Sacha Eghiazarian</div>
    </div>
    <main>
        <section class="a-propos">
            <h1>A propos</h1>
            <section class="message">
                <span>Présentation</span>
                <p>Je m'appelle Sacha EGHIAZARIAN j'ai 19 ans, je suis actuellement étudiant en 3ème année à Ynov Aix Campus (cursus en 5 ans)
                    <br><br>
                    Pationné d'informatique depuis l'âge de 14 ans, je souhaite continuer sur la voie du développement logicielle que j'ai débuté en auto didacte il y a de cela 5 ans.
                    <br>
                    Je suis quelqu'un de sérieux, pationné et autonome, et je me sers des erreurs du passé pour devenir meilleurs de jour en jour.
                    <br>
                    Quelque soit l'obstacle je continue d'avancer !
                </p>
                <a class="button" href="http://localhost/portfolio/skills">Mes compétences</a>
            </section>
        </section>

        <section class="quote">
            <img id="quote" src="http://localhost/portfolio/assets/image/site/quote.JPG" alt="quote icon"><br>
            <div class="quote-text">“Si tu ne peux pas voler, alors cours. Si tu ne peux pas courir, alors marche. Si tu ne peux pas marcher, alors rampe, mais quoi que tu fasses, tu dois continuer à avancer”<br> - Martin Luther King Jr.</div>
        </section>

        <section class="blog">
            <h2>Mon blog</h2>
            <p>
                Sur ce site vous pourrez consulter mon blog, que j'allimente avec des expérimentations personnelles en lien avec l'informatique, généralement le développement.
                <br><br>
                Mais egalement avec un rapport de mes différentes expériences professionnelles faite en fin d'année scolaire.
            </p>
            <br>
            <a class="button" href="http://localhost/portfolio/blog">En savoir plus</a>
        </section>

        <section class="project">
            <h3>Mes projets</h3>
            <div class="project-list">
                <?php 
                    $rqt = "SELECT * from projects WHERE isShown = 1 LIMIT 6;";
                    $projects = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                    foreach($projects as $project){
                        extract($project);
                        echo "
                        <div class='project-item' onclick=\"location.href = 'http://localhost/portfolio/projects/$project_id'\">
                            <span class='image' 
                            style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Projets/$logo');\"></span>
                            <p>$name</p>
                        </div>
                        ";
                    }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <div class="menu">
            <a href="http://localhost/portfolio">Accueil</a>
            <a href="http://localhost/portfolio/blog">Blog</a>
            <a href="http://localhost/portfolio/projects">Mes projets</a>
            <a href="http://localhost/portfolio/skills">Mes compétences</a>
            <a href="http://localhost/portfolio/contact">Contact</a>
            <?php 
                if(isset($_SESSION["name"]) && isset($_SESSION["id"])){
                    echo("<a href='http://localhost/portfolio/admin'>Admin</a>");
                }
            ?>
        </div>
    </footer>
    <script src="http://localhost/portfolio/assets/script/burger.js"></script>
</body>
</html>