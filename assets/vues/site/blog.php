<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/main.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/blog.css">
    <title>Portfolio Sacha EGHIAZARIAN - Blog</title>
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
            <h1>Mon blog</h1>
        </section>
        <section class="Latest-post">
            <div class="latest-post-message">
            <?php 
                $rqt = "SELECT * FROM posts ORDER BY post_id DESC LIMIT 1";
                $post = sendRequest($rqt, [], PDO::FETCH_ASSOC)[0];
                extract($post);
                echo "<span>$name</span>";
                $firstDesc = sendRequest("SELECT content FROM post_descriptions WHERE `order` = 1 AND post_id = ?;", [$post_id], PDO::FETCH_NUM)[0][0];
                echo "<div class='desc'>" . html_entity_decode($firstDesc) . "</div>";
            ?>
            </div>
            <?php 
                $rqt = "SELECT logo FROM posts ORDER BY post_id DESC LIMIT 1";
                $logo = sendRequest($rqt, [], PDO::FETCH_NUM)[0][0];
                echo "<span class='latest-post-image' style='background-image: url(\"http://localhost/portfolio/assets/image/Uploads/Blog/$logo\")'></span>";
            ?>
            </section>
        <section class="Selector">
            <?php 
                $rqt = "SELECT * FROM Categorie;";
                $types = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                foreach($types as $type){
                    extract($type);
                    echo "<div class='selectItem' data-type='" . str_replace(' ', '_', $name) . "'>" . $name . "</div>";
                }
            ?>
        </section>
        <section class="articles">
        <?php 
            $rqt = "SELECT * FROM posts WHERE isShown = 1;";
            $posts = sendRequest($rqt, [], PDO::FETCH_ASSOC);
            $count = 0;
            $isColor = true;
            foreach($posts as $post){
                extract($post);
                $firstDesc = sendRequest("SELECT content FROM post_descriptions WHERE `order` = 1 AND post_id = ?;", [$post_id], PDO::FETCH_NUM)[0][0];
                if($count % 3 === 0 && $count !== 0){
                    if($isColor){
                        echo "</div><div class='posts dark'>";
                    }else{
                        echo "</div><div class='posts'>";
                    }
                    $isColor = !$isColor;
                }else if($count === 0){
                    echo "<div class='posts'>";
                }
                $category = sendRequest("SELECT name FROM Categorie WHERE category_id = ?;", [$category_id], PDO::FETCH_NUM)[0][0];
                $category = str_replace(' ', '_', $category);
                echo "
                <div class='post $category' onclick=\"location.href = 'http://localhost/portfolio/post/$post_id'\">
                    <span class='post-icon' 
                    style=\"background-image: url('http://localhost/portfolio/assets/image/Uploads/Blog/$logo');\"></span>
                    <span class='post-title'>$name</span>
                    <div class='description'>" . html_entity_decode($firstDesc) . "</div>
                </div>
                ";
                $count++;
            }
        ?>
        </section>
        <section class="project">
            <h2>Mes projets</h2>
            <div class="text">
                <?php 
                    $text = sendRequest("SELECT text FROM dinamicTexts WHERE id = 4;", [], PDO::FETCH_NUM)[0][0];
                    echo html_entity_decode($text);
                ?>
            </div>
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
    <script src="http://localhost/portfolio/assets/script/burger.js"></script>
    <script src="http://localhost/portfolio/assets/script/PostSelector.js"></script>
</body>
</html>