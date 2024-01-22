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

    $type = $_POST['type'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_event = $_POST['date'];
    $joueur_min = $_POST['joueur_min'];
    $joueur_max = $_POST['joueur_max'];
    $terrain = $_POST['terrain'];
    $adresse = $_POST['adresse'];
    $bbq = isset($_POST['bbq']) ? 1 : 0;
    $location = isset($_POST['location']) ? 1 : 0;
    $freelance = isset($_POST['freelance']) ? 1 : 0;
    $prix_paf = $_POST['prix_paf'];
    $prix_location = $_POST['prix_location'];
    $prix_adherant = $_POST['prix_adherant'];
    $prix_bbq = $_POST['prix_bbq'];
    $repliques_autorisees = isset($_POST['repliques_autorisees']) ? implode(',', $_POST['repliques_autorisees']) : ''; // Récupérez les types de répliques sélectionnés depuis le formulaire

    // Exemple de requête SQL pour insérer une nouvelle partie dans la base de données
    if($edit_mode){

        /*$date_event = $partie_to_edit['date'];*/
        $sql = "UPDATE agenda SET
        type = :type,
        titre = :titre,
        description = :description,
        date = :date_event,
        joueur_min = :joueur_min,
        joueur_max = :joueur_max,
        terrain = :terrain,
        adresse = :adresse,
        bbq = :bbq,
        location = :location,
        freelance = :freelance,
        prix_paf = :prix_paf,
        prix_location = :prix_location,
        prix_adherant = :prix_adherant,
        prix_bbq = :prix_bbq,
        replique_autoriser = :replique_autoriser,
        modified_by = :modified_by,
        modified_at = NOW()
        WHERE id = :partie_id";

    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':partie_id', $partie_id_to_edit, PDO::PARAM_INT);
    $stmt->bindParam(':date_event', $date_event);
    }else{
        $sql = "INSERT INTO agenda (type, titre, description, date, joueur_min, joueur_max, replique_autoriser, terrain, adresse; bbq, location, freelance, prix_paf, prix_location, prix_adherant, prix_bbq, created_by, created_at)
        VALUES (:type, :titre, :description, :date_event, :joueur_min, :joueur_max, :replique_autoriser, :terrain, :adresse, :bbq, :location, :freelanc, :prix_paf, :prix_location, :prix_adherant, :prix_bbq, :created_by, NOW())";

        $null = null;
        $stmt = $conn->prepare($sql);
        $dateFormattedevent = date('Y-m-d H:i:s', strtotime($date_event));
        $stmt->bindParam(':created_by', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->bindParam(':date_event', $dateFormattedevent);
    }

    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':joueur_min', $joueur_min);
    $stmt->bindParam(':joueur_max', $joueur_max);
    $stmt->bindParam(':terrain', $terrain);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':bbq', $bbq);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':freelance', $freelance);
    $stmt->bindParam(':prix_paf', $prix_paf);
    $stmt->bindParam(':prix_location', $prix_location);
    $stmt->bindParam(':prix_adherant', $prix_adherant);
    $stmt->bindParam(':prix_bbq', $prix_bbq);
    $stmt->bindParam(':replique_autoriser', $repliques_autorisees);


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


        <div class="center_partie_creation">
            <h1>Game <?php echo $edit_mode ? 'Editor' : 'Creator'; ?></h1>
        </div>

        <div class="spacer_1"></div>

        <?php
            if (isset($error_message)) {
                echo '<p class="error-message">' . $error_message . '</p>';
            }

            echo "<div class=\"spacer_1\"></div>";
        ?>

        <div class="center_partie_creation">
            <form action="staff_creation_partie.php<?= $edit_mode ? '?id=' . $partie_id_to_edit : ''; ?>" method="POST">
                <div class="table_parte">
                    <label for="type">Type d'evenement :</label>
                    <select name="type" class="input_select" required>
                        <option value="partie" <?= ($edit_mode && $partie_to_edit['type'] == 'partie') ? 'selected' : ''; ?>>Partie</option>
                        <option value="evenement" <?= ($edit_mode && $partie_to_edit['type'] == 'evenement') ? 'selected' : ''; ?>>Evenement</option>
                    </select>

                    <label for="titre">Titre :</label>
                    <input type="text" name="titre" class="input_texte" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['titre']) : ''; ?>" required>

                    <label for="description">Courte description :</label>
                    <textarea name="description" rows="4" class="input_textarea"><?= $edit_mode ? htmlspecialchars($partie_to_edit['description']) : ''; ?></textarea>

                    <label for="date">Date :</label>
                    <input type="datetime-local" name="date" class="input_select" value="<?= $edit_mode ? date('Y-m-d\TH:i', strtotime($partie_to_edit['date'])) : ''; ?>"required>

                    <label for="joueur_min">Joueurs minimum :</label>
                    <input type="number" name="joueur_min" class="input_chiffre_select" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['joueur_min']) : ''; ?>">
                    
                    <label for="joueur_max">Joueurs maximum :</label>
                    <input type="number" name="joueur_max" class="input_chiffre_select" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['joueur_max']) : ''; ?>">

                    <label for="terrain">Terrain :</label>
                    <select name="terrain" class="input_select">
                        <option value="" <?= ($edit_mode && $partie_to_edit['terrain'] == '') ? 'selected' : ''; ?>></option>
                        <option value="Cézac" <?= ($edit_mode && $partie_to_edit['terrain'] == 'Cézac') ? 'selected' : ''; ?>>Cézac</option>
                        <option value="Reignac" <?= ($edit_mode && $partie_to_edit['terrain'] == 'Reignac') ? 'selected' : ''; ?>>Reignac</option>
                        <option value="Autre" <?= ($edit_mode && $partie_to_edit['terrain'] == 'Autre') ? 'selected' : ''; ?>>Autre</option>
                    </select>

                    <label for="adresse">Adresse (ou numero du terrain):</label>
                    <input type="text" name="adresse" class="input_textarea" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['adresse']) : ''; ?>">
                </div>
                <div class="table_parte">
                    <div class="side_by_side">
                        <label for="bbq">Barbeque : </label>
                        <input type="checkbox" name="bbq" <?= ($edit_mode && $partie_to_edit['bbq'] == 1) ? 'checked' : ''; ?>>
                    </div>

                    <div class="side_by_side">
                        <label for="location">Location de matériel :</label>
                        <input type="checkbox" name="location" <?= ($edit_mode && $partie_to_edit['location'] == 1) ? 'checked' : ''; ?>>
                    </div>

                    <div class="side_by_side">
                        <label for="freelance">Freelance : </label>
                        <input type="checkbox" name="freelance" <?= ($edit_mode && $partie_to_edit['freelance'] == 1) ? 'checked' : ''; ?>>
                    </div>
                    

                    <label for="prix_paf">Prix PAF :</label>
                    <input type="number" name="prix_paf" class="input_chiffre_select" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_paf']) : ''; ?>">
                    
                    <label for="prix_location">Prix location :</label>
                    <input type="number" name="prix_location" class="input_chiffre_select" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_location']) : ''; ?>">

                    <label for="prix_adherant">Prix adhérent :</label>
                    <input type="number" name="prix_adherant" class="input_chiffre_select" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_adherant']) : ''; ?>">

                    <label for="prix_bbq">Prix BBQ :</label>
                    <input type="number" name="prix_bbq" class="input_chiffre_select" value="<?= $edit_mode ? htmlspecialchars($partie_to_edit['prix_bbq']) : ''; ?>">


                    <label>Répliques autorisées :</label>
                        <?php
                        // Récupérez la liste des types de répliques depuis la base de données
                        $queryTypes = "SELECT DISTINCT type FROM replique";
                        $stmtTypes = $conn->prepare($queryTypes);
                        $stmtTypes->execute();
                        $types = $stmtTypes->fetchAll(PDO::FETCH_ASSOC);

                        // Affichez chaque type de réplique comme une case à cocher
                        foreach ($types as $type) {
                            $checked = ($edit_mode && in_array($type['type'], explode(',', $partie_to_edit['replique_autoriser']))) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="repliques_autorisees[]" value="' . $type['type'] . '" ' . $checked . '>' . $type['type'] . '</label>';
                        }
                        ?>

                    <button type="submit" class="button_partie"><?= $edit_mode ? 'Modifier' : 'Créer'; ?> la partie</button>
                </div>
            </form>
        </div>
    </main>



    <footer></footer>
</body>
</html>