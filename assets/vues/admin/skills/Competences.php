<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Admin/admin.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Admin/SpecificPage.css">
    <title>Admin - competences</title>
    <?php
        if(!isset($_SESSION["name"]) || !isset($_SESSION["id"])){
            header("location:http://localhost/portfolio/login");
            return;
        }
    ?>
</head>
<body>
    <header>
        <div class="menu">
            <div class="login">
                Bienvenue,<br>
                <?php echo $_SESSION["name"]; ?> <!-- Afficher name de l'utilisateur connecté -->
            </div>
            <div class="menu-button">
                <a href="http://localhost/portfolio/admin" class="element">
                    <img src="http://localhost/portfolio/assets/image/homeIcon.png" alt="home icon"> Accueil
                </a>
                <a href="http://localhost/portfolio/admin/blog" class="element">
                    <img src="http://localhost/portfolio/assets/image/blogIcon.png" alt="blog icon"> Blog
                </a>
                <a href="http://localhost/portfolio/admin/texte" class="element">
                    <img src="http://localhost/portfolio/assets/image/textIcon.png" alt="Text icon"> Texte
                </a>
                <a href="http://localhost/portfolio/admin/skills" class="element">
                    <img src="http://localhost/portfolio/assets/image/skillsIcon.png" alt="skills icon"> Competences
                </a>
                <a href="http://localhost/portfolio/admin/projects" class="element">
                    <img src="http://localhost/portfolio/assets/image/projectIcon.png" alt="project icon"> Projets
                </a>
                <a href="http://localhost/portfolio/admin/CV" class="element">
                    <img src="http://localhost/portfolio/assets/image/cvIcon.png" alt="cv icon"> CV
                </a>
            </div>
        </div>

        <div class="secondary-menu">
            <div class="manageMenu">
                <form action="http://localhost/portfolio/admin/skills/create" method="get">
                    <button class="add">Ajouter</button>
                </form>
            </div>
            <div class="connexionMenu">
                <div class="notification">
                    <button id="bell" class="logo"></button>
                    <span id="num" class="num">0</span>
                    <div id="notif-content" class="content">
                        <div class="header">
                            Notifications
                            <img onclick="notificationCloseButton()" class="close" src="http://localhost/portfolio/assets/image/closeIcon.png" alt="croix fermante">
                        </div>
                        <div class="notification-content">
                           <!--  aucune notification -->
                           <div onclick="readNotif(1)" class="notification-card" id="notification-1">
                               <div class="card-content">
                                    On s'en ballance
                               </div>
                               <img onclick="removeNotif(1)" class="close" src="http://localhost/portfolio/assets/image/closeIcon.png" alt="croix fermante">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="dropbtn"><?php echo $_SESSION["name"]; ?></button> <!-- Afficher name de l'utilisateur connecté -->
                    <div class="dropdown-content">
                        <a href="http://localhost/portfolio/">Retour au site</a>
                        <a href="http://localhost/portfolio/blog">Retour au blog</a>
                        <a href="#">Messages</a>
                        <form action="http://localhost/portfolio/logout" method="POST">
                            <input type="submit" value="Deconnexion">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <main>
            <div class="body-content">
                <div class="card skills">
                    <div class="card-header">
                        <div class="card-title">Competences</div>
                        <div>
                            <img src="http://localhost/portfolio/assets/image/refresh.png" alt="Refresh icon">
                            <img src="http://localhost/portfolio/assets/image/more.png" alt="More icon">
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="skills-form" action="http://localhost/portfolio/admin/skills/update" method="post">
                            <?php 
                                $rqt = "SELECT * FROM skills ORDER BY level DESC;";
                                $skills = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                                if(is_null($skills)){
                                    echo "<p style='text-align:center;'>Aucun skills n'est disponible pour l'instant</p>";
                                }else{
                                    foreach($skills as $skill){
                                        extract($skill);
                                        echo "
                                        <div class='skill'>
                                            <p>$name</p>
                                            <div class='skill-bar-holder'>
                                                <span class='skill-bar' aria-valuenow='$level' aria-valuemin='1' aria-valuemax='100'></span>
                                            </div>
                                            <img class='edit' onclick=\"window.location = 'http://localhost/portfolio/admin/skills/$skill_id/delete'\"
                                            src='http://localhost/portfolio/assets/image/delete.png' alt='Delete Icon'>
                                        </div>
                                        <div class='slider'>
                                            <input type='range' min='1' max='100' value='$level' class='skill-slider'>
                                            <input type='number' value='$level' name='" . str_replace(' ', '_', $name) . "' class='value' min='1' max='100'>
                                        </div>
                                        ";
                                    }
                                }
                            ?>
                            <input type="submit" class="button" value="Actualiser" style="align-self:center; margin-top: 50px;">
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </header>
    <script src="http://localhost/portfolio/assets/script/Skills.js"></script>
    <script src="http://localhost/portfolio/assets/script/notification.js"></script>
    <script src="http://localhost/portfolio/assets/script/SkillsEdit.js"></script>
</body>
</html>