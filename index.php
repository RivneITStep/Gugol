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
       foreach ($rows as $rs)
		{
          $username = $rs['Username'];
        }
	}
}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>UltraCloud</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/pricing/">

    <!-- Bootstrap core CSS -->
<link href="/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
  <h5 class="my-0 mr-md-auto font-weight-normal">UltraCloud</h5>
  <nav class="my-2 my-md-0 mr-md-3">
  <a class="p-2 text-dark">Hi, <?php echo $username; ?></a>
  <?php if($username == 'Guest')
		echo '<a class="p-2 text-dark" href="/signin.php">Sign In</a><a class="btn btn-outline-primary" href="/signup.php">Sign up</a>';
   else
   {
	   echo '<a class="p-2 text-dark" href="/drive">Drive</a>';
	   echo '<a class="p-2 text-dark" href="/logout.php">Logout</a>';
   }
   ?>
</div>
<center>
<input class="form-control-lg" type="text" id="searchItem" placeholder="Search">
<button class="btn btn-primary" onclick="search()">Search</button>
<p id='alert'></p>
</center>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">URL</th>
      <th scope="col">Title</th>
      <th scope="col">Content</th>
    </tr>
  </thead>
  <tbody id="tbodyItem">
  
  </tbody>
</table>
<script>
function search() {
  var item = document.getElementById('searchItem').value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		try{
		var jsonParsed = JSON.parse(this.responseText);
		document.getElementById('tbodyItem').innerHTML = '';
		for(var i1 = 0; i1 < jsonParsed.length; i1++)
			document.getElementById('tbodyItem').innerHTML += '<tr><td>' + (i1 + 1) + '</td><td><a href="' + jsonParsed[i1][0] + '">' + jsonParsed[i1][0] + '</a></td><td>'  + jsonParsed[i1][1] + '</td><td>' + jsonParsed[i1][2].substr(jsonParsed[i1][2].toLowerCase().indexOf(item.toLowerCase()) - 40, 70) + '</td></tr>';
		}catch(exc)
		{
			document.getElementById('alert').innerHTML = this.responseText;
		}
	}
  }
  xhttp.open("POST", "search.php", true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send("item=" + item);
  
}
</script>
</body>
</html>