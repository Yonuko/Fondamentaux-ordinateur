<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/main.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/skills.css">
    <title>Portfolio Sacha EGHIAZARIAN - Compétences</title>
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
    </header>
    <main>
        <section class="intro">
            <span class="background"></span>
            <div class="texte">
                <h1>Bonjour !</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Autem repellendus officiis dolorum. Hic eum iusto vero blanditiis ad tenetur id, deserunt exercitationem repudiandae laborum sit reiciendis fugiat pariatur? Voluptatem, adipisci!</p>
            </div>
        </section>
        <section class="types">
            <div id="devButton" class="type">
                <img src="http://localhost/portfolio/assets/image/site/icons/dev.png" alt="">
                <p>Développement Logiciel</p>
            </div>
            <div id="infraButton" class="type">
                <img src="http://localhost/portfolio/assets/image/site/icons/infra.png" alt="">
                <p>Infrastructure</p>
            </div>
            <div id="webButton" class="type">
                <img src="http://localhost/portfolio/assets/image/site/icons/web.png" alt="">
                <p>Développement Web</p>
            </div>
            <div id="otherButton" class="type">
                <img src="http://localhost/portfolio/assets/image/site/icons/other.png" alt="">
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
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi vel cumque iusto consectetur natus nostrum provident voluptatem, saepe fugit sit laboriosam consequuntur possimus doloremque fuga sed architecto, voluptatum rem ullam!</p>
            <a class="button" href="http://localhost/portfolio/projects">Mes projets</a>
            <div class="project-list">
                <?php 
                    $rqt = "SELECT * from projects WHERE isShown = 1 LIMIT 3;";
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
    <script src="http://localhost/portfolio/assets/script/Skills.js"></script>
</body>
</html>