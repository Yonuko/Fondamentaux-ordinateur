<?php
    session_name("PortfolioSE");
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/Admin/admin.css">
    <link rel="stylesheet" href="../assets/style/Admin/SpecificPage.css">
    <title>Admin - blog</title>
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
                <!-- First row where there are showed the web site infos -->
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="../assets/image/blogIcon.png" alt="Messages count icon">
                        <div>Post le plus regardé:<br>
                            Bravery of History
                        </div>
                    </div>
                </div>
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="../assets/image/pagesViewed.png" alt="Messages count icon">
                        42 vues cette semaine
                    </div>
                </div>
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="../assets/image/Users.png" alt="Messages count icon">
                        120 vues totales
                    </div>
                </div>
                <div class="card blog">
                    <div class="card-header">
                        <div class="card-title">Blog</div>
                        <div>
                            <img src="../assets/image/refresh.png" alt="Refresh icon">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <img src="../assets/image/Uploads/Projets/BoH.jpg" alt="Icon de Bravery Of History (BoH)">
                                <div>Rapport de stage</div> <!-- Remplacer par le nom du projet -->
                                <div>Expérience pro</div>
                                <div>vues semaine: 4</div> <!-- Remplacer par le nombre de vues de cette semaine -->
                                <div>vues totales: 15</div> <!-- Remplacer par le nombre de vues de cette semaine -->
                                <img class="edit" src="../assets/image/edit.png" alt="Edit Icon">
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="../assets/image/Uploads/Projets/BoH.jpg" alt="Icon de Bravery Of History (BoH)">
                                <div>Rapport de stage</div> <!-- Remplacer par le nom du projet -->
                                <div>Expérience pro</div>
                                <div>vues semaine: 4</div> <!-- Remplacer par le nombre de vues de cette semaine -->
                                <div>vues totales: 15</div> <!-- Remplacer par le nombre de vues de cette semaine -->
                                <img class="edit" src="../assets/image/edit.png" alt="Edit Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </header>
    <script src="../assets/script/notification.js"></script>
</body>
</html>