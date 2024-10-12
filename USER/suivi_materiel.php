<?php
session_start();
include("../dbconn.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["email"])) {
    header("Location: ../Signin.php");
    exit();
}

$lastname = $_SESSION["lastname"]; // Récupérer le nom de famille de la session

// Récupérer les demandes de matériel de l'utilisateur connecté
$stmt = mysqli_prepare($conn, "SELECT id, materiel, type, description, created_at FROM requests WHERE lastname = ?");
mysqli_stmt_bind_param($stmt, "s", $lastname);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $materiel, $type, $description, $date_request);
include("navbar.php"); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des demandes de matériel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Suivi des demandes de matériel</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matériel</th>
                    <th>Type de demande</th>
                    <th>Description</th>
                    <th>Date de demande</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Afficher les demandes de matériel
                while (mysqli_stmt_fetch($stmt)) {
                    echo "<tr>";
                    echo "<td>{$id}</td>";
                    echo "<td>{$materiel}</td>";
                    echo "<td>{$type}</td>";
                    echo "<td>{$description}</td>";
                    echo "<td>{$date_request}</td>";
                    echo "</tr>";
                }
                mysqli_stmt_close($stmt);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
