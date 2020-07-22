<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/main.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/projects.css">
    <title>Portfolio Sacha EGHIAZARIAN - Projets</title>
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
    <main>
    <section class="title">
            <h1>Mes projets</h1>
        </section>
        <section class="Latest-project">
            <?php 
                $rqt = "SELECT * FROM projects ORDER BY project_id ASC LIMIT 1;";
                $latest_project = sendRequest($rqt, [], PDO::FETCH_ASSOC)[0];
                extract($latest_project);
                echo "
                <span class='latest-project-image' 
                style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Projets/$logo')\"></span>
                <div class='latest-project-message'>
                    <span>$name</span>
                    <div class='description'>" . html_entity_decode($presentation) . "</div>
                    <a href='http://localhost/portfolio/projects/$project_id' class='button'>Voir le projet</a>
                </div>
                ";
            ?>
        </section>
        <section class="Selectors">
            <?php 
                $rqt = "SELECT * FROM project_type WHERE sub_project_id IS NULL;";
                $types = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                echo "<section class='Selector'>";
                foreach($types as $type){
                    extract($type);
                    $sub_name = sendRequest("SELECT name FROM project_type WHERE project_type_id = ?;", [$sub_project_id], PDO::FETCH_NUM)[0][0];
                    echo "<div id='" . str_replace(' ', '_', $name) . "' class='selectItem' data-sub-type='none'
                    data-type='" . str_replace(' ', '_', $name) . "'>" . $name . "</div>";
                }
                echo "</section>";
                $rqt = "SELECT sub_project_id FROM project_type WHERE sub_project_id IS NOT NULL GROUP BY sub_project_id;";
                $subTypesIDs = sendRequest($rqt, [], PDO::FETCH_NUM);
                foreach($subTypesIDs as $subTypeID){
                    $rqt = "SELECT * FROM project_type WHERE sub_project_id = ?;";
                    $subTypes = sendRequest($rqt, [$subTypeID[0]], PDO::FETCH_ASSOC);
                    $masterType = sendRequest("SELECT name FROM project_type WHERE project_type_id = ?;", [$subTypeID[0]], PDO::FETCH_NUM)[0][0];
                    echo "<section class='subSelector sub_type_" . str_replace(' ', '_', $masterType) . "'>";
                    foreach($subTypes as $subType){
                        extract($subType);
                        echo "<div id='" . str_replace(' ', '_', $name) . "' class='selectItem' data-sub-type='" . str_replace(' ', '_', $masterType) . "'
                        data-type='" . str_replace(' ', '_', $name) . "'>" . $name . "</div>";
                    }
                    echo "</section>";
                }
            ?>
        </section>
        <section class="projects">
            <?php 
                $rqt = "SELECT * FROM projects WHERE isShown = 1;";
                $projects = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                $count = 0;
                $isColor = true;
                foreach($projects as $project){
                    extract($project);
                    if($count % 3 === 0 && $count !== 0){
                        if($isColor){
                            echo "</div><div class='project-list dark'>";
                        }else{
                            echo "</div><div class='project-list'>";
                        }
                        $isColor = !$isColor;
                    }else if($count === 0){
                        echo "<div class='project-list'>";
                    }
                    echo "
                    <div class='project";
                    $rqt = "SELECT t.name FROM project_types pt INNER JOIN project_type t INNER JOIN projects p ON
                    p.project_id = pt.project_id AND t.project_type_id = pt.project_type_id WHERE p.project_id = ?;";
                    $types = sendRequest($rqt, [$project_id], PDO::FETCH_ASSOC);
                    foreach($types as $type){
                        echo " " . str_replace(' ', '_', $type["name"]);
                    }
                    echo "' ";
                    echo "onclick=\"location.href = 'http://localhost/portfolio/projects/$project_id'\">
                        <span class='project-icon' 
                        style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Projets/$logo');\"></span>
                        <span class='project-title'>$name</span>
                        <div class='description'>" . html_entity_decode($presentation) . "</div>
                    </div>
                    ";
                    $count++;
                }
            ?>
            </div>
            <?php 
                $rqt = "SELECT * FROM projects WHERE isShown = 1;";
                $projects = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                $count = 0;
                $isColor = true;
                foreach($projects as $project){
                    extract($project);
                    if($count % 2 === 0 && $count !== 0){
                        if($isColor){
                            echo "</div><div class='project-list dark phone'>";
                        }else{
                            echo "</div><div class='project-list phone'>";
                        }
                        $isColor = !$isColor;
                    }else if($count === 0){
                        echo "<div class='project-list phone'>";
                    }
                    echo "
                    <div class='project' onclick=\"location.href = 'http://localhost/portfolio/projects/$project_id'\">
                        <span class='project-icon' 
                        style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Projets/$logo');\"></span>
                        <span class='project-title'>$name</span>
                        <div class='description'>" . html_entity_decode($presentation) . "</div>
                    </div>
                    ";
                    $count++;
                }
            ?>
            </div>
        </section>
        <section class="posts">
            <h2>Mes articles</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi vel cumque iusto consectetur natus nostrum provident voluptatem, saepe fugit sit laboriosam consequuntur possimus doloremque fuga sed architecto, voluptatum rem ullam!</p>
            <a class="button" href="http://localhost/portfolio/blog">Mon blog</a>
            <div class="posts-list">
                <?php 
                    $rqt = "SELECT * from posts WHERE isShown = 1 LIMIT 3;";
                    $posts = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                    foreach($posts as $post){
                        extract($post);
                        echo "
                        <div class='posts-item' onclick=\"location.href = 'http://localhost/portfolio/post/$post_id'\">
                            <span class='image' 
                            style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Blog/$logo');\"></span>
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
    <script src="http://localhost/portfolio/assets/script/projectSelector.js"></script>
</body>
</html>