<?php
include_once '../config/session.php'; # Recuperer les informations de mon utilisateur connecte
if (!isset($_SESSION['id'])) { // Verifier si l'utilisateur est connecté
    header("Location: login.php");
    exit();
}
if ($selfuser_role !== 'administrateur' && $selfuser_role !== 'moderateur') {
    header("Location: index.php");
    exit();
}

// Requête SQL pour récupérer les répliques
$query = "SELECT * FROM replique";
$stmt = $conn->prepare($query);
$stmt->execute();
$repliques = $stmt->fetchAll(PDO::FETCH_ASSOC);
$countTotal = count($repliques);

// Initialisation du tableau pour compter les répliques par type
$countByType = array();

// Requête SQL pour récupérer les répliques dépassant 350 FPS
$queryHighFPS = "SELECT * FROM replique WHERE fps > 351";
$stmtHighFPS = $conn->prepare($queryHighFPS);
$stmtHighFPS->execute();
$highFPSRepliques = $stmtHighFPS->fetchAll(PDO::FETCH_ASSOC);

// Compter les répliques par type
foreach ($repliques as $replique) {
    $type = $replique["type"];
    if (!isset($countByType[$type])) {
        $countByType[$type] = 1;
    } else {
        $countByType[$type]++;
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
        <div class="count_pannel">
            <div class="element">
                <h1>0</h1>
                <p>Min FPS</p>
            </div>
            <div class="element">
                <h1>0</h1>
                <p>Max FPS</p>
            </div>
            <div class="element">
                <h1><?=$countTotal?></h1>
                <p>Réplique total</p>
            </div>
        </div>

        <div class="spacer_1"></div>

        <div class="cadre_securite">
            <h2>Nombre de répliques par type :</h2>
            <ul>
                <?php foreach ($countByType as $type => $count): ?>
                    <li><?= $type ?> : <?= $count ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="spacer_1"></div>

        <div class="table_style_1" id="warn-fps">
            <table>
                <thead>
                    <tr>
                        <th colspan="5"><p class="warn_fps">FPS Warning</p></th>
                    </tr>
                </thead>
                <tr class="colone_name">
                    <td><p>ID</p></td>
                    <td><p>Nom</p></td>
                    <td><p>Type</p></td>
                    <td><p>Propriétaire</p></td>
                    <td><p>Puissance</p></td>
                </tr>
                <?php foreach($highFPSRepliques as $highFPSReplique):
                    // Requête SQL pour obtenir le nom du propriétaire
                    $queryUser = "SELECT username FROM users WHERE id = :proprio_id";
                    $stmtUser = $conn->prepare($queryUser);
                    $stmtUser->bindParam(':proprio_id', $highFPSReplique["proprio"]);
                    $stmtUser->execute();
                    $userName22 = $stmtUser->fetch(PDO::FETCH_ASSOC);

                    // Vérifier si l'utilisateur est défini, sinon utiliser "unknown"
                    $userName22 = isset($userName22['username']) ? $userName22['username'] : '-';
                ?>
                    <tr>
                        <td><p><?=$highFPSReplique["id"]?></p></td>
                        <td><p><?=$highFPSReplique["nom"]?></p></td>
                        <td><p><?=$highFPSReplique["type"]?></p></td>
                        <td><p><a href="profil.php?id=<?=$highFPSReplique["proprio"]?>"><?=$userName22?></a></p></td>
                        <td><p class="warn_fps"><?=$highFPSReplique["fps"]?> fps</p></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="spacer_2"></div>

        <div class="table_style_1">
            <table>
                <thead>
                    <tr>
                        <th colspan="8"><img src="../assets/images/theme/replique.png" alt="Logo répliques"><p>Répliques</p></th>
                    </tr>
                </thead>
                <tr class="colone_name">
                    <td><p>ID</p></td>
                    <td><p>Propriétaire</p></td>
                    <td><p>Nom</p></td>
                    <td><p>Puissance</p></td>
                    <td><p>Type</p></td>
                    <td><p>Marque</p></td>
                    <td></td>
                </tr>
                <?php foreach($repliques as $replique):
                    
                    //ICI J'aimerai Afficher le pseudo du joueur qui a l'id correspondant à "proprio"
                    $queryUser = "SELECT username FROM users WHERE id = :proprio_id";
                    $stmtUser = $conn->prepare($queryUser);
                    $stmtUser->bindParam(':proprio_id', $replique["proprio"]);
                    $stmtUser->execute();
                    $userName22 = $stmtUser->fetch(PDO::FETCH_ASSOC);

                    // Vérifier si l'utilisateur est défini, sinon utiliser "unknown"
                    $userName22 = isset($userName22['username']) ? $userName22['username'] : '-';
                                
                    ?>
                    <tr>
                        <td><p><?=$replique["id"]?></p></td>
                        <td><p><a href="profil.php?id=<?=$replique["proprio"]?>"><?=$userName22?></a></p></td>
                        <td><p><?=$replique["nom"]?></p></td>
                        <td><p><?=$replique["fps"]?> fps</p></td>
                        <td><p><?=$replique["type"]?></p></td>
                        <td><p><?=$replique["marque"]?></p></td>
                        <td class="settings"><a href="<?=$replique['id']?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </main>

    <footer></footer>
</body>
</html>

<script>

    document.addEventListener("DOMContentLoaded", function (){
        var warnFPSElement = document.getElementById("warn-fps");

        if(<?= count($highFPSRepliques) ?> === 0){
            warnFPSElement.style.display = "none"
        }
    })

</script>