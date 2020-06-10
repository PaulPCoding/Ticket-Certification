<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

if(isset($_POST["envoyer"]))
{
	$statut=htmlspecialchars($_POST["statut"]);
	mysqli_query($con,"UPDATE ticket SET statut= '$statut' WHERE id = " .$id);
	header('Location: admin.php');
} else {
	echo "<p>Une erreur s'est produite, merci de réessayer.</p>";
}

?>
</body>
</html>