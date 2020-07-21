<?php

needAdmin();

$data = $request->getBody();

print_r($data);
echo "<br>";

$rqt = "SELECT name FROM skills;";
$skillNames = sendRequest($rqt, [], PDO::FETCH_ASSOC);

foreach($skillNames as $skillName){
    extract($skillName);
    if(isset($data[str_replace(' ', '_', $name)])){
        echo "$name<br>";
        $rqt = "UPDATE skills SET level = ? WHERE name = ?;";
        sendRequest($rqt, [$data[str_replace(' ', '_', $name)], $name], PDO::FETCH_ASSOC);
    }
}

header("Location:http://localhost/portfolio/admin/skills");