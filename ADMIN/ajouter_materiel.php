<?php include '../dbconn.php'; ?>
<?php include 'navbare.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Matériel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-2">
    <h4>Ajouter un Matériel</h4>
    <form action="ajouter_materiel.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="libelle" class="form-label">Libellé</label>
            <input type="text" class="form-control" id="libelle" name="libelle" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $libelle = $_POST['libelle'];
    $targetDir = '../images/'; // Chemin vers le dossier d'images
    $targetFile = $targetDir . basename($_FILES['image']['name']);

    // Vérifiez si le dossier existe
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Crée le dossier s'il n'existe pas
    }

    // Déplacer le fichier téléchargé
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // Préparez la requête d'insertion
        $sql = "INSERT INTO materiel (libelle, image, date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);

        // Utilisez une variable intermédiaire pour éviter la notice
        $imageName = basename($_FILES['image']['name']);
        $stmt->bind_param("ss", $libelle, $imageName);

        // Exécutez la requête
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Le matériel a été ajouté avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'ajout du matériel : " . $conn->error . "</div>";
        }

        // Fermer la requête
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'upload de l'image.</div>";
    }
}
?>

</body>
</html>
