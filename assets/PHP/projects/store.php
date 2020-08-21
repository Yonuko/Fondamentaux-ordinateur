<?php

needAdmin();

$data = $request->getBody();
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
    header("Location:https://sacha-eghiazarian.fr/admin/projects/create");
    return;
}

if(isset($data["delType"])){
    $rqt = "DELETE FROM project_type WHERE name = ?;";
    sendRequest($rqt, [$data["type"]], PDO::FETCH_ASSOC);
    header("Location:https://sacha-eghiazarian.fr/admin/projects/create");
    return;
}

// Create the new project

// if no type is set, we return to the beginning page
if(!isset($data["type-1"])){
    header("Location:https://sacha-eghiazarian.fr/admin/projects/create");
    return; 
}

$filename = "";

$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/image/Uploads/Projets/";
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
    header("Refresh:3;url=https://sacha-eghiazarian.fr/admin/projects/create");
    return;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
        $filename = basename( $_FILES["logo"]["name"]);
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
        header("Refresh:3;url=https://sacha-eghiazarian.fr/admin/projects/create");
        return;
    }
}

$rqt = "INSERT INTO projects VALUES (null, ?, ?, ?, ?, 0, 0, 0);";
sendRequest($rqt, [$data["name"], $data["presentationName"], $data["presentation"], $filename], PDO::FETCH_ASSOC);

$i = 1;
$rqt = "SELECT project_id FROM projects WHERE name = ?;";
$project_id = sendRequest($rqt, [$data["name"]], PDO::FETCH_NUM)[0][0];
while(isset($data["type-$i"])){
    $rqt = "SELECT project_type_id FROM project_type WHERE name = ?;";
    $type_id = sendRequest($rqt, [$data["type-$i"]], PDO::FETCH_NUM)[0][0];
    
    $rqt = "INSERT INTO project_types VALUES (?, ?);";
    sendRequest($rqt, [$project_id, $type_id], PDO::FETCH_ASSOC);
    $i++;
}

$i = 1;
while(isset($data["description-$i"])){
    $rqt = "INSERT INTO projects_description VALUES (?, ?, ?, ?);";
    sendRequest($rqt, [$project_id, $data["subName-$i"], $data["description-$i"], $i], PDO::FETCH_NUM);
    $i++;
}

header("Location:https://sacha-eghiazarian.fr/admin/projects");