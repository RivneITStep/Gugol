<?php

define('Gugol', TRUE);

include 'config.php';
include 'engine/utils/RandomString.php';

if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['username']) && $_POST['password'] === $_POST['password_confirm'])
{
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
}
?>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<form class="form-horizontal" action='' method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Register</legend>
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="username">Username</label>
      <div class="controls">
        <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
        <p class="help-block">Username can contain any letters or numbers, without spaces</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="email">E-mail</label>
      <div class="controls">
        <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
        <p class="help-block">Please provide your E-mail</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
        <p class="help-block">Password should be at least 4 characters</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Password (Confirm)</label>
      <div class="controls">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
        <p class="help-block">Please confirm password</p>
      </div>
    </div>
 
    <div class="control-group">
      <div class="controls">
        <button class="btn btn-success">Register</button>
      </div>
    </div>
  </fieldset>
</form>