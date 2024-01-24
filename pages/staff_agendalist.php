<?php
include_once '../config/session.php'; # Recuperer les informations de mon utilisateur connecte
if (!isset($_SESSION['id'])) { // Verifier si l'utilisateur est connecté
    header("Location: login.php");
    exit();
}
if($selfuser_role !== 'administrateur' && $selfuser_role !== 'moderateur' && $selfuser_role !== 'comptable' && $selfuser_role !== 'organisateur') {
    header("Location: index.php");
    exit();
}

// Requête SQL pour récupérer les répliques
$query = "SELECT * FROM agenda";
$stmt = $conn->prepare($query);
$stmt->execute();
$agendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
$countTotal = count($agendas);

// Initialiser les compteurs
$countParties = 0;
$countEvenements = 0;

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
            <?php
                foreach ($agendas as $agenda) {
                    if ($agenda["type"] === 'partie') {
                        $countParties++;
                    } elseif ($agenda["type"] === 'evenement') {
                        $countEvenements++;
                    }
                }
            ?>
            <div class="element">
                <h1><?=$countParties?></h1>
                <p>Partie crée</p>
            </div>
            <div class="element">
                <h1><?=$countEvenements?></h1>
                <p>Evenent crée</p>
            </div>
            <div class="element">
                <h1><?=$countTotal?></h1>
                <p>Evenement total</p>
            </div>
        </div>

        <div class="spacer_2"></div>

        <div class="double_button">
            <a class="button_table_ajustable" href="staff_creation_partie.php">Ajouter une partie ou un évenement</a>
        </div>

        <div class="spacer_1"></div>

        <div class="table_style_1">
            <table>
                <thead>
                    <tr>
                        <th colspan="8"><img src="../assets/images/theme/agenda.png" alt="Logo agenda"><p>Agenda</p></th>
                    </tr>
                </thead>
                <tr class="colone_name">
                    <td><p>ID</p></td>
                    <td><p>Type</p></td>
                    <td><p>Titre</p></td>
                    <td><p>Date</p></td>
                    <td><p>Joueurs</p></td>
                    <td><p>Terrain/Adresse</p></td>
                    <td><p>BBQ ?</p></td>
                    <td><p>Location ?</p></td>
                    <td><p>Status</p></td>
                    <td><p>Edit</p></td>
                    <td><p>Voir plus</p></td>
                </tr>
                <?php foreach($agendas as $agenda):
                    $inscrits = getInscritsPartie($agenda["id"]);
                    $joueur_inscrit = count($inscrits); ?>
                    <tr>
                        <td><p><?=$agenda["id"]?></p></td>
                        <td><p><?=$agenda["type"]?></p></td>
                        <td><p><?=$agenda["titre"]?></p></td>
                        <td><p><?=$agenda["date"]?></p></td>
                        <td><?php if($joueur_inscrit < $agenda["joueur_min"]){ ?><p class="warn_fps"> <?php }else{ ?><p> <?php } ?><?=$joueur_inscrit?>/<?=$agenda["joueur_max"] ?></p></td>
                        <td><p><?php if(isset($agenda["terrain"])){ echo $agenda["terrain"];}else{ echo $agenda["adresse"];}?></p></td>
                        <td><p><?php if($agenda['bbq'] == 1){ echo "Oui";} else { echo "Non";}?></p></td>
                        <td><p><?php if($agenda['location'] == 1){ echo "Oui";} else { echo "Non";}?></p></td>
                        <td><?php if($agenda['date'] > date('Y-m-d H:i:s')){ echo "A venir";} else { echo "Terminer";} ?></td>
                        <td class="settings"><a href="staff_creation_partie?id=<?=$agenda['id']?>">Edit</a></td>
                        <td class="settings"><a href="partie.php?id=<?=$agenda['id']?>">Afficher</a></td>
                        
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </main>

    <footer></footer>
</body>
</html>