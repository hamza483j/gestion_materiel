<?php
session_start();
include("dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email2"];
    $password = $_POST["password2"];

    if (!empty($name) && !empty($lastname) && !empty($email) && !empty($password)) {
        $stmt = mysqli_prepare($conn, "SELECT email FROM user WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "<script>alert('L\'email existe déjà !!'); window.location.href ='signin.php';</script>";
        } else {
            $query = "INSERT INTO user (name, lastname, email, password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $lastname, $email, $password);
            mysqli_stmt_execute($stmt);
            echo "<script>alert('Vous avez été enregistré.'); window.location.href = 'signin.php';</script>";
        }
    } else {
        echo "<script>alert('Certaines informations sont incorrectes. Veuillez vérifier à nouveau');</script>";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Inscription</title>
    <style>
        body {
            background-color: #ebf5df; /* Couleur de fond vert forêt */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background-color: #bad4aa; /* Couleur de fond blanc pour le conteneur */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .signup-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50; /* Bleu foncé pour le titre */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 2px solid #4caf50; /* Bordure verte pour les champs */
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #1abc9c; /* Bordure verte au focus */
        }

        .btn {
            width: 100%;
            background-color: #4caf50; /* Couleur personnalisée pour le bouton */
            color: white; /* Couleur du texte du bouton */
            border: none; /* Supprimer la bordure par défaut */
            transition: background-color 0.3s; /* Ajouter une transition */
        }

        .btn:hover {
            background-color: #388e3c; /* Couleur légèrement plus foncée au survol */
        }

        .log {
            color: #e74c3c; /* Rouge vif pour les liens */
            text-decoration: none;
        }

        .log:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <form method="post">
            <h1>Inscription</h1>
            <div class="form-group">
                <label for="name" class="form-label">Nom :</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lastname" class="form-label">Prénom :</label>
                <input type="text" name="lastname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email2" class="form-label">Email :</label>
                <input type="email" name="email2" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password2" class="form-label">Mot de passe :</label>
                <input type="password" name="password2" class="form-control" required>
            </div>
            <button type="submit" class="btn">Soumettre</button>
            <div class="mt-3">
                <label>Vous avez déjà un compte ? <a href="signin.php" class="log">Se connecter</a></label>
            </div>
        </form>
    </div>
</body>
</html>
