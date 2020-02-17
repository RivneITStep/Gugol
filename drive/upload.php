<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
body {
    background: #dedede;
}
.page-wrap {
    min-height: 100vh;
}
</style>
<div class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block">INFO</span>
                <div class="mb-4 lead">
<?php

define('Gugol', TRUE);
include '../engine/utils/RandomString.php';
include '../config.php';

try
{
	$username = 'Guest';
	$userID = '0';
	$host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
	$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);
	if(isset($_COOKIE['session'])){
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

if ($size > $config['MAX_SIZE_PER_FILE']) {
    echo "Sorry, your file is too large. ";
    $uploadOk = 0;
}
$diskSize = 0;
$stmt = $conn->prepare("SELECT Size FROM drive WHERE OwnerID = ?");
$stmt->bindValue(1, $userID);
$stmt->execute();
$rows = $stmt->fetchAll();
       foreach ($rows as $rs)
		{
          $diskSize += $rs['Size'];
        }
if (($diskSize + $size) > $config['MAX_DISK_SPACE_PER_ACCOUNT']) {
    echo "Sorry, your disk is full. ";
    $uploadOk = 0;
}
if ($size == 0) {
    echo "Sorry, your file is empty. ";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Your file was not uploaded. Wait 3 seconds for redirect...";

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
header('Refresh: 3; URL=index.php');
?>
</div>
            </div>
        </div>
    </div>
</div>