<?php

needAdmin();

$data = $request->getBody();

$id = $data["id"];

if(isset($data["addNewType"])){
    if(isset($data["newType"])){
        $rqt = "INSERT INTO categorie VALUES (null, ?);";
        sendRequest($rqt, [$data["newType"]], PDO::FETCH_ASSOC);
    }
    header("Location:https://sacha-eghiazarian.fr/admin/blog/$id");
    return;
}

if(isset($data["delType"])){
    $rqt = "DELETE FROM categorie WHERE name = ?;";
    sendRequest($rqt, [$data["type"]], PDO::FETCH_ASSOC);
    header("Location:https://sacha-eghiazarian.fr/admin/blog/$id");
    return;
}

// Copy everytag of the selected post
if(isset($data["copyTag"])){
    $rqt = "DELETE FROM post_keywords WHERE post_id = ?;";
    sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
    $rqt = "SELECT * FROM post_keywords WHERE post_id = ?;";
    $originalPost = sendRequest($rqt, [$data["tagcopy"]], PDO::FETCH_ASSOC);
    foreach($originalPost as $keyword){
        extract($keyword);
        $rqt = "INSERT INTO post_keywords VALUES (?, ?);";
        sendRequest($rqt, [$id, $keyword_id], PDO::FETCH_ASSOC);
    }
    header("Location:https://sacha-eghiazarian.fr/admin/blog/$id");
    return;
}

// Create the new post

if(isset($_FILES["logo"]["name"]) && $_FILES["logo"]["size"] !== 0){
    $filename = "";

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/image/Uploads/Blog/";
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
        header("Refresh:3;url=https://sacha-eghiazarian.fr/admin/blog/$id");
        return;
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
            $filename = basename( $_FILES["logo"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
            header("Refresh:3;url=https://sacha-eghiazarian.fr/admin/blog/$id");
            return;
        }
    }

    unlink($target_dir . sendRequest("SELECT logo FROM posts WHERE post_id = ?;", [$id], PDO::FETCH_NUM)[0][0]);
    $rqt = "UPDATE posts SET logo = ? WHERE post_id = ?;";
    sendRequest($rqt, [$filename, $id], PDO::FETCH_NUM);
}

$cat_id = sendRequest("SELECT category_id FROM categorie WHERE name = ?;", [$data["type"]], PDO::FETCH_NUM)[0][0];
$rqt = "UPDATE posts SET name = ?, category_id = ? WHERE post_id = ?;";
sendRequest($rqt, [$data["name"], $cat_id, $id], PDO::FETCH_ASSOC);


$i = 1;
$rqt = "DELETE FROM post_keywords WHERE post_id = ?;";
sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
while(isset($data["type-$i"])){   
    $rqt = "INSERT INTO keywords VALUES (null, ?);";
    sendRequest($rqt, [$data["type-$i"]], PDO::FETCH_ASSOC);
    $rqt = "SELECT key_id FROM keywords WHERE word = ?;";
    $keyword_id = sendRequest($rqt, [$data["type-$i"]], PDO::FETCH_NUM)[0][0];

    $rqt = "INSERT INTO post_keywords VALUES (?, ?);";
    sendRequest($rqt, [$id, $keyword_id], PDO::FETCH_ASSOC);
    $i++;
}


$i = 1;
$rqt = "SELECT count(*) FROM post_descriptions WHERE post_id = ?;";
$descriptionCount = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
while(isset($data["description-$i"])){
    if($i <= $descriptionCount){
        $rqt = "UPDATE post_descriptions SET subTitle = ?, content = ? WHERE post_id = ? AND `order` = ?;";
        sendRequest($rqt, [$data["subName-$i"], $data["description-$i"], $id, $i], PDO::FETCH_NUM);
    }else{
        $rqt = "INSERT INTO post_descriptions VALUES (?, ?, ?, ?);";
        sendRequest($rqt, [$id, $data["subName-$i"], $data["description-$i"], $i], PDO::FETCH_NUM);
    }
    $i++;
}

// Delete every paragraphes that have been removed
if($i <= $descriptionCount){
    $rqt = "DELETE FROM post_descriptions WHERE post_id = ? AND `order` >= ?;";
    sendRequest($rqt, [$id, $i], PDO::FETCH_NUM);
}

header("Location:https://sacha-eghiazarian.fr/admin/blog");