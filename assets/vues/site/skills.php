<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/main.css">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/skills.css">
    <title>Portfolio Sacha EGHIAZARIAN - Compétences</title>
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
        <section class="intro">
            <span class="background"></span>
            <div class="texte">
                <h1>Bonjour !</h1>
                <div>
                    <?php 
                        $text = sendRequest("SELECT text FROM dinamictexts WHERE id = 6;", [], PDO::FETCH_NUM)[0][0];
                        echo html_entity_decode($text);
                    ?>
                </div>
            </div>
        </section>
        <section class="types">
            <div id="devButton" class="type">
                <img src="https://sacha-eghiazarian.fr/assets/image/site/icons/dev.png" alt="">
                <p>Développement Logiciel</p>
            </div>
            <div id="infraButton" class="type">
                <img src="https://sacha-eghiazarian.fr/assets/image/site/icons/infra.png" alt="">
                <p>Infrastructure</p>
            </div>
            <div id="webButton" class="type">
                <img src="https://sacha-eghiazarian.fr/assets/image/site/icons/web.png" alt="">
                <p>Développement Web</p>
            </div>
            <div id="otherButton" class="type">
                <img src="https://sacha-eghiazarian.fr/assets/image/site/icons/other.png" alt="">
                <p>Autre</p>
            </div>
        </section>
        <section class="skills">
            <?php 
                $rqt = "SELECT * FROM skills WHERE isShown = 1 ORDER BY level DESC;";
                $skills = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                foreach($skills as $skill){
                    extract($skill);
                    echo "            
                    <div class='skill $type'>
                        <div>$name</div>
                        <div class='skill-bar-holder'>
                            <span class='skill-bar' aria-valuenow='$level' aria-valuemin='1' aria-valuemax='100'></span>
                        </div>
                    </div>
                    ";
                }
            ?>
        </section>
        <section class="project">
            <h2>Mes projets</h2>
            <div class="text">
                <?php 
                    $text = sendRequest("SELECT text FROM dinamictexts WHERE id = 4;", [], PDO::FETCH_NUM)[0][0];
                    echo html_entity_decode($text);
                ?>
            </div>
            <a class="button" href="https://sacha-eghiazarian.fr/projects">Mes projets</a>
            <div class="project-list">
                <?php 
                    $rqt = "SELECT * from projects WHERE isShown = 1 LIMIT 3;";
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
    <script src="https://sacha-eghiazarian.fr/assets/script/Skills.js"></script>
    <script src="https://sacha-eghiazarian.fr/assets/script/burger.js"></script>
</body>
</html>