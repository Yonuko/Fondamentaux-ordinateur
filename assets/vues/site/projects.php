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
    </header>
    <main>
    <section class="title">
            <h1>Mes projets</h1>
        </section>
        <section class="Latest-project">
            <?php 
                $rqt = "SELECT * FROM projects ORDER BY project_id DESC LIMIT 1;";
                $latest_project = sendRequest($rqt, [], PDO::FETCH_ASSOC)[0];
                extract($latest_project);
                $rqt = "SELECT Description FROM projects_description WHERE `order` = 1 AND project_id = ?;";
                $desc = sendRequest($rqt, [$project_id], PDO::FETCH_NUM)[0][0];
                echo "
                <span class='latest-project-image' 
                style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Projets/$logo')\"></span>
                <div class='latest-project-message'>
                    <span>$name</span>
                    <div class='description'>" . html_entity_decode($desc) . "</div>
                    <a href='http://localhost/portfolio/projects/$project_id' class='button'>Voir le projet</a>
                </div>
                ";
            ?>
        </section>
        <section class="projects">
            <div class='project-list'>
            <?php 
                $rqt = "SELECT * FROM projects WHERE isShown = 1;";
                $projects = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                $count = 0;
                foreach($projects as $project){
                    extract($project);
                    $rqt = "SELECT * FROM projects_description WHERE project_id = ? AND `order` = 1;";
                    $desc = sendRequest($rqt, [$project_id], PDO::FETCH_ASSOC)[0];
                    extract($desc);
                    if($count % 3 === 0 && $count !== 0){
                        echo "</div><div class='project-list'>";
                    }
                    echo "
                    <div class='project' onclick=\"location.href = 'http://localhost/portfolio/projects/$project_id'\">
                        <span class='project-icon' 
                        style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Projets/$logo');\"></span>
                        <span class='project-title'>$name</span>
                        <div class='description'>" . html_entity_decode($Description) . "</div>
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
            <a class="button" href="http://localhost/portfolio/projects">Mon blog</a>
            <div class="posts-list">
                <?php 
                    $rqt = "SELECT * from projects WHERE isShown = 1 LIMIT 3;";
                    $projects = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                    foreach($projects as $project){
                        extract($project);
                        echo "
                        <div class='posts-item' onclick=\"location.href = 'http://localhost/portfolio/projects/$project_id'\">
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