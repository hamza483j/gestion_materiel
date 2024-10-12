<?php 
// Connexion à la base de données
include '../dbconn.php';

// Récupérer l'ID du matériel depuis l'URL
$id = $_GET['id'];

// Requête pour récupérer les informations du matériel à modifier
$result = mysqli_query($conn, "SELECT * FROM materiel WHERE id = $id");
$materiel = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $libelle = $_POST['libelle'];
    $date = $_POST['date'];
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $materiel['image'];

    // Requête de mise à jour du matériel
    $sql = "UPDATE materiel SET libelle = '$libelle', date = '$date', image = '$image' WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        // Si une nouvelle image est uploadée, on la déplace dans le dossier approprié
        if ($_FILES['image']['name']) {
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);
        }
        // Redirection vers la page de liste après mise à jour
        header('Location: liste_materiel.php');
        exit;
    } else {
        // En cas d'erreur
        echo 'Erreur lors de la mise à jour du matériel : ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Matériel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Modifier Matériel</h2>
    <!-- Formulaire de modification du matériel -->
    <form action="modifier_materiel.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="libelle" class="form-label">Libellé</label>
            <input type="text" name="libelle" class="form-control" value="<?php echo $materiel['libelle']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo $materiel['date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            <img src="../images/<?php echo $materiel['image']; ?>" alt="<?php echo $materiel['libelle']; ?>" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>

</body>
</html>
