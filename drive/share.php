<?php

include '../config.php';

try
{
	$username = 'Guest';
	$userID = 0;
	$host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
	$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);
	if(isset($_COOKIE['session'])){
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
	if($rsFile['OwnerID'] == $userID)
	{
		$file = basename($rsFile['Path']);
		$file = '../../drive/'.$file;

if(!file_exists($file)){
    die('file not found');
} else {
	$stmt = $conn->prepare("UPDATE drive SET Shared = ? WHERE ID = ? AND Link = ?");
	
	if($rsFile['Shared'])
		$state = 0;
	else
		$state = 1;
	
	$stmt->bindValue(1, $state);
	$stmt->bindValue(2, $_GET['id']);
	$stmt->bindValue(3, $_GET['link']);
	$stmt->execute();
	header("Location: index.php");
}
	}else{
		http_response_code(404);
		die();
	}