<?php
session_start();
include("../dbconn.php"); // Vérifiez le chemin de ce fichier si nécessaire

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenez les données du formulaire
    $request_id = $_POST['request_id'];
    $message = $_POST['message'];

    // Insérez la réponse dans la table des réponses
    $stmt = mysqli_prepare($conn, "INSERT INTO responses (request_id, response) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "is", $request_id, $message);
    mysqli_stmt_execute($stmt);

    // Mettez à jour la demande pour indiquer qu'elle a été répondue
    $update_stmt = mysqli_prepare($conn, "UPDATE requests SET is_responded = 1 WHERE id = ?");
    mysqli_stmt_bind_param($update_stmt, "i", $request_id);
    mysqli_stmt_execute($update_stmt);

    // Redirigez vers la même page pour rester sur la page de contact
    header("Location: contacter.php");
    exit();
}
?>
