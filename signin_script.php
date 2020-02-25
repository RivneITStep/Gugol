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
                <span class="display-1 d-block">Error</span>
                <div class="mb-4 lead">
<?php

define('Gugol', TRUE);

include 'config.php';
include 'engine/utils/RandomString.php';

if(isset($_POST['email']) && isset($_POST['password']))
{
try
{
	$host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
	$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);
	$stmt = $conn->prepare("SELECT Password_Hash FROM users WHERE Email = ?");
	$stmt->bindValue(1, $_POST['email']);
	$stmt->execute();
    $rows = $stmt->fetchAll();
       foreach ($rows as $rs)
		{
          $hash = $rs['Password_Hash'];
        }
		
		if(isset($hash))
		{
		
		if(password_verify($_POST['password'], $hash))
		{
			$randomString = generateRandomString();
			$stmt = $conn->prepare("UPDATE users SET Session = ? WHERE Email = ?");
			$stmt->bindValue(1, $randomString);
			$stmt->bindValue(2, $_POST['email']);
			$stmt->execute();
			setcookie("session", $randomString, time()+2*24*60*60);
			header("Location: index.php");
			die();
		}
		}
		echo 'Incorrect email or password';
		header('Refresh: 3; URL=signin.php');
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
}
?>
</div>
            </div>
        </div>
    </div>
</div>