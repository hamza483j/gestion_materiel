<?php
session_start();
include("../dbconn.php");  // Vérifiez le chemin de ce fichier si nécessaire

// Récupérer le nom de famille de l'utilisateur connecté
$lastname = $_SESSION['lastname']; // Assurez-vous que le nom de famille est stocké dans la session
include("navbar.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Demandes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Mes Demandes</h2>
        
        <!-- Affichage des demandes et réponses -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID de la Demande</th>
                    <th>Nom du Matériel</th>
                    <th>Description</th>
                    <th>Réponse de l'Administrateur</th>
                    <th>Date de réponse</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupération des demandes de matériel et des réponses
                $stmt = mysqli_prepare($conn, "SELECT r.id, r.materiel, r.description, resp.admin_message, resp.date 
                                                FROM requests r 
                                                LEFT JOIN responses resp ON r.id = resp.request_id 
                                                WHERE r.lastname = ?");
                mysqli_stmt_bind_param($stmt, "s", $lastname);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>'.$row['id'].'</td>'; // ID de la demande
                    echo '<td>'.$row['materiel'].'</td>'; // Nom du matériel
                    echo '<td>'.$row['description'].'</td>'; // Description de la demande
                    echo '<td>'.($row['admin_message'] ? $row['admin_message'] : 'Pas encore de réponse').'</td>'; // Réponse de l'admin
                    echo '<td>'.($row['date'] ? $row['date'] : 'Pas encore de réponse').'</td>'; // Date de la réponse
                    echo '</tr>';
                }

                mysqli_stmt_close($stmt); // Fermer la requête
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
