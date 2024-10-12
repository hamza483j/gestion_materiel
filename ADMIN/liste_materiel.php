<?php include '../dbconn.php'; ?>
<?php include 'navbare.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste du Matériel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-2">
    <h4>Liste du Matériel</h4>
    <table class="table table-light table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>LIBELLE</th>
                <th>DATE</th>
                <th>IMAGE</th>
                <th>OPERATIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              // Requête pour récupérer les données de la table 'materiel'
              $result = mysqli_query($conn, 'SELECT * FROM materiel');

              while ($materiel = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>'.$materiel['id'].'</td>';
                echo '<td>'.$materiel['libelle'].'</td>';
                echo '<td>'.$materiel['date'].'</td>';
                echo '<td><img class="img-fluid" src="../images/'.$materiel['image'].'" alt="'.$materiel['libelle'].'" width="70"></td>'; 
                echo '<td>
                          <a href="modifier_materiel.php?id='.$materiel['id'].'" class="btn btn-primary btn-sm">Modifier</a>
                          <a href="supprimer_materiel.php?id='.$materiel['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce matériel ?\')">Supprimer</a>
                      </td>';
                echo '</tr>';
              }
            ?>
        </tbody>
    </table>
    <a href="ajouter_materiel.php" class="btn btn-success">Ajouter un Matériel</a>
</div>

</body>
</html>
