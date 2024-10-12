<?php
// Connexion à la base de données
include '../dbconn.php';

// Récupérer l'ID du matériel à supprimer depuis l'URL
$id = $_GET['id'];

// Requête pour supprimer le matériel de la base de données
if (mysqli_query($conn, "DELETE FROM materiel WHERE id = $id")) {
    // Redirection vers la page de liste après suppression
    header('Location: liste_materiel.php');
    exit;
} else {
    // En cas d'erreur lors de la suppression
    echo 'Erreur lors de la suppression du matériel : ' . mysqli_error($conn);
}
?>
