<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Vérification du formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $old_password = htmlspecialchars($_POST['old_password']);
        $new_password = htmlspecialchars($_POST['new_password']);
        $confirm_new_password = htmlspecialchars($_POST['confirm_new_password']);

        // Récupérer le mot de passe actuel de l'utilisateur depuis la base de données
        $get_password_query = "SELECT mdp FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($get_password_query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($old_password, $user['mdp'])) {
            // Ancien mot de passe correct
            if (strlen($new_password) >= 8 && preg_match('/[A-Z]/', $new_password) && preg_match('/[^a-zA-Z\d]/', $new_password)) {
                // Nouveau mot de passe conforme aux exigences
                if ($new_password === $confirm_new_password) {
                    // Mettre à jour le mot de passe dans la base de données
                    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
                    $update_password_query = "UPDATE users SET mdp = :hashed_password WHERE id = :user_id";
                    $stmt = $conn->prepare($update_password_query);
                    $stmt->bindParam(':hashed_password', $hashed_new_password);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->execute();

                    // Rediriger avec un message de succès
                    $_SESSION['success_message'] = "Votre mot de passe a été mis à jour avec succès.";
                    header("Location: ../pages/profil_edit.php");
                    exit();
                } else {
                    $error_message = "Les nouveaux mots de passe ne correspondent pas.";
                }
            } else {
                $error_message = "Le nouveau mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial.";
            }
        } else {
            $error_message = "Ancien mot de passe incorrect.";
        }
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../pages/connection.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Description de la page (environ 150-160 caractères)">
    <meta name="keywords" content="mots clés, séparés par des virgules, pertinents pour la page">
    <meta name="author" content="Votre nom ou le nom de votre association">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Cache-control" content="public">
    <title>Changer le mot de passe | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/profil_edit.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>

    <main id="mdp_edition">
        <h1>Changer le mot de passe</h1>

        <?php
        if (isset($error_message)) {
            echo '<p style="color: red;">' . $error_message . '</p>';
        }
        ?>
        <form method="post" action="">
            <table>
                <tr>
                    <td><label for="old_password">Ancien mot de passe :</label></td>
                    <td><input type="password" id="old_password" class="input-text-base" name="old_password" required></td>
                </tr>
                <tr>
                    <td><label for="new_password">Nouveau mot de passe :</label></td>
                    <td><input type="password" id="new_password" name="new_password" class="input-text-base" required></td>
                </tr>
                <tr>
                    <td><label for="confirm_new_password">Confirmer le nouveau mot de passe :</label></td>
                    <td><input type="password" id="confirm_new_password" class="input-text-base" name="confirm_new_password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit">Changer le mot de passe</button></td>
                </tr>
            </table>

        </form>
    </main>

    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>
