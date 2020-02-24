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

include 'config.php';
include 'engine/utils/RandomString.php';

if(!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
{
	if(strlen($_POST['password']) > 6 && strlen($_POST['password']) < 37 && strlen($_POST['password_confirm']) > 6 && strlen($_POST['password_confirm']) < 37){
		if($_POST['password'] === $_POST['password_confirm']){
				if(strlen($_POST['username']) > 3 && strlen($_POST['username']) < 20){
					if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['username'])){
try
{
	$host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
	$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);
	$stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? OR Email = ?");
	$stmt->bindValue(1, $_POST['username']);
	$stmt->bindValue(2, $_POST['email']);
	$stmt->execute();
    $rows = $stmt->fetchAll();
	if(sizeof($rows) == 0){
			$randomString = generateRandomString();
			$stmt = $conn->prepare("INSERT INTO users (ID, Username, Password_Hash, Email, Session) VALUES (NULL, ?, ?, ?, ?)");
			$stmt->bindValue(1, $_POST['username']);
			$stmt->bindValue(2, password_hash($_POST['password'], PASSWORD_DEFAULT));
			$stmt->bindValue(3, $_POST['email']);
			$stmt->bindValue(4, $randomString);
			$stmt->execute();
			setcookie("session", $randomString, time()+2*24*60*60);
			header("Location: index.php");
			die();
	}
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
}else{
	echo 'Username must be without special symbols';
}
}else{
	echo 'Username must be longer than 3 symbols and shorter than 20 symbols';
}
}else{
	echo 'Invalid password confirm';
}
}else{
	echo 'Password must be longer than 6 symbols and shorter than 37 symbols';
}
}else{
	echo 'Incorrect email';
}
header('Refresh: 3; URL=signup.php');
?>
</div>
            </div>
        </div>
    </div>
</div>