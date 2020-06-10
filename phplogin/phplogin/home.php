<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$mysqli=mysqli_connect('localhost','root','','phplogin');
if(!$mysqli) {
	echo "Erreur connexion BDD";
	exit;
}

$User_name= htmlspecialchars($_SESSION['name']);
$UrlPage= htmlspecialchars("home.php");
$NomSession= htmlspecialchars("name");
$User_name= htmlspecialchars($_SESSION[$NomSession]);
if (isset($_SESSION['user_name'])) { $user_name = $_SESSION['user_name']; }


function htmlent($texte){
    return htmlentities($texte,ENT_QUOTES,"UTF-8");
}



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ticket</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">


		<nav class="navtop">
			<div>
                <h1>Titre</h1>
                <a href="profil.php"><i class="fas fa-user-circle"></i><?=$_SESSION['name']?></a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Se déconnecter</a>
			</div>
		</nav>

		<div class="content">
			<h2>Page d'accueil</h2>
		</div>
		<form action="<?php echo htmlspecialchars($UrlPage); ?>?action=envoie" method="post">
		<div>
			<label for="title" style="margin-left: 167px; margin-top: 100px"> Sujet :</label><br>
		<input type="text" name="sujet" class="text-line" style="margin-left: 167px; margin-bottom: 20px"value="<?php echo htmlspecialchars(isset($_POST['sujet'])) ? htmlent($_POST['sujet']) : ""; ?>" required/>
		</div>
	<div>
		<label for="title"style="margin-left: 167px;"> Message :</label><br>
		<textarea placeholder="Votre message..." class="textbox" name="message" id="message" cols="145" rows="15" style="margin-left: 167px" required><?php echo htmlspecialchars(isset($_POST['message'])) ? htmlent($_POST['message']) : ""; ?></textarea>
	</div> 
	<div>
		<input name="envoie" type="submit" value="Envoyer" style="margin-left: 1105px;">
	</div>
	<?php

	if(isset($_POST['envoie'])){
	if(empty($_POST['sujet']) && empty($_POST['message'])) {
	} else {
		$Sujet = trim(htmlent($_POST['sujet']));
		$Message = htmlent($_POST['message']);
		if(mysqli_query($mysqli,
		"INSERT INTO ticket SET
		sujet = '".$Sujet."',
		message = '".$Message."',
		statut= 0")){
			echo "<p>Ticket envoyé avec succès!</p>";
		} else {
			echo "<p>Une erreur s'est produite, merci de réessayer.</p>";
		}
	}
	}

	?>
	<?php if(isset($error)) {echo $error;} ?>
	</form>
	</body>
</html>