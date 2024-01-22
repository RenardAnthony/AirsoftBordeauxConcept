<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter



// Vérifie si l'ID de l'utilisateur est passé dans l'URL
if(isset($_GET['id'])){
    // Convertit l'ID en entier pour des raisons de sécurité
    $getid = intval($_GET['id']);

    // Prépare la requête SELECT pour récupérer les informations de l'utilisateur à partir de l'ID
    $requser = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

    // Vérifie si l'utilisateur existe dans la base de données
    if(empty($userinfo['username'])){
        // Redirige vers l'accueil si l'utilisateur n'existe pas
        header("Location: ../pages/index.php"); 
    }

    // Récupère les répliques de l'utilisateur dont tu consultes le profil
    $replicas = getReplicas($conn, $getid);


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
    <title>Profil | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/profil.css"/>
</head>
<body>
    <!-- Inclusion du header -->
    <header><?php include "../includes/header.php";?></header>


    <main>

        <div id="part1">
            <!-- Affiche la photo de profil de l'utilisateur -->
            <img src="../assets/images/avatars/<?=$userinfo['avatar']?>" alt="Photo de profil de <?=$userinfo['username']?>">


            <div id="part1-1">
                <!-- Affiche le nom, prénom, âge, ville et groupe sanguin de l'utilisateur -->
                <h1><?=$userinfo['username']?></h1>
                <?php if ($userinfo['cansee_nom']) { ?>
                    <p><?=$userinfo['nom']?></p>
                <?php } ?>
                <?php if ($userinfo['cansee_prenom']) { ?>
                    <p><?=$userinfo['prenom']?></p>
                <?php } ?>
                <!-- Trouver l'âge de l'utilisateur juste avec la date -->
                    <?php 
                        // Supposons que la date de naissance est stockée dans la colonne 'date_naissance'
                        $date_naissance = $userinfo['date_naissance'];
                        
                        // Date actuelle
                        $aujourdhui = new DateTime();

                        // Date de naissance de l'utilisateur (convertie en objet DateTime)
                        $date_naissance_obj = new DateTime($date_naissance);

                        // Calcul de la différence entre la date actuelle et la date de naissance
                        $diff = $date_naissance_obj->diff($aujourdhui);

                        // Récupération de l'âge en années
                        $age = $diff->y;
                    ?>
                <p><?php if($age <= 120){echo $age . " ans";}?></p>
                <?php if ($userinfo['cansee_localisation']) { ?>
                    <p><?=$userinfo['ville']?></p>
                <?php } ?>
                <?php if ($userinfo['cansee_sanguin']) { ?>
                    <p><?=$userinfo['groupe_sang']?></p>
                <?php } ?>
            </div>
            <div id="role">
                <?php
                // Récupère les badges associés à l'utilisateur
                $badgeIds = (!empty($userinfo['badges'])) ? explode(',', $userinfo['badges']) : [];

                // Récupère le premier badge associé à l'utilisateur
                $firstBadgeId = (!empty($badgeIds)) ? reset($badgeIds) : null;
                
                if ($firstBadgeId !== null) {
                    $queryFirstBadge = "SELECT * FROM badges WHERE id = :badge_id";
                    $stmtFirstBadge = $conn->prepare($queryFirstBadge);
                    $stmtFirstBadge->bindParam(':badge_id', $firstBadgeId, PDO::PARAM_INT);
                    $stmtFirstBadge->execute();
                    ?>
                    <!-- Affiche le badge de rang de l'utilisateur -->
                    <?php if ($firstBadge = $stmtFirstBadge->fetch(PDO::FETCH_ASSOC)) { ?>
                        <a href="<?= $firstBadge['link'] ?>"><img id="badge" src="<?= $firstBadge['img'] ?>" alt="" title="<?= $firstBadge['nom'] ?>"></a>
                    <?php } ?>
                <?php } ?>

                <!-- Affiche une liste de badges supplémentaires -->
                <div id="liste_badge">
                    <?php
                    $counter = 0; // Variable pour suivre le nombre de résultats affichés
                    foreach ($badgeIds as $key => $badgeId) {
                        // Ignorer le premier badge car il est déjà affiché
                        if ($key === 0) {
                            continue;
                        }
                        // Effectue une requête pour obtenir les détails du badge
                        $queryBadge = "SELECT * FROM badges WHERE id = :badge_id";
                        $stmtBadge = $conn->prepare($queryBadge);
                        $stmtBadge->bindParam(':badge_id', $badgeId, PDO::PARAM_INT);
                        $stmtBadge->execute();
                        // Vérifie si la requête a réussi et si le badge existe
                        while ($badge = $stmtBadge->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <a href="<?= $badge['link'] ?>"><img class="badge_petit" src="<?= $badge['img'] ?>" alt="" title="<?= $badge['nom'] ?>"></a>
                            <?php
                            $counter++; // Incrémenter le compteur après l'affichage d'un résultat
                        }
                        if ($counter >= 3) {
                            break; // Sortir de la boucle après avoir affiché 2 résultats
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        // Vérifie si la bio de l'utilisateur n'est pas vide
        if(!empty($userinfo['bio'])){?>

            <div id="part2">
                <!-- Affiche la bio de l'utilisateur -->
                <h2>Bio</h2>
                <p><?=$userinfo['bio']?></p>
            </div>

        <?php } ?>


        <div id="part3">
            <h2>Réplique(s)</h2>
            <div id="liste_replique">
                <?php foreach($replicas as $replica): ?>
                    <div class="replique_unique">
                        <img src="<?=$replica['img']?>" alt="<?=$replica['nom']?>">
                        <h2><?=$replica['nom']?></h2>
                        <p><?=$replica['fps']?> fps - <?=$replica['type']?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

            </div>

        </div>

        <div id="part4">
            <table>
                <!-- Affiche le nombre de messages et le nombre de parties jouées par l'utilisateur -->
                <tr>
                    <td><p>0</p></td>
                    <td><p>0</p></td>
                </tr>
                <tr>
                    <td><h2>Nbr de messages</h2></td>
                    <td><h2>Nbr de parties jouer</h2></td>
                </tr>
            </table>
        </div>

        <?php 
        // Vérifie si l'utilisateur est connecté et que c'est son propre profil
        if(isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']){ ?>

            <div id="part5">
                <!-- Affiche des liens pour éditer le profil et se déconnecter -->
                <a href="../pages/profil_edit.php">Edit profil</a>
                <a href="../php/traitement_deconnexion.php">Déconnexion</a>
                <?php if($userinfo['role'] == 'administrateur' || $userinfo['role'] == 'moderateur' || $userinfo['role'] == 'comptable' || $userinfo['role'] == 'organisateur'){?>
                    <a href="../pages/staff.php">Staff Zone</a>
                <?php } ?>
            </div>

        <?php } ?>

    </main>

    <!-- Inclusion du footer -->
    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>

<?php
} else {
}?>