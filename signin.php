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
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gugol | Signin</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../dist/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="/signin.php" method="post">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control"  name="password" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
  </body>
</html>
