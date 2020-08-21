<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Admin/admin.css">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Admin/createProject.css">
    <script src="https://sacha-eghiazarian.fr/assets/ckeditor5-build-classic-20.0.0/ckeditor5-build-classic/ckeditor.js"></script>
    <title>Admin - detail d'un projet</title>
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
            <div class="notification">
                <button id="bell" class="logo"></button>
                <span id="num" class="num">0</span>
                <div id="notif-content" class="content">
                    <div class="header">
                        Notifications
                        <img onclick="notificationCloseButton()" class="close" src="https://sacha-eghiazarian.fr/assets/image/closeIcon.png" alt="croix fermante">
                    </div>
                    <div class="notification-content">
                        <!--  aucune notification -->
                        <div onclick="readNotif(1)" class="notification-card" id="notification-1">
                            <div class="card-content">
                                On s'en ballance
                            </div>
                            <img onclick="removeNotif(1)" class="close" src="https://sacha-eghiazarian.fr/assets/image/closeIcon.png" alt="croix fermante">
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
        <main>
            <div class="body-content">
                <div class="card projet">
                    <div class="card-header">
                        <div class="card-title">Nouvel article</div>
                    </div>
                    <div class="card-body">
                        <form action="https://sacha-eghiazarian.fr/admin/blog/store" method="POST" enctype="multipart/form-data">
                            <div class="form-content">
                               <div class="scrolleur">
                                <label for="name">Nom de l'article</label>
                                    <input type="text" name="name" value="Nouveau Post" required>
                                    <label for="type">Type</label>
                                    <div class="typeSelector">
                                        <select name="type">
                                            <?php 
                                                $rqt = "SELECT * FROM categorie;";
                                                $types = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                                                if(!is_null($types)){
                                                    foreach($types as $type){
                                                        echo "<option value='" . $type["name"] . "'>" . $type["name"] . "</option>";
                                                    }
                                                }else{
                                                    echo "<option value=''>none</option>";
                                                }
                                            ?>
                                        </select>
                                        <input type="text" name="newType">
                                        <input type="submit" name="addNewType" value="ajouter" formnovalidate>
                                        <input type="submit" name="delType" value="supprimer" formnovalidate>
                                    </div>
                                    <label for="type">Mots clés</label>
                                    <div class="typeSelector">
                                        <input id="kw" type="text" name="kw">
                                        <button id="addType" type="button">ajouter</button>
                                    </div>
                                    <div class="types"></div>
                                    <label for="logo">Logo de l'article</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="logo" required>
                                    <p style="text-align: center;">Paragraphes</p>
                                    <div id="Descriptions">
                                        <label for="subName-1" class="label">Sous titre paragraphe 1</label>
                                        <input type="text" name="subName-1">
                                        <div id="description-label-1" class="toggler">
                                            <img class="expend toggle" src="https://sacha-eghiazarian.fr/assets/image/ArrowIcon.png">
                                            <label for="description-1">Description (paragraphe) 1</label>
                                        </div>
                                        <textarea id="description-textarea-1" name="description-1"></textarea>
                                        <script>
                                            ClassicEditor
                                                .create( document.querySelector( '#description-textarea-1' ) )
                                                .catch( error => {
                                                    console.error( error );
                                                });
                                        </script>
                                    </div>
                               </div>
                            </div>
                            <div class="descriptionButton">
                                <img id="addDesc" src="https://sacha-eghiazarian.fr/assets/image/CirclePlus.png" alt="Add a description">
                                <img id="removeDesc" style="display: none;"
                                    src="https://sacha-eghiazarian.fr/assets/image/minus.png" alt="Remove a description">
                            </div>
                            <input class="create" type="submit" name="create" value="Créer">
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </header>
    <script src="https://sacha-eghiazarian.fr/assets/script/notification.js"></script>
    <script src="https://sacha-eghiazarian.fr/assets/script/AddDescription.js"></script>
    <script src="https://sacha-eghiazarian.fr/assets/script/addKeywords.js"></script>
</body>
</html>