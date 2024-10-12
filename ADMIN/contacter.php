<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../signin.php");
    exit();
}
include("../dbconn.php");  // Vérifiez le chemin de ce fichier si nécessaire
include('navbare.php'); 

// Gestion de la soumission du formulaire pour répondre à une demande
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $admin_message = $_POST['message'];

    // Insérer la réponse dans la base de données
    $stmt = mysqli_prepare($conn, "INSERT INTO responses (request_id, admin_message) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "is", $request_id, $admin_message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Mettre à jour la demande pour indiquer qu'elle a été répondue
    $update_query = "UPDATE requests SET responded = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "i", $request_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Rediriger vers la même page pour éviter la soumission multiple
    header("Location: contacter.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Contacter un Utilisateur</h2>

        <!-- Affichage des demandes de matériel -->
        <h3>Demandes en cours</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nom de famille</th>
                    <th>Type de demande</th>
                    <th>Matériel demandé</th>
                    <th>Description</th>
                    <th>Date de création</th>
                    <th>Statut</th> <!-- Colonne pour le statut -->
                    <th>Répondre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupération de toutes les demandes de matériel dans la base de données
                $query = "SELECT * FROM requests"; // Récupérer toutes les demandes
                $result = mysqli_query($conn, $query);

                while ($request = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>'.$request['lastname'].'</td>';
                    echo '<td>'.$request['type'].'</td>';
                    echo '<td>'.$request['materiel'].'</td>';
                    echo '<td>'.$request['description'].'</td>';
                    echo '<td>'.$request['created_at'].'</td>';
                    echo '<td>'.($request['responded'] ? 'Répondu' : 'Non répondu').'</td>'; // Affiche le statut
                    echo '<td>';
                    
                    // Vérifier si la demande a été répondue
                    if ($request['responded']) {
                        echo '<span class="text-muted">Déjà répondu</span>'; // Afficher un message si déjà répondu
                    } else {
                        echo '<form action="contacter.php" method="post">
                                <input type="hidden" name="request_id" value="'.$request['id'].'">
                                <textarea name="message" class="form-control" required placeholder="Entrez votre réponse"></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Envoyer</button>
                              </form>';
                    }
                    
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
