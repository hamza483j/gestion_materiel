<?php
session_start();
if (!isset($_SESSION['admin'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas un admin
    header("Location: ../login.php");
    exit();
}

// Inclusion de la barre de navigation
include("navbare.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Materiel Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue à l'Accueil Admin</h1>
        <p>Voici les dernières notifications et actions rapides.</p>
        <!-- Contenu pour afficher les notifications ou les actions -->
    </div>
</body>
</html>
