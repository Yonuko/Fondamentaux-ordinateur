<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/Admin/admin.css">
    <link rel="stylesheet" href="../assets/style/Admin/SpecificPage.css">
    <title>Admin - projets</title>
    <?php
        if(!isset($_SESSION["name"]) || !isset($_SESSION["id"])){
            header("location:https://sacha-eghiazarian.fr/login");
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
                <a href="https://sacha-eghiazarian.fr/admin" class="element">
                    <img src="https://sacha-eghiazarian.fr/assets/image/homeIcon.png" alt="home icon"> Accueil
                </a>
                <a href="https://sacha-eghiazarian.fr/admin/blog" class="element">
                    <img src="https://sacha-eghiazarian.fr/assets/image/blogIcon.png" alt="blog icon"> Blog
                </a>
                <a href="https://sacha-eghiazarian.fr/admin/texte" class="element">
                    <img src="https://sacha-eghiazarian.fr/assets/image/textIcon.png" alt="Text icon"> Texte
                </a>
                <a href="https://sacha-eghiazarian.fr/admin/skills" class="element">
                    <img src="https://sacha-eghiazarian.fr/assets/image/skillsIcon.png" alt="skills icon"> Competences
                </a>
                <a href="https://sacha-eghiazarian.fr/admin/projects" class="element">
                    <img src="https://sacha-eghiazarian.fr/assets/image/projectIcon.png" alt="project icon"> Projets
                </a>
                <a href="https://sacha-eghiazarian.fr/admin/CV" class="element">
                    <img src="https://sacha-eghiazarian.fr/assets/image/cvIcon.png" alt="cv icon"> CV
                </a>
            </div>
        </div>

        <div class="secondary-menu">
            <div class="manageMenu">
                <form action="https://sacha-eghiazarian.fr/admin/projects/create" method="get">
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
                        <a href="https://sacha-eghiazarian.fr/">Retour au site</a>
                        <a href="https://sacha-eghiazarian.fr/blog">Retour au blog</a>
                        <a href="#">Messages</a>
                        <form action="https://sacha-eghiazarian.fr/logout" method="POST">
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
                            <?php 
                                $rqt = "SELECT name FROM projects ORDER BY views DESC LIMIT 1;";
                                echo sendRequest($rqt, [], PDO::FETCH_ASSOC)[0]["name"];
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="../assets/image/pagesViewed.png" alt="Messages count icon">
                        <?php echo sendRequest("SELECT SUM(views_semaine) FROM projects;", [], PDO::FETCH_NUM)[0][0] ?> vues cette semaine
                    </div>
                </div>
                <div class="card webSite-info">
                    <div class="card-body">
                        <img src="../assets/image/Users.png" alt="Messages count icon">
                        <?php 
                            $rqt = "SELECT SUM(views) as count from projects;";
                            echo sendRequest($rqt, [], PDO::FETCH_ASSOC)[0]["count"] . " vues totales";
                        ?>
                    </div>
                </div>
                <div class="card projet">
                    <div class="card-header">
                        <div class="card-title">Projets</div>
                        <div>
                            <img src="../assets/image/refresh.png" alt="Refresh icon">
                        </div>
                    </div>
                    <div class="card-body">
                        <?php 
                            $rqt = "SELECT * FROM projects ORDER BY views_semaine DESC;";
                            $projects = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                            if(!is_null($projects)){  
                                foreach($projects as $project){
                                    extract($project);
                                    $rqt = "SELECT name FROM project_type p INNER JOIN project_types pt 
                                    ON pt.project_type_id = p.project_type_id WHERE project_id = ? LIMIT 1;";
                                    $type = sendRequest($rqt, [$project_id], PDO::FETCH_ASSOC)[0]["name"];
                                    echo "<div class='card'>
                                    <div class='card-body'>
                                        <img src='https://sacha-eghiazarian.fr/assets/image/Uploads/Projets/$logo' alt='Icon du projet $name'>
                                        <div>$name</div>
                                        <div>$type</div>
                                        <div>vues semaine: $views_semaine</div> <!-- Remplacer par le nombre de vues de cette semaine -->
                                        <div>vues totales: $views</div>";
                                        if($isShown){
                                            echo "<input style='cursor: pointer;'
                                            onclick=\"location.href = 'https://sacha-eghiazarian.fr/admin/projects/$project_id/active'\" 
                                            type='checkbox' value='visible' checked>";
                                        }else{
                                            echo "<input style='cursor: pointer;'
                                            onclick=\"location.href = 'https://sacha-eghiazarian.fr/admin/projects/$project_id/active'\"
                                            type='checkbox' value='visible'>";
                                        }
                                        echo "<img class='edit' onclick=\"window.location = 'https://sacha-eghiazarian.fr/admin/projects/$project_id'\"
                                        src='https://sacha-eghiazarian.fr/assets/image/edit.png' alt='Edit Icon'>
                                        <img class='edit' onclick=\"window.location = 'https://sacha-eghiazarian.fr/admin/projects/$project_id/delete'\"
                                        src='https://sacha-eghiazarian.fr/assets/image/delete.png' alt='Delete Icon'>
                                    </div>
                                </div>";
                                }
                            }else{
                                echo "<p style='text-align:center;'>Aucun projet disponible, veuillez en créer un</p>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </header>
    <script src="../assets/script/notification.js"></script>
</body>
</html>