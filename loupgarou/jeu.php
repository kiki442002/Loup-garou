<?php
	$dsn = 'mysql:dbname=loupgarou;host=localhost';
	$dbuser = 'root';
	$dbpass = '';

	$gameid = 1;
	$gameaccount=1;
	$roles;
	try {
		$db = new PDO($dsn, $dbuser, $dbpass);
	} 
	catch (PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMessage();
	}
		
	$sql = "SELECT * FROM game_players WHERE game_id = '$gameid' AND account_id = '$gameaccount'";
	$requser = $db->prepare($sql);
	$requser->execute();
		
		
	$sql = "SELECT `roles` FROM `game_players`";
	$requser = $db->prepare($sql);
	$requser->execute();
	$data = $requser->fetch();
	$data =  $data['roles'];
	$roles='';
	if ($data == 1)$roles='Villageoi';
	if ($data == 2)$roles='Loup-garou';
	if ($data == 3)$roles='Voyante';
	if ($data == 4)$roles='Sorcière';
	if ($data == 5)$roles='Chasseur';

	
		
	?>

<html>
	<head>
	  <meta charset="utf-8" />
	  <link	rel="stylesheet" href="presentation.css"/>
	  <title>Loup Garou Online </title> 
	</head>

	<body>
	<input id='test' type="button" value="nuit"/>
		<h1 class="title"> Jeu du Loup-Garou</h1>
		<div id="fond">
			<div id="roles" >
				<h3 id="roles2"> <?php echo $roles?> </h3>
				<img id = "<?php echo $roles?>" src="images/<?php echo $roles?>.png" class="img" title="Vous êtes: <?php echo $roles?>"/>
			</div>
			<h2 id="times">Le village se réveille</h2>
			<section class=" chat">
				<div class="messages">
					
				</div>
				<form action="chat.php?task=write" method="post">
					<input type="text" placeholder="PSEUDO" name="pseudo" id="pseudo"/> 
					<input type="text" placeholder="MESSAGE" name="message" id="message"/>
					<input type="submit" value="Envoyer" name="envoyer"/> </br>
					<span id="error">Vous n'avez pas remplie tous les champs!</span>
				</form>
				
			</section>
		</div>
	</body>

</html>
	
<script>
	//65% de villageois, 20% de loupgarou, 5% de voyante sorcière et chasseur.
	var roles = <?php echo $data ?>;
	var btn = document.getElementById("test");
	var src = document.getElementById("fond");
	var txt = document.getElementById("times");
	var htmlold;
	
	if(roles == 2){
		document.getElementById("roles").style.border="2px solid red";
	}
	

	function delay(name, time) {setTimeout(name, time);}

	btn.addEventListener('click', fond);
	function fond(){
		if(btn.value==="nuit"){
			src.style = "background: url(images/nuit.jpg) center no-repeat;background-size: 100%;";
			txt.textContent="Le village s'endort"
			btn.value="jour";
		}
		else{
			src.style="background: url(images/jour.jpg) center no-repeat;background-size: 100%;";
			txt.textContent="Le village se réveille"
			btn.value="nuit";
		}
	}

	getMessages();
	const interval= window.setInterval(getMessages,1000);
	function getMessages(){
	  const requeteAjax = new XMLHttpRequest();
	  requeteAjax.open("GET", "chat.php");

	  requeteAjax.onload = function(){
			const resultat = JSON.parse(requeteAjax.responseText);
			const html = resultat.reverse().map(function(message){
			  return `
				<div class="message">
				  <span class="author">${message.pseudo}</span> : 
				  <span class="content">${message.message}</span>
				</div>
			  `
			}).join('');

			const messages = document.querySelector('.messages');

			if(htmlold != html){
				messages.innerHTML = html;
				messages.scrollTop = messages.scrollHeight;
				htmlold = html;
			}
			
	  }	

	  requeteAjax.send();
	}

	document.querySelector('form').addEventListener('submit',postMessage);
	function postMessage(event){
		event.preventDefault();

		const pseudo = document.getElementById('pseudo');
		const message = document.getElementById('message');

		const data = new FormData();
		data.append('pseudo', pseudo.value);
		data.append('message', message.value);
		if(message.value!='' && pseudo.value!=''){
			const reqAjax = new XMLHttpRequest();
			reqAjax.open('POST', 'chat.php?task=write');

			reqAjax.onload=function(){
				getMessages();
				document.getElementById('error').style.display="none";
				message.value='';
				message.focus();
			}
		
			reqAjax.send(data);
		}
		else{
			document.getElementById('error').style.display="block";
		}
	}
	
	function vote(){
	
	}

	function jeu(){}
</script>

