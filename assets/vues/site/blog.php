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
            <div class="posts">
                <div class="post">
                    <span class="post-icon"></span>
                    <span class="post-title">Title</span>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio dignissimos perspiciatis rem mollitia explicabo tempore ipsam hic totam odit sunt aliquam, facilis voluptates eius enim qui cum rerum maxime? Numquam?</p>
                </div>
                <div class="post">
                    <span class="post-icon"></span>
                    <span class="post-title">Title</span>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio dignissimos perspiciatis rem mollitia explicabo tempore ipsam hic totam odit sunt aliquam, facilis voluptates eius enim qui cum rerum maxime? Numquam?</p>
                </div>
                <div class="post">
                    <span class="post-icon"></span>
                    <span class="post-title">Title</span>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio dignissimos perspiciatis rem mollitia explicabo tempore ipsam hic totam odit sunt aliquam, facilis voluptates eius enim qui cum rerum maxime? Numquam?</p>
                </div>
            </div>
            <div class="posts dark">
                <div class="post">
                    <span class="post-icon"></span>
                    <span class="post-title">Title</span>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio dignissimos perspiciatis rem mollitia explicabo tempore ipsam hic totam odit sunt aliquam, facilis voluptates eius enim qui cum rerum maxime? Numquam?</p>
                </div>
                <div class="post">
                    <span class="post-icon"></span>
                    <span class="post-title">Title</span>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio dignissimos perspiciatis rem mollitia explicabo tempore ipsam hic totam odit sunt aliquam, facilis voluptates eius enim qui cum rerum maxime? Numquam?</p>
                </div>
                <div class="post">
                    <span class="post-icon"></span>
                    <span class="post-title">Title</span>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio dignissimos perspiciatis rem mollitia explicabo tempore ipsam hic totam odit sunt aliquam, facilis voluptates eius enim qui cum rerum maxime? Numquam?</p>
                </div>
            </div>
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
</body>
</html>