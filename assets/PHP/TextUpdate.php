<?php

needAdmin();

$data = $request->getBody();

$i = 1;
while(isset($data["text-$i"])){
    $rqt = "UPDATE dinamictexts SET `text` = ? WHERE id = ?;";
    sendRequest($rqt, [$data["text-$i"], $i], PDO::FETCH_ASSOC);
    $i++;
}

header("Location:https://sacha-eghiazarian.fr/admin/texte");