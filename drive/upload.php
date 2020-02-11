<?php

define('Gugol', TRUE);
include '../engine/utils/RandomString.php';
include '../config.php';

try
{
	$username = 'Guest';
	$userID = '0';
    if(isset($_COOKIE['session'])){
	$host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
	$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);
	$stmt = $conn->prepare("SELECT ID, Username FROM users WHERE Session = ?");
	$stmt->bindValue(1, $_COOKIE['session']);
	$stmt->execute();
    $rows = $stmt->fetchAll();
       foreach ($rows as $rs)
		{
          $username = $rs['Username'];
		  $userID = $rs['ID'];
        }
	}
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}

if($username == 'Guest')
{
	header("Location: index.php");
	return;
}

$target_dir = "../../drive/";
$uploadOk = 1;
$pathFile = generateRandomString(20) . '.att';
$newName = $target_dir . $pathFile;
$nameFile = basename($_FILES["filename"]["name"]);
$size = $_FILES["filename"]["size"];

if ($size > 1024) {
    echo "Sorry, your file is too large. ";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Your file was not uploaded.";

} else {
    if (move_uploaded_file($_FILES["filename"]["tmp_name"], $newName)) {
        $stmt = $conn->prepare("INSERT INTO drive (Link, OwnerID, Name, Path, Shared, Size, Date) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindValue(1, generateRandomString(24));
		$stmt->bindValue(2, $userID);
		$stmt->bindValue(3, $nameFile);
		$stmt->bindValue(4, $pathFile);
		$stmt->bindValue(5, 0);
		$stmt->bindValue(6, $size);
		$stmt->bindValue(7, time());
		$stmt->execute();
		echo "The file has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
header("Location: index.php");