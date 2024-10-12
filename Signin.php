<?php
session_start();
include("dbconn.php");

$alertMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $alertMessage = "S'il vous plaît remplissez tous les champs";
    } else {
        // Vérifier si l'utilisateur est un admin
        $stmt = mysqli_prepare($conn, "SELECT email, password FROM admin WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $admin_email, $db_password);
        
        if (mysqli_stmt_fetch($stmt)) {
            if ($password == $db_password) {
                $_SESSION["email"] = $admin_email;
                $_SESSION["admin"] = true; // Définir une session spécifique pour l'admin

                // Redirection vers la page d'accueil admin si admin
                header("Location: ADMIN/acceuil.php");
                exit;
            } else {
                $alertMessage = "Mot de passe incorrect";
            }
        } else {
            // Vérifier si l'utilisateur est un utilisateur normal
            $stmt = mysqli_prepare($conn, "SELECT name, lastname, password FROM user WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $name, $last_name, $db_password);
            
            if (mysqli_stmt_fetch($stmt)) {
                if ($password == $db_password) {
                    $_SESSION["email"] = $email;
                    $_SESSION["lastname"] = $last_name;
                    $_SESSION["name"] = $name;

                    // Redirection vers la page home.php si utilisateur normal
                    header("Location: USER/home.php");
                    exit;
                } else {
                    $alertMessage = "Mot de passe incorrect";
                }
            } else {
                $alertMessage = "Compte inconnu";
            }
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles pour la page de connexion */
        body {
            background-color: #ebf5df; /* Couleur de fond vert forêt */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #bad4aa; /* Couleur de fond blanc pour le conteneur */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
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

        .signin {
            margin-top: 15px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Se connecter</button> <!-- Supprimé btn-primary -->
            <a href="signup.php" class="signin">Créer un compte</a>
        </form>
        <?php
        if (!empty($alertMessage)) {
            echo "<script>alert('$alertMessage');</script>";
        }
        ?>
    </div>
</body>
</html>
