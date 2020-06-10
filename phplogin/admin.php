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




/*$user_type = isset($_GET['user_type']);
$result = mysqli_query($con,"SELECT user_type FROM accounts WHERE '".$_SESSION['login_user']."'");
$result_value = mysqli_fetch_array($result);
echo $result_value['user_type'];
if($result_value['user_type']!="admin") {
  header("Location: home.php");
}*/
/*if ($stmt = $con->prepare('SELECT user_type FROM accounts WHERE user_type = ?')) {
$results = mysqli_query($db, $query);
$logged_in_user = mysqli_fetch_assoc($results);
if ($user_type == 'admin') {
    header ('Location: admin.php');
    }else {
         header('Location: home.php');
    }
  }*/

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Admnistration</title>
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
			<h2 style="margin-bottom:40px">Page d'accueil administrateur</h2>
    </div>
    
    <?php
 

    $bdd = new PDO('mysql:host=localhost;dbname=phplogin;charset=utf8','root','');

    $ArrayStatut = array(
      0 => "<span style='color:blue;font-weight:bold'>En attente</span>",
      1 => "<span style='color:orange;font-weight:bold'>En cours</span>",
      2 => "<span style='color:green;font-weight:bold'>Résolue</span>",
      );

  $reponse = $bdd->query("SELECT * FROM ticket ORDER BY id DESC");
  while($donnes = $reponse->fetch()) 
    {

    
    ?>
    
    <table>
  <tr style= "background-color: yellow">
    <td>Date</td>
    <td>Id du ticket</td>
    <td>Sujet</td>
    <td>Message</td>
    <td>Réponse</td>
    <td>Statut</td>
    <td>Editer</td>
  </tr>
  
  <tr>
    <td><?php echo $donnes['date'];?></td>
    <td><?php echo $donnes['id'];?></td>
    <td><?php echo $donnes['sujet'];?></td>
    <td><?php echo $donnes['message'];?></td>
    <td>A venir</td>
    <td><?php echo $ArrayStatut [$donnes['statut']];?></td>
    <td>
    <a href="ticket.php?id=<?php echo $donnes['id'];  ?>" class="buttonize"><i class="fa fa-pen" style="color: grey; margin-left: 10px;"></i></a>
      </td>
  </tr>
</table>
    
<?php

    }
    $reponse->closeCursor();
?>

	</body>
</html>


