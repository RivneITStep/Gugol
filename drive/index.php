<?php

define('Gugol', TRUE);
include '../engine/utils/SizeFormater.php';
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
if($username !== 'Guest'){
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Gugol</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/pricing/">

    <!-- Bootstrap core CSS -->
<link href="/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="/dist/css/pricing.css" rel="stylesheet">
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal">Gugol</h5>
<html>
    <head> 
        <script>
            function setup() {
                document.getElementById('buttonid').addEventListener('click', openDialog);
                function openDialog() {
                    document.getElementById('fileid').click();
                }
                document.getElementById('fileid').addEventListener('change', submitForm);
                function submitForm() {
                    document.getElementById('formid').submit();
                }
            }
        </script> 
    </head>
    <body onload="setup()">
        <form id='formid' action="upload.php" method="POST" enctype="multipart/form-data"> 
            <input id='fileid' type='file' name='filename' hidden/>
            <input class="btn btn-primary" id='buttonid' type='button' value='Upload File' />
        </form> 
    </body> 
</html>
  <nav class="my-2 my-md-0 mr-md-3">
  <a class="p-2 text-dark">Hi, <?php echo $username; ?></a>
  <?php if($username == 'Guest')
		echo '<a class="p-2 text-dark" href="../signin.php">Sign In</a><a class="btn btn-outline-primary" href="../signup.php">Sign up</a>';
   else
	    echo '<a class="p-2 text-dark" href="../logout.php">Logout</a>';
   ?>
</div>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">Size</th>
	  <th scope="col">Download</th>
	  <th scope="col">Remove</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $stmt = $conn->prepare("SELECT * FROM drive WHERE OwnerID = ?");
	$stmt->bindValue(1, $userID);
	$stmt->execute();
    $rows = $stmt->fetchAll();
       foreach ($rows as $rs)
		{
    echo '<tr>';
    echo '<td>'.date('Y-m-d H:i:s', $rs['Date']).'</td>';
    echo '<td>'.$rs['Name'].'</td>';
    echo '<td>'.formatSize($rs['Size']).'</td>';
	echo '<td><a href="/drive/dl.php?id='.$rs['ID'].'&link='.$rs['Link'].'">Download</a></td>';
	echo '<td><a href="/drive/remove.php?id='.$rs['ID'].'&link='.$rs['Link'].'">Remove</a></td>';
	echo '</tr>';
		}
	?>
  </tbody>
</table>
</body>
</html>
<?php
	   }else{
		    echo 'You must be logged!';
	   }

