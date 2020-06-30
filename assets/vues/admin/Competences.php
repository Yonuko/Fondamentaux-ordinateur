<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/Admin/admin.css">
    <link rel="stylesheet" href="../assets/style/Admin/SpecificPage.css">
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
                <button class="add">Ajouter</button>
            </div>
            <div class="connexionMenu">
                <div class="notification">
                    <button id="bell" class="logo"></button>
                    <span id="num" class="num">0</span>
                    <div id="notif-content" class="content">
                        <div class="header">
                            Notifications
                            <img onclick="notificationCloseButton()" class="close" src="../assets/image/closeIcon.png" alt="croix fermante">
                        </div>
                        <div class="notification-content">
                           <!--  aucune notification -->
                           <div onclick="readNotif(1)" class="notification-card" id="notification-1">
                               <div class="card-content">
                                    On s'en ballance
                               </div>
                               <img onclick="removeNotif(1)" class="close" src="../assets/image/closeIcon.png" alt="croix fermante">
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
                            <img src="../assets/image/refresh.png" alt="Refresh icon">
                            <img src="../assets/image/more.png" alt="More icon">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="skill">
                            Unity
                            <div class="skill-bar-holder">
                                <span class="skill-bar" aria-valuenow="60" aria-valuemin="1" aria-valuemax="100"></span>
                            </div> 
                        </div>
                        <div class="skill">
                            Unity
                            <div class="skill-bar-holder">
                                <span class="skill-bar" aria-valuenow="60" aria-valuemin="1" aria-valuemax="100"></span>
                            </div> 
                        </div>
                        <div class="skill">
                            Unity
                            <div class="skill-bar-holder">
                                <span class="skill-bar" aria-valuenow="60" aria-valuemin="1" aria-valuemax="100"></span>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </header>
    <script src="../assets/script/Skills.js"></script>
    <script src="../assets/script/notification.js"></script>
</body>
</html>