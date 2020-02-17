<?php

include 'config.php';

try
{
	$username = 'Guest';
	$host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
	$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);
	if(isset($_COOKIE['session'])){
	$stmt = $conn->prepare("SELECT Username FROM users WHERE Session = ?");
	$stmt->bindValue(1, $_COOKIE['session']);
	$stmt->execute();
    $rows = $stmt->fetchAll();
       if(sizeof($rows) > 0)
	   {
		   if(isset($_POST['item']))
		   {
			    $stmt = $conn->prepare("SET NAMES utf8mb4");
				$stmt->execute();
			    $stmt = $conn->prepare("SELECT Link, Title, Data FROM datacrawler WHERE MATCH(Data) AGAINST(? IN NATURAL LANGUAGE MODE)");
				$stmt->bindValue(1, $_POST['item']);
				$stmt->execute();
				$rowsArr = $stmt->fetchAll();
			    print json_encode($rowsArr);
		   }else{
			   echo 'Incorrect search!';
		   }
	   }else{
		    echo 'You must be logged!';
	   }
	}else{
		    echo 'You must be logged!';
	   }
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}