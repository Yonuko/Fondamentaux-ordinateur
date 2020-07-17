<?php

needAdmin();

$data = $request->getBody();

$id = $data["id"];

if(isset($data["addNewType"])){
    if(isset($data["newType"])){
        if(isset($data["subType"]) && $data["subType"] !== "null"){
            $rqt = "SELECT project_type_id FROM project_type WHERE name = ?;";
            $subTypeID = sendRequest($rqt, [$data["subType"]], PDO::FETCH_NUM)[0][0];
            $rqt = "INSERT INTO project_type VALUES (null, ?, ?);";
            sendRequest($rqt, [$data["newType"], $subTypeID], PDO::FETCH_ASSOC);
        }else{
            $rqt = "INSERT INTO project_type VALUES (null, ?, null);";
            sendRequest($rqt, [$data["newType"]], PDO::FETCH_ASSOC);
        }
    }
    header("Location:http://localhost/portfolio/admin/projects/$id");
    return;
}

if(isset($data["delType"])){
    $rqt = "DELETE FROM project_type WHERE name = ?;";
    sendRequest($rqt, [$data["type"]], PDO::FETCH_ASSOC);
    header("Location:http://localhost/portfolio/admin/projects/$id");
    return;
}

if(!isset($data["type-1"])){
    header("Location:http://localhost/portfolio/admin/projects/$id");
    return;
}

// Create the new project

if(isset($_FILES["logo"]["name"]) && $_FILES["logo"]["size"] !== 0){
    $filename = "";

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/image/Uploads/Projets/";
    $target_file = $target_dir . basename($_FILES["logo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($data["logo"])) {
        $check = getimagesize($_FILES["logo"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
        header("Refresh:3;url=http://localhost/portfolio/admin/projects/$id");
        return;
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
            $filename = basename( $_FILES["logo"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
            header("Refresh:3;url=http://localhost/portfolio/admin/projects/$id");
            return;
        }
    }

    unlink($target_dir . sendRequest("SELECT logo FROM projects WHERE project_id = ?;", [$id], PDO::FETCH_NUM)[0][0]);
    $rqt = "UPDATE projects SET logo = ? WHERE project_id = ?;";
    sendRequest($rqt, [$filename, $id], PDO::FETCH_NUM);
}

$rqt = "UPDATE projects SET name = ?, presentation_name = ?, presentation = ? WHERE project_id = ?;";
sendRequest($rqt, [$data["name"], $data["presentationName"], $data["presentation"], $id], PDO::FETCH_ASSOC);

// Types
$i = 1;
$rqt = "DELETE FROM project_types WHERE project_id = ?;";
sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
while(isset($data["type-$i"])){
    $rqt = "SELECT project_type_id FROM project_type WHERE name = ?;";
    $type_id = sendRequest($rqt, [$data["type-$i"]], PDO::FETCH_NUM)[0][0];
    $rqt = "INSERT INTO project_types VALUES (?, ?);";
    sendRequest($rqt, [$id, $type_id], PDO::FETCH_ASSOC);
    $i++;
}

$i = 1;
$rqt = "SELECT count(*) FROM projects_description WHERE project_id = ?;";
$descriptionCount = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
while(isset($data["description-$i"])){
    if($i <= $descriptionCount){
        $rqt = "UPDATE projects_description SET subTitle = ?, Description = ? WHERE `order` = ?;";
        sendRequest($rqt, [$data["subName-$i"], $data["description-$i"], $i], PDO::FETCH_NUM);
    }else{
        $rqt = "INSERT INTO projects_description VALUES (?, ?, ?, ?);";
        sendRequest($rqt, [$id, $data["subName-$i"], $data["description-$i"], $i], PDO::FETCH_NUM);
    }
    $i++;
}

// Delete every paragraphes that have been removed
if($i <= $descriptionCount){
    $rqt = "DELETE FROM projects_description WHERE project_id = ? AND `order` >= ?;";
    sendRequest($rqt, [$id, $i], PDO::FETCH_NUM);
}

header("Location:http://localhost/portfolio/admin/projects");