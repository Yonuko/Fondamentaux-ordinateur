<?php

needAdmin();

$data = $request->getBody();
if(isset($data["addNewType"])){
    if(isset($data["newType"])){
        $rqt = "INSERT INTO categorie VALUES (null, ?);";
        sendRequest($rqt, [$data["newType"]], PDO::FETCH_ASSOC);
    }
    header("Location:http://localhost/portfolio/admin/blog/create");
    return;
}

if(isset($data["delType"])){
    $rqt = "DELETE FROM categorie WHERE name = ?;";
    sendRequest($rqt, [$data["type"]], PDO::FETCH_ASSOC);
    header("Location:http://localhost/portfolio/admin/blog/create");
    return;
}

// Create the new post

$filename = "";

$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/image/Uploads/Blog/";
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
    header("Refresh:3;url=http://localhost/portfolio/admin/blog/create");
    return;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
        $filename = basename( $_FILES["logo"]["name"]);
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
        header("Refresh:3;url=http://localhost/portfolio/admin/blog/create");
        return;
    }
}

$categorie_id = sendRequest("SELECT category_id FROM categorie WHERE name = ?;", [$data['type']], PDO::FETCH_NUM)[0][0];

$rqt = "INSERT INTO posts VALUES (null, ?, ?, ?, 0, ?, null, 0, ?);";
sendRequest($rqt, [
    $categorie_id,
    $data["name"], 
    $filename, 
    date("Y-m-d H:i:s"), 
    $_SESSION["id"],
], PDO::FETCH_ASSOC);

$rqt = "SELECT post_id FROM posts ORDER BY post_id DESC LIMIT 1;";
$post_id = sendRequest($rqt, [], PDO::FETCH_NUM)[0][0];


$i = 1;
while(isset($data["type-$i"])){   
    $rqt = "INSERT INTO keywords VALUES (null, ?);";
    sendRequest($rqt, [$data["type-$i"]], PDO::FETCH_ASSOC);
    $rqt = "SELECT key_id FROM keywords WHERE word = ?;";
    $keyword_id = sendRequest($rqt, [$data["type-$i"]], PDO::FETCH_NUM)[0][0];

    $rqt = "INSERT INTO post_keywords VALUES (?, ?);";
    sendRequest($rqt, [$post_id, $keyword_id], PDO::FETCH_ASSOC);
    $i++;
}

$i = 1;
while(isset($data["description-$i"])){
    $rqt = "INSERT INTO post_descriptions VALUES (?, ?, ?, ?);";
    sendRequest($rqt, [$post_id, $data["subName-$i"], $data["description-$i"], $i], PDO::FETCH_NUM);
    $i++;
}

header("Location:http://localhost/portfolio/admin/blog");