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

$task="list";
	if(array_key_exists("task", $_GET)){$task=$_GET['task'];}
	if($task=='write'){postMessage();}
	else {getMessage();}

	function getMessage(){
		global $db;
		$sql="SELECT * FROM chat ORDER BY id DESC LIMIT 50";
		$req=$db->query($sql);
		$message=$req->fetchAll();
		echo json_encode($message);
	}

	function postMessage(){
		global $db;
		$pseudo = $_POST['pseudo'];
		$message=$_POST['message'];

		$sql="INSERT INTO chat(pseudo,message) VALUES ('$pseudo','$message')";
		$req=$db->prepare($sql);
		$req->execute();
		echo json_encode(["status"=>"succes"]);
	}

?>