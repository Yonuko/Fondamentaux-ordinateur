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
                <span>Dernier article</span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit aperiam asperiores, laboriosam magnam nostrum nisi illum iure sapiente consectetur possimus nulla placeat facilis expedita quas beatae voluptatem voluptatum necessitatibus ipsa.</p>
            </div>
            <span class="latest-post-image"></span>
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
                echo "
                <div class='post' onclick=\"location.href = 'http://localhost/portfolio/post/$post_id'\">
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
    <script src="http://localhost/portfolio/assets/script/burger.js"></script>
</body>
</html>