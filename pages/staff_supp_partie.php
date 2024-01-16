<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

if(!isset($_SESSION['id'])){ // Vérifier si l'utilisateur est connecté
    header("Location: login.php");
    exit();
}

if($selfuser_role !== 'administrateur' && $selfuser_role !== 'moderateur' && $selfuser_role !== 'organisateur'){
    header("Location: index.php");
    exit();
}

function getParties($conn) {
    // Récupérer toutes les parties depuis la base de données
    $sql = "SELECT * FROM agenda WHERE date > NOW() ORDER BY date ASC";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}






function deletePartie($conn, $partie_id) {
    // Supprimer une partie en fonction de son ID
    $sql = "DELETE FROM agenda WHERE id = :partie_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':partie_id', $partie_id, PDO::PARAM_INT);
    return $stmt->execute();
}






# Récupère les parties depuis la base de données
$parties = getParties($conn);

// Vérifie si le formulaire de suppression est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Vérifie si des parties ont été cochées
    if (isset($_POST['parties'])) {
        // Supprime les parties sélectionnées
        $parties_to_delete = $_POST['parties'];
        foreach ($parties_to_delete as $partie_id) {
            deletePartie($conn, $partie_id);
        }
        header("Location: staff.php");
    } else {
        echo "Aucune partie sélectionnée pour la suppression.";
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
        
        <h1>Supprimer des Parties</h1>
        <p>WARNING : Ne suprimez pas les partie passer. On en a besoin pour les statistique et la compatibilité merci !</p>
        <form method="post" action="supp_partie.php">
            <ul>
                <?php foreach ($parties as $partie) : ?>
                    <li>
                        <label>
                            <input type="checkbox" name="parties[]" value="<?= $partie['id'] ?>">
                            <?= htmlspecialchars($partie['titre']); ?>
                            <?= htmlspecialchars($partie['description']); ?>
                            <?= htmlspecialchars($partie['terrain']); ?>
                            <?= htmlspecialchars($partie['date']); ?>
                            <?= htmlspecialchars($partie['created_by']); ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit" name="submit">Supprimer les parties sélectionnées</button>
        </form>

    </main>



    <footer></footer>
</body>
</html>