<?php
include_once '../config/session.php';

// Vérifier si l'utilisateur est administrateur
if ($selfuser_role !== 'administrateur') {
    // Rediriger s'il n'est pas administrateur
    header("Location: index.php");
    exit();
}

// Vérifier si l'id de l'utilisateur à supprimer est passé en argument
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id_to_delete = (int)$_GET['id'];
} else {
    // Rediriger s'il manque l'id
    header("Location: index.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le nom entré correspond exactement au nom de l'utilisateur à supprimer
    $user_name_to_delete = $_POST['user_name'];
    $queryCheckName = "SELECT username FROM users WHERE id = :user_id";
    $stmtCheckName = $conn->prepare($queryCheckName);
    $stmtCheckName->bindParam(':user_id', $user_id_to_delete, PDO::PARAM_INT);
    $stmtCheckName->execute();
    $result = $stmtCheckName->fetch(PDO::FETCH_ASSOC);

    if ($result !== false && $user_name_to_delete === $result['username']) {
        // Supprimer l'utilisateur de la table Users
        $queryDeleteUser = "DELETE FROM users WHERE id = :user_id";
        $stmtDeleteUser = $conn->prepare($queryDeleteUser);
        $stmtDeleteUser->bindParam(':user_id', $user_id_to_delete, PDO::PARAM_INT);
        $stmtDeleteUser->execute();

        // Supprimer les répliques de l'utilisateur de la table Réplique
        $queryDeleteRepliques = "DELETE FROM replique WHERE proprio = :user_id";
        $stmtDeleteRepliques = $conn->prepare($queryDeleteRepliques);
        $stmtDeleteRepliques->bindParam(':user_id', $user_id_to_delete, PDO::PARAM_INT);
        $stmtDeleteRepliques->execute();

        echo '<p class="success-message">L\'utilisateur a été supprimé avec succès.</p>';

        // Rediriger vers une page de confirmation ou autre
        header("Location: staff_userlist.php");
        exit();
    } else {
        $error_message = "Le nom ne correspond pas. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-control" content="public">
    <title>Admin Zone</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/faviconadmin.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/staff.css"/>
</head>
<body>
    <header><?php include "../includes/header_staff.php";?></header>

    <main>
        <div>
            <h1>Supprimer un utilisateur</h1>

            <?php
            if (isset($error_message)) {
                echo '<p class="error-message">' . $error_message . '</p>';
            }
            ?>

            <form action="staff_supp_user.php?id=<?= $user_id_to_delete; ?>" method="POST">
                <label for="user_name">Entrez le nom de l'utilisateur à supprimer :</label>
                <input type="text" name="user_name" required>

                <button type="submit">Confirmer la suppression</button>
            </form>
        </div>
    </main>
</body>
</html>
