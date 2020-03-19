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

	 $roles =  rand(1,5);
	 
	 
	 if($req->rowCount()==0){

		 $sql = "INSERT INTO `game_games`(`slots`, `roles`) VALUES ('1','$roles')";
		 $req = $db->prepare($sql);
		 $req->execute();
		 echo "attendez";
		}

	 else{
	 
	 } 
	?>