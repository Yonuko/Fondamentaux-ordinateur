<?php

// Ouvre la gestion des projets
function ShowProjects($db){

    // Modifie les données des projets grâce à l'onglêt administrateur
    ChangeProjects($db);

    // Change la taille des formulaires WYSIWYG
    echo "<script>CKEDITOR.config.width = '60vw';</script>";

    // Affiche toutes les projets de la table
    $rqt = "SELECT * FROM projets ORDER BY projet_id;";
    $projets = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);

    // Affiche une preview des projets et permet de les modifiers
    echo "<h1 style='text-align: center; font-size: 3vw;'>Projets</h1>";
    echo "<form action='#' method='post' enctype=\"multipart/form-data\"><br><br>";
    for($i = 0; $i < sizeof($projets); $i++){
        $id = $projets[$i][0];
        $name = $projets[$i][1];
        $logo = $projets[$i][4];
        $link = $projets[$i][3];
        echo "<div class='container'>";
        echo "<div class='row'>
                    <div class='col'>
                        <p>Nom du projet:</p>
                        <input type='text' name='title$id' value='$name'>
                    </div>
                    <div class='col'>
                        <p>Logo:</p>
                        <img src='$logo' style='width:5vw; height:auto;'>
                        <input type=\"file\" name=\"logo$id\" accept=\"image/jpeg,image/png\" value=\"Changer le logo...\" >
                    </div>
                  </div>";
        echo "
                  <p>Contenu:</p>
                  <div class='row'> 
                    <textarea name='message$id' rows=\"16\" cols=\"120\">".$projets[$i][2]."</textarea>
                    <script>CKEDITOR.replace('message$id');</script>
                  </div>";
        echo "<div class='row'>
                    <div class='col'>
                        <p style='margin-top: 2%;'>lien :</p>
                        <input type='text' name='link$id' style='width: 25vw;' value=\"$link\">
                    </div>
                    <div class='col'>
                        <p style='margin-top: 2%;'>type :</p>
                        <select name='type$id'>";

        $linkType = ["Normal","Video","Image"];
        for($j = 0; $j < sizeof($linkType); $j++){
            if($projets[$i][5] == $linkType[$j]){
                echo "<option value='$linkType[$j]' selected='selected'>$linkType[$j]</option>";
            }else{
                echo "<option value='$linkType[$j]'>$linkType[$j]</option>";
            }
        }
        echo"    </select>
                    </div>
                  </div>
                  <div class='row' style='padding-top: 10px;'>
                    <input type='submit' name='refresh' value='Refresh' style=' margin-right: 10px;'>
                    <input type='submit' name='del$id' value='Supprimer' style=' margin-right: 10px;'>
                  </div>";
        echo "</div><br><br><br>";
    }
    echo "<input type='submit' name='add' value='Ajouter' id='ScrollDown'>";
    echo "</form >";

    // Affiche le boutton de retour
    returnButton();
}

function ChangeProjects($db){

    $rqt = "SELECT projet_id FROM projets;";
    $projets = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);

    // Ajoute un nouveau projet
    if(isset($_POST["add"])){
        // Ajoute un nouveau projet
        $rqt = "INSERT INTO projets (name) VALUES ('');";
        SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
        // Par defaut le nom des projets est "New Project (id)"
        $rqt = "UPDATE projets SET name = CONCAT('New Project (',?,')') WHERE projet_id = ?;";
        SendRequestTab($rqt, $db, [$db->lastInsertId(), $db->lastInsertId()], PDO::FETCH_NUM);

        //Scroll au bas de la page
        header("Location: Admin.php#ScrollDown");
    }

    for($i = 0; $i < sizeof($projets); $i++){
        $id = $projets[$i][0];
        if(isset($_POST["refresh"])){
            // Vérifie si il faut changer d'image
            if(isset($_FILES["logo$id"])){

                $uploadfile = "./assets/images/Projet/";

                //Recupère le nom
                $filename = $_FILES["logo$id"]["name"];
                //Met en place le path de destination du fichier
                $dest = $uploadfile . $filename;
                if($move = move_uploaded_file($_FILES["logo$id"]["tmp_name"], $dest) != 0){
                    $rqt = "UPDATE projets SET logo = ? WHERE projet_id = ?;";
                    SendRequestTab($rqt, $db, [$dest, $id], PDO::FETCH_NUM);
                }
            }

            if(isset($_POST["title$id"])){
                // Change les valeurs textuel des projets
                $rqt = "UPDATE projets SET name = ?, message = ?, lien = ?, link_type = ? WHERE projet_id = ?;";
                SendRequestTab($rqt, $db,
                    [
                        $_POST["title$id"],
                        (isset($_POST["message$id"])) ? $_POST["message$id"] : "",
                        (isset($_POST["link$id"])) ? $_POST["link$id"] : "",
                        $_POST["type$id"],
                        $id
                    ]
                    , PDO::FETCH_NUM);
            }
        }else if(isset($_POST["del$id"])){
            // Supprime le projet séléctionné
            $rqt = "DELETE FROM projets WHERE projet_id = ?;";
            SendRequestTab($rqt, $db, [$id], PDO::FETCH_NUM);
        }
    }
}