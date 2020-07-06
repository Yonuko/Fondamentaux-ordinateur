<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/main.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/project.css">
    <?php 
        $rqt = "SELECT * FROM projects WHERE project_id = ?;";
        $project = sendRequest($rqt, [$id], PDO::FETCH_ASSOC)[0];
        if(is_null($project)){
            echo "<title>Portfolio Sacha EGHIAZARIAN - Projet inconnu</title>";
            include_once("404.php");
            http_response_code(404);
            return;
        }
        extract($project);
        ?>
    <title>Portfolio Sacha EGHIAZARIAN - Projet <?php echo $name ?></title>
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
        <?php
            $rqt = "SELECT * FROM projects WHERE project_id = ?;";
            $project = sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
            extract($project);
            echo "
            <section class='project-presentation' 
            style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Projets/$logo');\">
                <h1>$name</h1>
                <section class='message'>
                    <span>Bonjour !</span>
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Earum, aut obcaecati! <br>Cupiditate quas deleniti officia ad ea aperiam porro perferendis atque dolorum <br>consectetur assumenda, placeat vitae, unde perspiciatis quasi doloribus?
                        <br><br>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempora in ex a autem deserunt voluptatem repellendus laudantium beatae libero hic, reprehenderit sequi, illum magnam iusto pariatur officiis quam eum. Possimus?
                    </p>
                </section>
            </section>
            ";
        ?>
        <?php
            $rqt = "SELECT * FROM projects_description WHERE project_id = ? ORDER BY `order`;";
            $descTab = sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
            if(!is_null($descTab)){
                foreach($descTab as $desc){
                    extract($desc);
                    echo "<h$order>$subTitle</h$order>";
                    echo html_entity_decode($Description);
                }
            }
        ?>
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
</body>
</html>