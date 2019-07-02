<?php

function ShowCVInfos($db){

    // Change la taille des formulaires WYSIWYG
    echo "<script>CKEDITOR.config.width = '80%';</script>";

    // Ajoute a la base de données les différentes modification apporter au CV
    ChangeCV($db);

    // Affiche le sous titre sur le CV
    $rqt = "SELECT * FROM CV_Formation;";
    $subText = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
    $subText = strtoupper($subText[0][0]);

    // Affiche les différentes compétences opérationnelle
    $rqt = "SELECT * FROM comp_fonctionnelle_cv;";
    $compFonctionnelle = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
    $compFonctionnelle = $compFonctionnelle[0][0];

    echo "<h1 style='text-align: center; font-size: 3vw;'>CV</h1>";
    echo "<form action='#' method='post' style='left:10%; position: relative;'>
            <br><br><br>
            <h2>Sous texte :</h2>
            <p>Formation actuelle :</p>
            <input type='text' name='text0' value='$subText' style='width: 80%;'><br><br>
            <input type='submit' name='Refresh' value='Refresh'>
            <h2>Compétences :</h2>
            <p>Compétences Opérationnelles :</p>
            <textarea name='text1'>$compFonctionnelle</textarea>
            <script>CKEDITOR.replace('text1')</script><br>
            <input type='submit' name='Refresh' value='Refresh'>
            <h2>Expériences professionnelles :</h2>";

    // Récupère les expériences professionnelles
    $rqt = "SELECT * FROM experience_cv ORDER BY exp_id;";
    $exps = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);

    // Affiche les expériences professionnelles
    for($i = 0; $i < sizeof($exps); $i++) {
        $id = $exps[$i][0];
        $nom = $exps[$i][1];
        $message = $exps[$i][2];
        $link = $exps[$i][3];
        echo "<p>Nom de l'entreprise :</p>
              <input type='text' name='title$id' value='$nom' style='width: 80%;'><br>
              <p>Text :</p>
              <textarea name='message$id'>$message</textarea>
              <script>CKEDITOR.replace('message$id')</script>
              <p>Lien : </p>
              <input type='text' name='link$id' value='$link' style='width: 80%;'><br>
              <input type='submit' name='Addexp' value='Ajouter'>
              <input type='submit' name='Refresh' value='Refresh'>
              <input type='submit' name='delexp$id' value='Supprimer'><br><br>
        ";
    }

    echo "<h2>Diplômes :</h2>";

    // Récupère mes diplômes
    $rqt = "SELECT * FROM diplomes ORDER BY diplome_id;";
    $diplomes = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);

    // Affiche mes diplômes
    for($i = 0; $i < sizeof($diplomes); $i++) {
        $id = $diplomes[$i][0];
        $date = $diplomes[$i][1];
        $info = $diplomes[$i][2];
        echo "<p>Formation / Diplômes :</p>
              <input type='text' name='date$id' value='$date'><br>
              <p>info :</p>
              <textarea name='info$id'>$info</textarea><br>
              <input type='submit' name='Adddiplome' value='Ajouter'>
              <input type='submit' name='Refresh' value='Refresh'>
              <input type='submit' name='deldiplome$id' value='Suprimmer'>
              <script>CKEDITOR.replace('info$id')</script>";
    }
    echo "</form><br><br>";

    // Affiche le boutton de retour
    returnButton();

}

function ChangeCV($db){
    // Récupère toutes les expériences professionnelles
    $rqt = "SELECT * FROM experience_cv;";
    $exps = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);

    // Récupère tous les diplomes
    $rqt = "SELECT * FROM diplomes;";
    $diplomes = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);

    // Mets à jour les données du CV
    if(isset($_POST["Refresh"])) {
        // Met à jour le sous titre du CV (job actuel)
        $rqt = "UPDATE CV_Formation SET message = ?;";
        SendRequestTab($rqt, $db, [(isset($_POST["text0"]) ? strtoupper($_POST["text0"]): "")], PDO::FETCH_NUM);
        // Met à jour le les compétences opérationnelles
        $rqt = "UPDATE comp_fonctionnelle_cv SET message = ?";
        SendRequestTab($rqt, $db, [(isset($_POST["text1"]) ? $_POST["text1"]: "")], PDO::FETCH_NUM);
        // Met à jour les expériences professionnelles
        for($i = 0; $i < sizeof($exps); $i++){
            $id = $exps[$i][0];
            $rqt = "UPDATE experience_cv SET `name` = ?, message = ?, link = ? WHERE exp_id = ?;";
            SendRequestTab($rqt, $db, [
                (isset($_POST["title$id"]) ? $_POST["title$id"]: ""),
                (isset($_POST["message$id"]) ? $_POST["message$id"]: ""),
                (isset($_POST["link$id"]) ? $_POST["link$id"]: ""),
                $id
            ], PDO::FETCH_NUM);
        }
        // Met à jour les diplômes
        for($i = 0; $i < sizeof($diplomes); $i++){
            $id = $diplomes[$i][0];
            $rqt = "UPDATE diplomes SET `date` = ?, info = ? WHERE diplome_id = ?;";
            SendRequestTab($rqt, $db, [
                (isset($_POST["date$id"]) ? $_POST["date$id"]: ""),
                (isset($_POST["info$id"]) ? $_POST["info$id"]: ""),
                $id
            ], PDO::FETCH_NUM);
        }

    }else if(isset($_POST["Addexp"])){
        // Ajoute une expérience professionnelle au CV
        $rqt = "INSERT INTO experience_cv (`name`, message, link) VALUES (?, ?, ?);";
        SendRequestTab($rqt, $db, ["Nouvelle expérience", "", ""], PDO::FETCH_NUM);
    }else if(isset($_POST["Adddiplome"])){
        // Ajoute un diplome au CV
        $rqt = "INSERT INTO diplomes (`date`, info) VALUES (?, ?);";
        SendRequestTab($rqt, $db, [date("Y"), "Nouveau diplôme"], PDO::FETCH_NUM);
    }

    // Supprime l'expérience séléctionnée
    for($i = 0; $i < sizeof($exps); $i++){
        $id = $exps[$i][0];
        if(isset($_POST["delexp$id"])){
            $rqt = "DELETE FROM experience_cv WHERE exp_id = ?;";
            SendRequestTab($rqt, $db, [$id], PDO::FETCH_NUM);
        }
    }

    // Supprime le diplome séléctionné
    for($i = 0; $i < sizeof($diplomes); $i++){
        $id = $diplomes[$i][0];
        if(isset($_POST["deldiplome$id"])){
            $rqt = "DELETE FROM diplomes WHERE diplome_id = ?;";
            SendRequestTab($rqt, $db, [$id], PDO::FETCH_NUM);
        }
    }
}