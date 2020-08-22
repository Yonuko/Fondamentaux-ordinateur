<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/main.css">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Site/post.css">
    <?php 
        $rqt = "SELECT * FROM posts WHERE post_id = ? AND isShown = 1;";
        $post = sendRequest($rqt, [$id], PDO::FETCH_ASSOC)[0];
        if(is_null($post)){
            echo "<title>Portfolio Sacha EGHIAZARIAN - Article inconnu</title>";
            include_once("PostNotFound.php");
            return;
        }
        extract($post);
    ?>
    <title>Portfolio Sacha EGHIAZARIAN - Article <?php echo $name ?></title>
</head>
<body>
    <?php 
        if(!(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0')){
            $rqt = "UPDATE posts SET views = views + 1, views_semaine = views_semaine + 1 WHERE post_id = ?;";
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
        <section class="post-title">
            <?php 
                echo sendRequest("SELECT name FROM posts WHERE post_id = ?", [$id], PDO::FETCH_NUM)[0][0];
            ?>
        </section>
        <?php 
            $rqt = "SELECT * FROM post_descriptions WHERE post_id = ? ORDER BY `order` ASC;";
            $post_descriptions = sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
            $count = 1;
            if(!is_null($post_descriptions)){
                foreach($post_descriptions as $description){
                    extract($description);
                    if($count % 4 === 0){
                        echo "<section class='Paragraphe quad'>";
                        echo "<img src='https://sacha-eghiazarian.fr/assets/image/Uploads/Blog/project.jpg'>";
                    }else if($count % 3 === 0){
                        echo "<section class='Paragraphe tiercary'>";
                    }else if($count % 2 === 0){
                        echo "<section class='Paragraphe secondary'>";
                    }else{
                        echo "<section class='Paragraphe'>";
                        echo "<img id='postLogo' src='https://sacha-eghiazarian.fr/assets/image/Uploads/Blog/$logo'>";
                    }
                    echo "<div class='text'>";
                    echo "<h$order class='title'>$subTitle</h$order>";
                    echo "<div class='content'>" . html_entity_decode($content) . "</div>";
                    echo "</div>";
                    echo "</section>";
                    $count++;
                    if($count > 4){
                        $count = 2;
                    }
                }
            }
        ?>
        <section class="posts">
            <h2>Mes articles</h2>
            <div class="text">
                <?php 
                    $text = sendRequest("SELECT text FROM dinamictexts WHERE id = 5;", [], PDO::FETCH_NUM)[0][0];
                    echo html_entity_decode($text);
                ?>
            </div>
            <a class="button" href="https://sacha-eghiazarian.fr/blog">Mon blog</a>
            <div class="posts-list">
                <?php 
                    $rqt = "SELECT * from posts WHERE isShown = 1 LIMIT 3;";
                    $posts = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                    foreach($posts as $post){
                        extract($post);
                        echo "
                        <div class='posts-item' onclick=\"location.href = 'https://sacha-eghiazarian.fr/post/$post_id'\">
                            <span class='image' 
                            style=\"background-image: url('https://sacha-eghiazarian.fr/assets/image/Uploads/Blog/$logo');\"></span>
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
    <script src="https://sacha-eghiazarian.fr/assets/script/PostImg.js"></script>
</body>
</html>