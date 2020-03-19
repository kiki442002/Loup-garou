<?php
	$dsn = 'mysql:dbname=loupgarou;host=localhost';
	$dbuser = 'root';
	$dbpass = '';

	try {
		$db = new PDO($dsn, $dbuser, $dbpass);
	} 
	catch (PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMessage();
	}
	 $sql = "SELECT * FROM game_games";
	 $req = $db->prepare($sql);
	 $req->execute();

	 if(isset($_GET['id']) AND $_GET['id']>0 ){

		 $getid = intval($_GET['id']);
		 $sql = "SELECT * FROM web_accounts WHERE id = $getid";
		 $req = $db->prepare($sql);
		 $req->execute();
		 $userinfo = $req->fetch();
		 }
	 else{
		header('login.php');
	}
	?>
<html>

	<head>
	  <meta charset="utf-8" />
	  <link	rel="stylesheet" href="presentation.css"/>
	  <title>Loup Garou Online </title> 
	</head>
	<body style= "text-align:center">
		<h1>Profil de : <?php echo $userinfo['name']?><h1></br></br>
		<div>
			mail: <?php echo $userinfo['email']?> </br>
		</div>
	</body>
</html>
