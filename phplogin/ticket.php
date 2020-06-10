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

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

$ArrayStatut = array(
	0 => "<span style='color:blue;font-weight:bold'>En attente</span>",
	1 => "<span style='color:orange;font-weight:bold'>En cours</span>",
	2 => "<span style='color:green;font-weight:bold'>Résolue</span>",
	);

$id = $_GET['id'];

$bdd = new PDO('mysql:host=localhost;dbname=phplogin;charset=utf8','root','');
$reponse = $bdd->query("SELECT * FROM ticket WHERE id = " .$id);

while($donnes = $reponse->fetch()) 
    {
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ticket numéro <?php echo $donnes['id'];?></title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  table-layout: fixed;
  width: 100%;
  margin-left: 0,5px;
  margin-top: 10px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  width: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>
    <body class="loggedin">
		<nav class="navtop">
			<div>
                <h1>Titre</h1>
                <a href="profil.php"><i class="fas fa-user-circle"></i><?=$_SESSION['name']?></a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Se déconnecter</a>
			</div>
		</nav>
		<div class="content">
			
			<h2 style="margin-bottom:40px">Ticket numéro <?php echo $donnes['id'];?></h2>
	</div>
	
    <table>
  <tr style= "background-color: yellow">
    <td>Date</td>
    <td>Sujet</td>
    <td>Message</td>
    <td>Réponse</td>
    <td>Statut</td>
  </tr>
  <tr style="height: 100px">
    <td><?php echo $donnes['date'];?></td>
    <td><?php echo $donnes['sujet'];?></td>
    <td><?php echo $donnes['message'];?></td>
    <td>A venir</td>
    <td><select name="statut">
		<option value="0">En attente</option>
		<?php 
		if($donnes["statut"] == '0'){
			echo "selected";
		}
		?>
		<option value="1">En cours</option>
		<?php 
		if($donnes["statut"] == '1'){
			echo "selected";
		}
		?>
		<option value="2">Résolu</option>
		<?php 
		if($donnes["statut"] == '2'){
			echo "selected";
		}
		?>
	</select></td>
  </tr>
</table>

<div>
		<input name="envoyer" type="submit" value="Valider" style="margin-left: 1250px; margin-top: 15px;">
	</div>
	<?php

if(isset($_POST["envoyer"]))
{
	$statut=$_POST["statut"];
	mysqli_query($con,"UPDATE ticket SET statut= '$statut' WHERE id = " .$id);
	header('Location: admin.php');
} else {
	echo "<p>Une erreur s'est produite, merci de réessayer.</p>";
}
?>

	<?php
	}
$req = mysqli_query($mysqli,"SELECT * FROM ticket WHERE ");

$reponse->closeCursor();
	?>
    </body>
</html>