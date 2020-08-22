<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/main.css">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/project.css">
    <?php 
        $rqt = "SELECT * FROM projects WHERE project_id = ? AND isShown = 1;";
        $project = sendRequest($rqt, [$id], PDO::FETCH_ASSOC)[0];
        if(is_null($project)){
            echo "<title>Portfolio Sacha EGHIAZARIAN - Projet inconnu</title>";
            include_once("ProjectNotFound.php");
            return;
        }
        extract($project);
    ?>
    <title>Portfolio Sacha EGHIAZARIAN - Projet <?php echo $name ?></title>
</head>
<body>
    <?php 
        if(!(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0')){
            $rqt = "UPDATE projects SET views = views + 1, views_semaine = views_semaine + 1 WHERE project_id = ?;";
            sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
        }
    ?>
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
        <?php
            $rqt = "SELECT * FROM projects WHERE project_id = ?;";
            $project = sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
            extract($project);
            echo "
            <section class='project-presentation' 
            style=\"background-image: url('https://sacha-eghiazarian.fr/assets/image/Uploads/Projets/$logo');\">
                <h1>$name</h1>
                <section class='message'>
                    <span>$presentation_name</span>
                    <div>" . html_entity_decode($presentation) . "</div>
                </section>
            </section>
            ";
        ?>
        <?php
            $rqt = "SELECT * FROM projects_description WHERE project_id = ? ORDER BY `order`;";
            $descTab = sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
            $isColorOne = true;
            if(!is_null($descTab)){
                foreach($descTab as $desc){
                    extract($desc);
                    if($isColorOne){
                        echo "<section class='description color'>";
                    }else{
                        echo "<section class='description'>";
                    }
                    echo "<div class='marge'></div>";
                    if($isColorOne){
                        echo "<div class='strcuture'>";
                    }
                    echo "<div class='content'>";
                    echo "<h$order class='title'>$subTitle</h$order>";
                    echo "<div class='description-content'>" . html_entity_decode($Description) . "</div>";
                    echo "</div>";
                    if($isColorOne){
                        echo "<div class='img'></div>";
                        echo "</div>";
                    }
                    echo "</section>";
                    $isColorOne = !$isColorOne;
                }
            }
        ?>
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
    <script src="https://sacha-eghiazarian.fr/assets/script/burger.js"></script>
</body>
</html>