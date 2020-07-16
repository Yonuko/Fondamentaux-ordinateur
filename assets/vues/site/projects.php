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
</body>
</html>