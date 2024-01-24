<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

// Utiliser la fonction pour obtenir les prochaines parties
$prochainesParties = getProchainesParties($conn);


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
    <title>Calendrier | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/calendrier.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>



    <main>

        <div id="legende">

            <h1>Legende</h1>

            <ul>
                <li><p class="igo"></p><p class="texte">Je participe</p></li>
                <!--<li><p class="idn"></p><p class="texte">Je reflechie</p></li>-->
                <li><p style="border-left: 5px solid rgb(32, 156, 38); padding: 0.5em 1em;">Partie d'airsoft</p></li>
                <li><p style="border-left: 5px solid rgb(187 197 41); padding: 0.5em 1em;">Entretien terrain</p></li>
                <!--<li><p style="border-left: 5px solid rgb(255 87 35); padding: 0.5em 1em;">Réunion</p></li>
                <li><p style="border-left: 5px solid rgb(100 100 155); padding: 0.5em 1em;">Évènement Phenix</p></li>-->
            </ul>
        </div>

        <div id="liste_evenement">

            <?php foreach ($prochainesParties as $evenement): 

            // Utiliser la fonction pour obtenir le nombre total de participants
            $totalParticipants = getTotalParticipants($conn, $evenement['id']);

            // Utiliser la fonction pour obtenir 4 photos de profil au hasard
            $randomAvatars = getRandomAvatars($conn, $evenement['id'], 4);
            $zIndex = 5; // Valeur initiale pour z-index
            $translateX = -15; // Valeur initiale pour translateX

            // Vérifier le type d'événement
            $eventType = $evenement['type'];

            // Définir la couleur de la bordure en fonction du type d'événement
            $borderColor = ($eventType == "partie") ? "rgb(32, 156, 38)" : "rgb(187 197 41)";

            ?>
            <a href="partie?id=<?=$evenement['id']?>">

                <div class="event_line" style="border-left: 5px solid <?= $borderColor; ?>"> <!--couleur_bordure-->
                    <h2><?php 
                        if($eventType == "partie"){ 
                            echo "Partie à " . $evenement['terrain']; 
                        } else { 
                            echo "Evenement : " . $evenement['titre']; 
                        } 
                    ?></h2>

                    <div class="participant_pdp">
                        <p><?= $totalParticipants ?></p>

                        <?php if ($randomAvatars !== null): ?>

                            <?php foreach ($randomAvatars as $avatar):

                                echo '<img style="z-index: ' . $zIndex . '; transform: translateX(' . $translateX . 'px);" src="../assets/images/avatars/' . $avatar . '" alt="">'; ?>
                                <?php
                                // Décalage pour la prochaine image
                                $zIndex--;
                                $translateX -= 10; // Vous pouvez ajuster cette valeur selon votre préférence

                            endforeach; 

                        endif; ?>
                    </div>
                    
                    <h3><?= date('d/m/Y', strtotime($evenement['date'])) ?></h3>

                    <p class="igo" <?php if (isUserRegistered($conn, $_SESSION['id'], $evenement['id'])) echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>></p>

                </div>
            </a>


            <?php endforeach; ?>

            
        </div>


    </main>



    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>