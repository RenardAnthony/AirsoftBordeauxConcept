<?php
include_once '../config/session.php'; #Récupérer les informations de mon utilisateur connecté

if($selfuser_role !== 'administrateur' && $selfuser_role !== 'moderateur' && $selfuser_role !== 'organisateur'){
    header("Location: index.php");
    exit();
}

// Initialiser les variables pour la modification
$edit_mode = false;
$partie_id_to_edit = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])){
    $partie_id_to_edit = (int)($_GET['id']);
    $edit_mode = true;

    $sql = "SELECT * FROM agenda WHERE id = :partie_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':partie_id', $partie_id_to_edit, PDO::PARAM_INT);
    $stmt->execute();

    $partie_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si la partie existe
    if (!$partie_to_edit) {
        // Rediriger si la partie n'existe pas
        header("Location: creation_partie.php");
        exit();
    }
}

// Traitement du formulaire de création/modification de partie
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assure-toi de valider et de sécuriser les données du formulaire avant de les utiliser dans des requêtes SQL

    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_event = $_POST['date'];
    $joueur_min = $_POST['joueur_min'];
    $joueur_max = $_POST['joueur_max'];
    $terrain = $_POST['terrain'];
    $bbq = isset($_POST['bbq']) ? 1 : 0;
    $location = isset($_POST['location']) ? 1 : 0;
    $prix_paf = $_POST['prix_paf'];
    $prix_location = $_POST['prix_location'];
    $prix_adherant = $_POST['prix_adherant'];
    $prix_bbq = $_POST['prix_bbq'];

    // Exemple de requête SQL pour insérer une nouvelle partie dans la base de données
    if($edit_mode){

        $date_event = $partie_to_edit['date'];
        $sql = "UPDATE agenda SET
        titre = :titre,
        description = :description,
        date = :date_event,
        joueur_min = :joueur_min,
        joueur_max = :joueur_max,
        terrain = :terrain,
        bbq = :bbq,
        location = :location,
        prix_paf = :prix_paf,
        prix_location = :prix_location,
        prix_adherant = :prix_adherant,
        prix_bbq = :prix_bbq,
        modified_by = :modified_by,
        modified_at = NOW()
        WHERE id = :partie_id";

    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':partie_id', $partie_id_to_edit, PDO::PARAM_INT);
    $stmt->bindParam(':date_event', $date_event);
    }else{
        $sql = "INSERT INTO agenda (titre, description, date, joueur_min, joueur_max, terrain, bbq, location, prix_paf, prix_location, prix_adherant, prix_bbq, created_by, created_at)
        VALUES (:titre, :description, :date_event, :joueur_min, :joueur_max, :terrain, :bbq, :location, :prix_paf, :prix_location, :prix_adherant, :prix_bbq, :created_by, NOW())";

        $null = null;
        $stmt = $conn->prepare($sql);
        $dateFormattedevent = date('Y-m-d H:i:s', strtotime($date_event));
        $stmt->bindParam(':created_by', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->bindParam(':date_event', $dateFormattedevent);
    }

    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':joueur_min', $joueur_min);
    $stmt->bindParam(':joueur_max', $joueur_max);
    $stmt->bindParam(':terrain', $terrain);
    $stmt->bindParam(':bbq', $bbq);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':prix_paf', $prix_paf);
    $stmt->bindParam(':prix_location', $prix_location);
    $stmt->bindParam(':prix_adherant', $prix_adherant);
    $stmt->bindParam(':prix_bbq', $prix_bbq);

    if ($edit_mode) {
        $stmt->bindParam(':modified_by', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->bindParam(':partie_id', $partie_id_to_edit, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        // Redirige l'utilisateur vers une page de confirmation ou une autre page selon tes besoins
        header("Location: staff.php");
        exit();
    } else {
        // Gère les erreurs d'insertion dans la base de données
        $error_message = "Erreur lors de la création de la partie. Veuillez réessayer.";
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
    <title>Creation partie | Admin Zone</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/staff.css"/>
</head>
<body>
    <header><?php include "../includes/header_staff.php";?></header>



    <main>

    
        
    <div>
        <h1>Game <?php echo $edit_mode ? 'Editor' : 'Creator'; ?></h1>

        <?php
            if (isset($error_message)) {
                echo '<p class="error-message">' . $error_message . '</p>';
            }
        ?>

        <form action="creation_partie.php<?= $edit_mode ? '?id=' . $partie_id_to_edit : ''; ?>" method="POST">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['titre']) : ''; ?>" required>

            <label for="description">Description :</label>
            <textarea name="description" rows="4"><?= $edit_mode ? htmlspecialchars($partie_to_edit['description']) : ''; ?></textarea>

            <label for="date">Date :</label>
            <input type="datetime-local" name="date" value="<?= $edit_mode ? date('Y-m-d\TH:i', strtotime($partie_to_edit['date'])) : ''; ?>"required>

            <label for="joueur_min">Joueurs minimum :</label>
            <input type="number" name="joueur_min" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['joueur_min']) : ''; ?>">

            <label for="joueur_max">Joueurs maximum :</label>
            <input type="number" name="joueur_max" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['joueur_max']) : ''; ?>">

            <label for="terrain">Terrain :</label>
            <select name="terrain" required>
                <option value="" <?= ($edit_mode && $partie_to_edit['terrain'] == '') ? 'selected' : ''; ?>></option>
                <option value="Cézac" <?= ($edit_mode && $partie_to_edit['terrain'] == 'Cézac') ? 'selected' : ''; ?>>Cézac</option>
                <option value="Reignac" <?= ($edit_mode && $partie_to_edit['terrain'] == 'Reignac') ? 'selected' : ''; ?>>Reignac</option>
            </select>

            <label for="bbq">BBQ :</label>
            <input type="checkbox" name="bbq" <?= ($edit_mode && $partie_to_edit['bbq'] == 1) ? 'checked' : ''; ?>>

            <label for="location">Location de matériel :</label>
            <input type="checkbox" name="location" <?= ($edit_mode && $partie_to_edit['location'] == 1) ? 'checked' : ''; ?>>

            <label for="prix_paf">Prix PAF :</label>
            <input type="number" name="prix_paf" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_paf']) : ''; ?>">

            <label for="prix_location">Prix location :</label>
            <input type="number" name="prix_location" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_location']) : ''; ?>">

            <label for="prix_adherant">Prix adhérent :</label>
            <input type="number" name="prix_adherant" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_adherant']) : ''; ?>">

            <label for="prix_bbq">Prix BBQ :</label>
            <input type="number" name="prix_bbq" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_bbq']) : ''; ?>">

            <button type="submit"><?= $edit_mode ? 'Modifier' : 'Créer'; ?> la partie</button>

        </form>
    </div>



    </main>



    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>