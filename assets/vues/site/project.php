<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/main.css">
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
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
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