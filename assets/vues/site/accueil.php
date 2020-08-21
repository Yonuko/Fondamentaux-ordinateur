<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/main.css">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/accueil.css">
    <title>Portfolio Sacha EGHIAZARIAN - Accueil</title>
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
    <div class="image">
        <div>Sacha Eghiazarian</div>
    </div>
    <main>
        <section class="a-propos">
            <h1>A propos</h1>
            <section class="message">
                <span>Présentation</span>
                <div class="pres">
                    <?php 
                        $text = sendRequest("SELECT text FROM dinamictexts WHERE id = 1;", [], PDO::FETCH_NUM)[0][0];
                        echo html_entity_decode($text);
                    ?>
                </div>
                <a class="button" href="https://sacha-eghiazarian.fr/skills">Mes compétences</a>
            </section>
        </section>

        <section class="quote">
            <img id="quote" src="https://sacha-eghiazarian.fr/assets/image/site/quote.JPG" alt="quote icon"><br>
            <div class="quote-text">
                <?php 
                    $text = sendRequest("SELECT text FROM dinamictexts WHERE id = 2;", [], PDO::FETCH_NUM)[0][0];
                    echo html_entity_decode($text);
                ?>
            </div>
        </section>

        <section class="blog">
            <h2>Mon blog</h2>
            <p>
                <?php 
                    $text = sendRequest("SELECT text FROM dinamictexts WHERE id = 3;", [], PDO::FETCH_NUM)[0][0];
                    echo html_entity_decode($text);
                ?>
            </p>
            <br>
            <a class="button" href="https://sacha-eghiazarian.fr/blog">En savoir plus</a>
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
                        <div class='project-item' onclick=\"location.href = 'https://sacha-eghiazarian.fr/projects/$project_id'\">
                            <span class='image' 
                            style=\"background-image: url('https://sacha-eghiazarian.fr/assets/image/Uploads/Projets/$logo');\"></span>
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