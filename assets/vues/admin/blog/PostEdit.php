<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Admin/admin.css">
    <link rel="stylesheet" href="http://localhost/portfolio/assets/style/Admin/createProject.css">
    <script src="http://localhost/portfolio/assets/ckeditor5-build-classic-20.0.0/ckeditor5-build-classic/ckeditor.js"></script>
    <title>Admin - project edit</title>
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
                <div class="card projet">
                    <div class="card-header">
                        <div class="card-title">
                            <?php
                                echo sendRequest("SELECT name FROM posts WHERE post_id = ?;", [$id], PDO::FETCH_NUM)[0][0]; 
                            ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php 
                            $rqt = "SELECT * FROM posts WHERE post_id = ?;";
                            $post = sendRequest($rqt, [$id], PDO::FETCH_ASSOC)[0];
                        ?>
                        <form action="http://localhost/portfolio/admin/blog/<?php echo $id?>/update" method="POST" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?php echo $id?>" hidden>
                            <div class="form-content">
                               <div class="scrolleur">
                                <label for="name">Nom du projet</label>
                                    <input type="text" name="name" value="<?php echo $post["name"] ?>" required>
                                    <label for="type">Type</label>
                                    <div class="typeSelector">
                                        <select name="type">
                                            <?php 
                                                $rqt = "SELECT * FROM Categorie;";
                                                $types = sendRequest($rqt, [], PDO::FETCH_ASSOC);
                                                $current_type = sendRequest("SELECT name FROM Categorie WHERE category_id = ?;",
                                                    [$post["category_id"]], PDO::FETCH_NUM)[0][0];
                                                if(!is_null($types)){
                                                    foreach($types as $type){
                                                        if($type["name"] === $current_type){
                                                            echo "<option selected value='" . $type["name"] . "'>" . $type["name"] . "</option>";
                                                        }else{
                                                            echo "<option value='" . $type["name"] . "'>" . $type["name"] . "</option>";
                                                        }
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
                                    <label for="logo">Logo du projet</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="logo">
                                    <p style="text-align: center;">Paragraphes</p>
                                    <div id="Descriptions">
                                        <?php 
                                            $rqt = "SELECT * FROM post_descriptions WHERE post_id = ? ORDER BY `order` ASC;";
                                            $descriptions = sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
                                            $i = 1;
                                            foreach($descriptions as $description){
                                                extract($description);
                                                echo "
                                                <label id='subName-label-$i' for='subName-$i' class='label'>Sous titre paragraphe $i</label>
                                                <input type='text' id='subName-$i' name='subName-$i' value='$subTitle'>
                                                <div id='description-label-$i' class='toggler'>
                                                    <img class='expend toggle' src='http://localhost/portfolio/assets/image/ArrowIcon.png'>
                                                    <label for='description-$i'>Description (paragraphe) $i</label>
                                                </div>
                                                <textarea id='description-textarea-$i' name='description-$i'></textarea>
                                                <script>
                                                    ClassicEditor
                                                        .create( document.querySelector( '#description-textarea-$i' ) )
                                                        .then( editor => {
                                                            editor.setData('" . html_entity_decode($content) . "');
                                                        })
                                                        .catch( error => {
                                                            console.error( error );
                                                        });
                                                </script>
                                                ";
                                                $i++;
                                            }
                                        ?>
                                    </div>
                               </div>
                            </div>
                            <div class="descriptionButton">
                                <img id="addDesc" src="http://localhost/portfolio/assets/image/CirclePlus.png" alt="Add a description">
                                <img id="removeDesc" style="display: none;"
                                    src="http://localhost/portfolio/assets/image/minus.png" alt="Remove a description">
                            </div>
                            <input class="create" type="submit" name="create" value="Edit">
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </header>
    <script src="http://localhost/portfolio/assets/script/notification.js"></script>
    <script src="http://localhost/portfolio/assets/script/AddDescription.js"></script>
</body>
</html>