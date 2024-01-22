<?php
include_once '../config/session.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$get_eventId = htmlspecialchars($_GET['id']);
$get_friend = isset($_GET['friend']);

$requser = $conn->prepare('SELECT * FROM agenda WHERE id = ?');
$requser->execute(array($get_eventId));
$evenent = $requser->fetch();

if (empty($evenent['id']) || empty($get_eventId)) {
    header("Location: ../pages/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assurez-vous que le formulaire a été soumis en utilisant la méthode POST

    // Récupérez les valeurs du formulaire
    $event_id = $get_eventId;
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $option_bbq = isset($_POST['option_bbq']) ? 1 : 0;
    $option_location = isset($_POST['option_location']) ? 1 : 0;
    $covoiturage = isset($_POST['covoiturage']) ? 1 : 0;

    // Vérifiez si l'utilisateur inscrit un ami
    $get_friend = isset($_POST['friend']) ? true : false;

    // Si c'est un ami, récupérez le pseudo de l'ami
    $ami_pseudo = $get_friend ? htmlspecialchars($_POST['pseudo_ami']) : null;

    // Ajoutez la logique pour insérer les données dans la table partie_inscriptions
    try {
        // Utilisez une requête SQL préparée pour éviter les injections SQL

        // Remplacez les placeholders avec les noms de colonnes de votre table partie_inscriptions
        $sql = "INSERT INTO partie_inscriptions (event_id, user_id, pseudo, option_bbq, option_location, covoiturage, date_inscription) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);

        // Liez les paramètres
        $stmt->bindParam(1, $event_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $selfuser_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(4, $option_bbq, PDO::PARAM_INT);
        $stmt->bindParam(5, $option_location, PDO::PARAM_INT);
        $stmt->bindParam(6, $covoiturage, PDO::PARAM_INT);

        // Exécutez la requête
        $stmt->execute();

        // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
        header("Location: ../pages/index.php");
        exit();
    } catch (PDOException $e) {
        // Gérez les erreurs de base de données ici, par exemple, affichez un message d'erreur
        echo "Erreur d'inscription : " . $e->getMessage();
    }
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
    <title>Inscription evenement | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/partie.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>

    <main class="page_marge">
        <form action="" method="post" class="inscription_partie" id="inscriptionForm">
            <?php if (!$get_friend) { ?>
                <fieldset>
                    <legend>Inscription Personnel</legend>

                    <input type="text" name="pseudo" placeholder="Pseudo" class="myname" value="<?=$selfuser_username?>" readonly>

                    <div class="align_left">
                        <div>
                            <input type="checkbox" name="option_bbq" id="option_bbq">
                            <label for="option_bbq">Option BBQ (<?=$evenent['prix_bbq']?>€)</label>
                        </div>
                        <div>
                            <input type="checkbox" name="option_location" id="option_location">
                            <label for="option_location">Option location (<?=$evenent['prix_location']?>€)</label>
                        </div>
                        <div>
                            <input type="checkbox" name="covoiturage" id="covoiturage">
                            <label for="covoiturage">Besoin d'un covoiturage</label>
                        </div>

                        <br>
                        
                        <div onclick="show_confirm">
                            <input type="checkbox" name="regles" id="regles_1" onclick="validateForm()">
                            <label for="regles">J'ai pris connaissance des règles</label>
                        </div>
                    </div>
                </fieldset>

            <?php } else { ?>
                <fieldset>
                    <legend>Inscrire un(e) ami(e)</legend>

                    <input type="text" name="pseudo" placeholder="Pseudo de l'ami(e)" class="myname">

                    <div class="align_left">
                        <div>
                            <input type="checkbox" name="option_bbq" id="option_bbq_friend">
                            <label for="option_bbq_friend">Option BBQ (<?=$evenent['prix_bbq']?>€)</label>
                        </div>
                        <div>
                            <input type="checkbox" name="option_location" id="option_location_friend">
                            <label for="option_location_friend">Option location (<?=$evenent['prix_location']?>€)</label>
                        </div>
                        <div>
                            <input type="checkbox" name="covoiturage_friend" id="covoiturage_friend">
                            <label for="covoiturage_friend">Besoin d'un covoiturage</label>
                        </div>

                        <br>

                        <div>
                            <input type="checkbox" name="regles" id="regles_2" onclick="validateForm()">
                            <label for="regles">Mon ami(e) connaît les règles. En cochant cette case, je deviens responsable de son comportement sur le terrain.</label>
                        </div>
                    </div>
                </fieldset>
            <?php } ?>
            <input type="submit" value="Valider" id="button_validation">
        </form>

        <script>
            button_validation.style.display = "none";
            // Fonction de validation du formulaire
            function validateForm() {
                var regles_1 = document.getElementById('regles_1');
                var regles_2 = document.getElementById('regles_2');
                var button_validation = document.getElementById('button_validation');

                button_validation.style.display = "block";
            }
        </script>
    </main>

    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>