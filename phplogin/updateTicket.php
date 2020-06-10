<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

if($_SESSION['user_type'] !== 'admin'){
    header('Location: home.php');
    exit;
}

$bdd = new PDO('mysql:host=localhost;dbname=phplogin;charset=utf8','root','');


$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_POST['id_ticket']) && isset($_POST['statut']) && !empty($_POST['id_ticket']) && !empty($_POST['statut'])){


    $statut = htmlspecialchars($_POST['statut']);
    $id = intval($_POST['id_ticket']);
    

    $sql = 'UPDATE ticket SET ticket.statut = :statut WHERE ticket.id = :id';
    $requete = $bdd->prepare($sql);
    $execute = $requete->execute([':statut' => $statut, ':id' => $id]);

    if($execute){
        echo "Ticket modifié";
        header('Location:admin.php');
    } else {
        echo "Erreur";
    }

} else {
    echo "Des informations sont manquantes";
}