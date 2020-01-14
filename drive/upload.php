<?php

define('Gugol', TRUE);
include '../engine/utils/RandomString.php';

$target_dir = "../../drive/";
$target_file = $target_dir . basename($_FILES["fileid"]["name"]);
$uploadOk = 1;
$newName = $target_file . generateRandomString(20);

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileid"]["size"] > 1024) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileid"]["tmp_name"], $newName)) {
        echo "The file ". basename( $_FILES["fileid"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}