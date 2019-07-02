<?php

// Ouvre la gestion des compétences
function ShowCompetences($db){

    // Stock toutes les différentes logs pour pouvoir les afficher en bas de la page et non pas là où
    // les données sont traités
    $logs = ["", "Votre modification a été prise en compte <br>", "Votre compétence à bien été ajoutée",
        "Veuillez entrer un nom de compétences", "Votre compétence à bien été suprimmée",
        "Une Erreure est survenue lors de la création de cette compétences (Il est possible qu'elle existe déjà)"];
    $logNumber = 0;

    // Effectue les requêtes SQL correspondantes au modifications.

    // Modifie le niveau de la compétence.
    if(isset($_POST["change"]) && $_POST["change"]){
        $rqt = "UPDATE competences SET niveau = ? WHERE competence_id = ?;";
        SendRequestTab($rqt, $db, [$_POST["compLevel"], $_POST['actualComp']], PDO::FETCH_NUM);
        // Permet d'afficher le message indiquant la réussite du procédé.
        $logNumber = 1;
        // Gère le rafraichissement de l'affichage des compétences
    }else if(isset($_POST["refresh"]) && $_POST["refresh"]){
        // Récupère toutes les compétences de la table
        $rqt = "SELECT * FROM competences;";
        $competences = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
        for($i = 0; $i < sizeof($competences); $i++){
            $checkBoxName = str_replace(" ", "", $competences[$i][1]);
            $rqt = "UPDATE competences SET active = ? WHERE name = ?;";
            SendRequestTab($rqt, $db, [(int)(isset($_POST[$checkBoxName])), $competences[$i][1]], PDO::FETCH_NUM);
        }
        // Ajoute une nouvelle compétences
    }else if(isset($_POST["Add"]) && $_POST["Add"]){
        if(isset($_POST["nameToAdd"]) && $_POST["nameToAdd"] != ""){
            $rqt = "INSERT INTO competences (name, `type`) VALUES (?, ?);";
            SendRequest($rqt, $db, [$_POST["nameToAdd"], $_POST["compType"]], PDO::FETCH_NUM);
            $logNumber = 2;
        }else{
            $logNumber = 3;
        }
        //Supprime la compétence
    }else if(isset($_POST["delete"]) && $_POST["delete"]){
        $rqt = "DELETE FROM competences WHERE competence_id = ?;";
        SendRequest($rqt, $db, [$_POST["actualComp"]], PDO::FETCH_NUM);
        $logNumber = 4;
    }

    // Récupère toutes les compétences de la table
    $rqt = "SELECT * FROM competences ORDER BY niveau DESC;";
    $competences = SendRequestTab($rqt, $db, [], PDO::FETCH_NUM);
    echo "<h1>Compétences :</h1>";
    echo "<form action='#' method='post'>";
    for($i = 0; $i < sizeof($competences); $i++){
        $compNameDisplay = $competences[$i][1];
        $compName = str_replace(" ", "", $competences[$i][1]);
        $compLevel = $competences[$i][3];
        echo "
            <div class=\"progress\" style='width: 40vw; display: inline-block;'>
                <div class=\"progress-bar\" role=\"progressbar\" data-max-value=\"$compLevel\" style=\"width: $compLevel%\">$compNameDisplay</div>
            </div>";
        echo ($competences[$i][4]) ? "<input type='checkbox' name='$compName' checked='checked' style='margin-left: 2%;'>Afficher<br>":
            "<input type='checkbox' name='$compName' style='margin-left: 2%;'>Afficher<br>";
    }
    echo "</from>";

    // Affiche les bouttons de gestions
    ShowCompButtons($competences);

    // Affiche les logs selon l'action effectué
    echo $logs[$logNumber];

    // Affiche le boutton de retour
    returnButton();
}

// Affiche les bouttons de des compétences
function ShowCompButtons($competences){

    echo "<form action='#' method='post'>";

    // Affiche la lite des compétences et leurs valeurs
    echo "<select name='actualComp'>";
    for($i = 0; $i < sizeof($competences); $i++){
        $compName = $competences[$i][1];
        $compID = $competences[$i][0];
        echo "<option name='$compName' value='$compID'>$compName</option>";
    }
    echo "</select>";

    // Affiche la zone de nombre
    echo"<input type='number' name='compLevel' placeholder='50...' min='1' max='100'>";

    // Affiche les 3 bouttons
    echo "
                <input type='submit' name='change' value='Modifier'>
                <input type='submit' name='delete' value='Supprimer'>
                <input type='submit' name='refresh' value='Refresh'><br>
                <input type='text' name='nameToAdd' placeholder='Nom de la compétence...'>
                <select name='compType'>
                    <option value='Dev'>Dev</option>
                    <option value='Infra'>Infra</option>
                    <option value='Web'>Web</option>
                </select>
                <input type='submit' name='Add' value='Ajouter'>
              </form>";
}