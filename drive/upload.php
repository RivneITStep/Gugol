<?php

define('Gugol', TRUE);
include '../engine/utils/RandomString.php';

$target_dir = "../../drive/";
$target_file = $target_dir . basename($_FILES["filename"]["name"]);
$uploadOk = 1;
$newName = $target_file . generateRandomString(20) . '.att';

if ($_FILES["filename"]["size"] > 1024) {
    echo "Sorry, your file is too large. ";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Your file was not uploaded.";

} else {
    if (move_uploaded_file($_FILES["filename"]["tmp_name"], $newName)) {
        echo "The file ". basename( $_FILES["filename"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
header("Location: index.php");