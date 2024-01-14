<?php
session_start();

if (isset($_SESSION['id'])) {

    include '../config/db.php';
    $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $user_id = $_SESSION['id'];
    
    $requser = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier si le pseudo de confirmation correspond à celui de l'utilisateur
        if (isset($_POST['pseudo_confirmation']) && $_POST['pseudo_confirmation'] === $user['username']) {
            // Connexion à la base de données
            

            // Supprimer le compte et toutes les informations de l'utilisateur
            $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$user_id]);

            // Déconnecter l'utilisateur
            session_unset();
            session_destroy();

            // Rediriger vers la page d'accueil après la suppression du compte
            header("Location: ../pages/index.php");
            exit();
        } else {
            // Afficher un message d'erreur si le pseudo de confirmation ne correspond pas
            $error_message = "Le pseudo de confirmation ne correspond pas. Veuillez réessayer.";
        }
    }

    // Afficher le formulaire de confirmation de suppression du compte
    $user_pseudo = $_SESSION['pseudo'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises meta pour les informations de la page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Description de la page (environ 150-160 caractères)">
    <meta name="keywords" content="mots clés, séparés par des virgules, pertinents pour la page">
    <meta name="author" content="Votre nom ou le nom de votre association">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Cache-control" content="public">
    <title>Supprimer mon compte | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <!-- Autres feuilles de style CSS si nécessaire -->
    <link rel="stylesheet" href="../css/suppression_user.css"/>
</head>
<body>
    <!-- Inclusion du header -->
    <header><?php include "../includes/header.php";?></header>

    <main>
        <h1>Supprimer mon compte et toutes mes informations personnelles</h1>

        <p>Veuillez confirmer la suppression de votre compte en saisissant de nouveau votre pseudo :</p>

        <form method="post" action="">
            <label for="pseudo_confirmation">Pseudo :</label>
            <input type="text" name="pseudo_confirmation" id="pseudo_confirmation" required>
            <button type="submit">Confirmer la suppression</button>
        </form>


        <?php if (isset($error_message)) { ?>
            <p class="error"><?=$error_message?></p>
        <?php } ?>
    </main>

    <!-- Inclusion du footer -->
    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>

<?php
} else {
    // Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
    header("Location: ../pages/index.php"); 
}
?>