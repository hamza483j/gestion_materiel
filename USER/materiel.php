<?php 
session_start(); // Commencez la session pour utiliser les variables de session
include '../dbconn.php'; 
include 'navbar.php'; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste du Matériel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            transition: transform 0.5s; /* Transition douce pour le zoom */
        }
        .card:hover .card-img-top {
            transform: scale(0.9); /* Zoom arrière lors du survol */
        }
    </style>
</head>
<body>

<div class="container py-2">
    <h4>Liste du Matériel</h4>
    <div class="row">
        <?php 
          // Requête pour récupérer les données de la table 'materiel'
          $result = mysqli_query($conn, 'SELECT * FROM materiel');

          // Vérifiez s'il y a des résultats
          if (mysqli_num_rows($result) > 0) {
              while ($materiel = mysqli_fetch_assoc($result)) {
                  echo '<div class="col-md-4 mb-4">'; // Colonne pour chaque carte
                  echo '    <div class="card h-100">'; // Carte
                  echo '        <img src="../images/'.$materiel['image'].'" class="card-img-top" alt="'.$materiel['libelle'].'" style="height: 200px; object-fit: cover;">'; // Image de la carte
                  echo '        <div class="card-body">';
                  echo '            <h5 class="card-title">'.$materiel['libelle'].'</h5>'; // Titre de la carte
                  echo '            <form action="demander_materiel.php?id='.$materiel['id'].'" method="post">'; // Formulaire pour envoyer la demande
                  echo '                <div class="mb-3">';
                  echo '                    <label for="type" class="form-label">Type de demande:</label>';
                  echo '                    <select name="type" id="type" class="form-control" required>';
                  echo '                        <option value="">Sélectionner un type</option>';
                  echo '                        <option value="Besoin de matériel">Besoin de matériel</option>';
                  echo '                        <option value="Signaler une panne">Signaler une panne</option>';
                  echo '                    </select>';
                  echo '                </div>';
                  echo '                <div class="mb-3">';
                  echo '                    <label for="description" class="form-label">Description:</label>';
                  echo '                    <textarea id="description" name="description" class="form-control" rows="2" required></textarea>';
                  echo '                </div>';
                  echo '                <button type="submit" class="btn btn-success">Envoyer Demande</button>'; // Bouton pour envoyer la demande
                  echo '            </form>';
                  echo '        </div>'; // Fin du corps de la carte
                  echo '    </div>'; // Fin de la carte
                  echo '</div>'; // Fin de la colonne
              }
          } else {
              echo '<div class="col-12"><p class="text-center">Aucun matériel disponible.</p></div>'; // Message quand aucun matériel n'est disponible
          }
        ?>
    </div>
</div>

</body>
</html>
