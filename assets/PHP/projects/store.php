<?php

$data = $request->getBody();
if(isset($data["addNewType"])){
    if(isset($data["newType"])){
        $rqt = "INSERT INTO project_type VALUES (null, ?);";
        sendRequest($rqt, [$data["newType"]], PDO::FETCH_ASSOC);
    }
    header("Location:http://localhost/portfolio/admin/projects/create");
    return;
}

if(isset($data["delType"])){
    $rqt = "DELETE FROM project_type WHERE name = ?;";
    sendRequest($rqt, [$data["type"]], PDO::FETCH_ASSOC);
    header("Location:http://localhost/portfolio/admin/projects/create");
    return;
}

// Create the new project

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
    header("Refresh:3;url=http://localhost/portfolio/admin/projects/create");
    return;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
        $filename = basename( $_FILES["logo"]["name"]);
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
        header("Refresh:3;url=http://localhost/portfolio/admin/projects/create");
        return;
    }
}

$rqt = "INSERT INTO projects VALUES (null, ?, ?, 0, 0);";
sendRequest($rqt, [$data["name"], $filename], PDO::FETCH_ASSOC);

$rqt = "SELECT project_id FROM projects WHERE name = ?;";
$project_id = sendRequest($rqt, [$data["name"]], PDO::FETCH_NUM)[0][0];
$rqt = "SELECT project_type_id FROM project_type";
$type_id = sendRequest($rqt, [], PDO::FETCH_NUM)[0][0];

$rqt = "INSERT INTO project_types VALUES (?, ?);";
sendRequest($rqt, [$project_id, $type_id], PDO::FETCH_ASSOC);

$i = 1;
while(isset($data["description-$i"])){
    $rqt = "INSERT INTO projects_description VALUES (?, ?, ?, ?);";
    sendRequest($rqt, [$project_id, $data["subName-$i"], $data["description-$i"], $i], PDO::FETCH_NUM);
    $i++;
}

header("Location:http://localhost/portfolio/admin/projects");