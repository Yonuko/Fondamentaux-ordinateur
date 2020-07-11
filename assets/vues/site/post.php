<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/main.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Site/post.css">
    <?php 
        $rqt = "SELECT * FROM posts WHERE post_id = ?;";
        $post = sendRequest($rqt, [$id], PDO::FETCH_ASSOC)[0];
        if(is_null($post)){
            echo "<title>Portfolio Sacha EGHIAZARIAN - Article inconnu</title>";
            include_once("404.php");
            http_response_code(404);
            return;
        }
        extract($post);
        ?>
    <title>Portfolio Sacha EGHIAZARIAN - Article <?php echo $name ?></title>
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
        <section class="post-title">
            Titre de l'article
        </section>
        <?php 
            $rqt = "SELECT * FROM post_descriptions WHERE post_id = ?";
            $post_descriptions = sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
            $count = 1;
            if(!is_null($post_descriptions)){
                foreach($post_descriptions as $description){
                    extract($description);
                    if($count % 4 === 0){
                        echo "<section class='Paragraphe quad'>";
                        echo "<img src='http://localhost/portfolio/assets/image/Uploads/Blog/project.jpg'>";
                    }else if($count % 3 === 0){
                        echo "<section class='Paragraphe tiercary'>";
                    }else if($count % 2 === 0){
                        echo "<section class='Paragraphe secondary'>";
                    }else{
                        echo "<section class='Paragraphe'>";
                        echo "<img src='http://localhost/portfolio/assets/image/Uploads/Blog/$logo'>";
                    }
                    echo "<div class='text'>";
                    echo "<h$order>$subTitle</h$order>";
                    echo "<div class='content'>$content</div>";
                    echo "<div>";
                    echo "</section>";
                    $count++;
                }
            }
        ?>
        <section class="posts">
            <h2>Mes articles</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi vel cumque iusto consectetur natus nostrum provident voluptatem, saepe fugit sit laboriosam consequuntur possimus doloremque fuga sed architecto, voluptatum rem ullam!</p>
            <a class="button" href="http://localhost/portfolio/projects">Mon blog</a>
            <div class="posts-list">
                <?php 
                    $rqt = "SELECT * from posts WHERE isShown = 1 LIMIT 3;";
                    $posts = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                    foreach($posts as $post){
                        extract($post);
                        echo "
                        <div class='posts-item' onclick=\"location.href = 'http://localhost/portfolio/projects/$post_id'\">
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