<?php

include '../config.php';

try
{
	$username = 'Guest';
	$userID = 0;
    if(isset($_COOKIE['session'])){
	$host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
	$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);
	$stmt = $conn->prepare("SELECT ID, Username FROM users WHERE Session = ?");
	$stmt->bindValue(1, $_COOKIE['session']);
	$stmt->execute();
    $rs = $stmt->fetch();
	$userID = $rs['ID'];
	$username = $rs['Username'];
	}
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
	$stmt = $conn->prepare("SELECT * FROM drive WHERE ID = ? AND Link = ?");
	$stmt->bindValue(1, $_GET['id']);
	$stmt->bindValue(2, $_GET['link']);
	$stmt->execute();
    $rsFile = $stmt->fetch();
	if($rsFile['Shared'] == 1 || $rsFile['OwnerID'] == $userID)
	{
		$file = basename($rsFile['Path']);
		$file = '../../drive/'.$file;

if(!file_exists($file)){
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=".$rsFile['Name']);
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    readfile($file);
}
	}else{
		http_response_code(404);
		die();
	}