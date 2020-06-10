<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);



if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ( !isset($_POST['nom'], $_POST['motdepasse']) ) {
	exit('Merci de remplir les deux champs afin de vous connecter.');
}
if ($stmt = $con->prepare('SELECT id, motdepasse, user_type FROM accounts WHERE nom = ?')) {
	$stmt->bind_param('s', $_POST['nom']);
	$stmt->execute();
	$stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $motdepasse, $user_type);
        $stmt->fetch();
        if (password_verify($_POST['motdepasse'], $motdepasse)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['nom'];
            $_SESSION['id'] = $id;
            $_SESSION['user_type'] = $user_type;
            $results = mysqli_query($db, $query);
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($user_type == 'admin') {
                header ('Location: admin.php');
                }else {
                     header('Location: home.php');
                }
        } else {
            echo 'Mot de passe incorrect';
        }
    } else {
        echo 'Identifiant incorrect';
    }
	$stmt->close();
}
?>