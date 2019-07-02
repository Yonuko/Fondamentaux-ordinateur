<?php

function ShowPresentationForm($db){
    // Actualise la valeur de la presentation
    if(isset($_POST['refresh'])){
        $rqt = "UPDATE a_propos SET message = ?;";
        SendRequest($rqt, $db, [$_POST['text']], PDO::FETCH_NUM);
    }

    // Affiche le text de présentation
    $rqt = "SELECT * FROM a_propos;";
    $pres = SendRequest($rqt, $db, [], PDO::FETCH_NUM);
    echo "<h1 style='text-align: center; font-size: 3vw;'>A-Propos</h1>";
    echo "<form action='#' method='post'>
            <textarea name='text' rows=\"16\" cols=\"120\">".$pres[0]."</textarea>
            <script>CKEDITOR.replace('text');</script><br>
            <input type='submit' name='refresh' value='Refresh'>
          </form>";
}