<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Admin/admin.css">
    <title>Admin - accueil</title>
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
        <main>
            <div class="body-content">
                <!-- First row where there are showed the web site infos -->
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="http://localhost/portfolio/assets/image/Messages.png" alt="Messages count icon">
                        12 nouveaux messages
                    </div>
                </div>
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="http://localhost/portfolio/assets/image/pagesViewed.png" alt="Messages count icon">
                        42 pages vues
                    </div>
                </div>
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="http://localhost/portfolio/assets/image/Users.png" alt="Messages count icon">
                        10 utilisateurs
                    </div>
                </div>
                <!-- Card of projects and skills -->
                <div class="card projet">
                    <div class="card-header">
                        <div class="card-title">Projets</div>
                        <div>
                            <img src="http://localhost/portfolio/assets/image/refresh.png" alt="Refresh icon">
                            <img src="http://localhost/portfolio/assets/image/more.png" alt="More icon">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <img src="http://localhost/portfolio/assets/image/Uploads/Projets/BoH.jpg" alt="Icon de Bravery Of History (BoH)">
                                <div>Bravery of History</div> <!-- Remplacer par le nom du projet -->
                                <div>Dev</div>
                                <div>vues : 4</div> <!-- Remplacer par le nombre de vues -->
                                <img class="edit" src="http://localhost/portfolio/assets/image/edit.png" alt="Edit Icon">
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="http://localhost/portfolio/assets/image/Uploads/Projets/BoH.jpg" alt="Icon de Bravery Of History (BoH)">
                                <div>Bravery of History</div> <!-- Remplacer par le nom du projet -->
                                <div>Dev</div>
                                <div>vues : 4</div> <!-- Remplacer par le nombre de vues -->
                                <img class="edit" src="http://localhost/portfolio/assets/image/edit.png" alt="Edit Icon">
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="http://localhost/portfolio/assets/image/Uploads/Projets/BoH.jpg" alt="Icon de Bravery Of History (BoH)">
                                <div>Bravery of History</div> <!-- Remplacer par le nom du projet -->
                                <div>Dev</div>
                                <div>vues : 4</div> <!-- Remplacer par le nombre de vues -->
                                <img class="edit" src="http://localhost/portfolio/assets/image/edit.png" alt="Edit Icon">
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="http://localhost/portfolio/assets/image/Uploads/Projets/BoH.jpg" alt="Icon de Bravery Of History (BoH)">
                                <div>Bravery of History</div> <!-- Remplacer par le nom du projet -->
                                <div>Dev</div>
                                <div>vues : 4</div> <!-- Remplacer par le nombre de vues -->
                                <img class="edit" src="http://localhost/portfolio/assets/image/edit.png" alt="Edit Icon">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blog">
                    <div class="card-header">
                        <div class="card-title">Blog</div>
                        <div>
                            <img src="http://localhost/portfolio/assets/image/refresh.png" alt="Refresh icon">
                            <img src="http://localhost/portfolio/assets/image/more.png" alt="More icon">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <img src="http://localhost/portfolio/assets/image/Uploads/Projets/BoH.jpg" alt="Icon de Bravery Of History (BoH)">
                                <div>Rapport de stage</div> <!-- Remplacer par le nom du projet -->
                                <div>Expérience pro</div>
                                <div>vues : 4</div> <!-- Remplacer par le nombre de vues -->
                                <img class="edit" src="http://localhost/portfolio/assets/image/edit.png" alt="Edit Icon">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card skills">
                    <div class="card-header">
                        <div class="card-title">Competences</div>
                        <div>
                            <img src="http://localhost/portfolio/assets/image/refresh.png" alt="Refresh icon">
                            <img src="http://localhost/portfolio/assets/image/more.png" alt="More icon">
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
    <script src="http://localhost/portfolio/assets/script/notification.js"></script>
    <script src="http://localhost/portfolio/assets/script/Skills.js"></script>
</body>
</html>