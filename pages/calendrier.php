<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter


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
                <li><p class="idn"></p><p class="texte">Je reflechie</p></li>
                <li><p style="border-left: 5px solid rgb(32, 156, 38); padding: 0.5em 1em;">Partie d'airsoft</p></li>
                <li><p style="border-left: 5px solid rgb(187 197 41); padding: 0.5em 1em;">Entretien terrain</p></li>
                <li><p style="border-left: 5px solid rgb(255 87 35); padding: 0.5em 1em;">Réunion</p></li>
                <li><p style="border-left: 5px solid rgb(100 100 155); padding: 0.5em 1em;">Évènement Phenix</p></li>
            </ul>
        </div>

        <div id="liste_evenement">

            
            <a href=""><div class="event_line" style="border-left: 5px solid rgb(32, 156, 38)";>

                 <h2>Partie à Reignac</h2>
                 <div class="participant_pdp">
                    <p>+12</p>

                    <img style="z-index:5; transform: translateX(-15px);" src="../assets/images/avatars/2.jpg" alt="">
                    <img style="z-index:4; transform: translateX(-27px);" src="../assets/images/avatars/3.jpg" alt="">
                    <img style="z-index:3; transform: translateX(-37px);" src="../assets/images/avatars/7.jpg" alt="">
                    <img style="z-index:2; transform: translateX(-47px);" src="../assets/images/avatars/8.jpg" alt="">

                 </div>

                 <h3>27/05/2023</h3>

                 <p class="igo"></p>
            </div></a>

            <a href=""><div class="event_line" style="border-left: 5px solid rgb(32, 156, 38)";>
                 <h2>Partie à Reignac</h2>
                 <div class="participant_pdp">
                    <p>+6</p>

                    <img style="z-index:5; transform: translateX(-15px);" src="../assets/images/avatars/5.jpg" alt="">
                    <img style="z-index:4; transform: translateX(-27px);" src="../assets/images/avatars/1.jpg" alt="">
                    <p style="z-index:2; transform: translateX(-37px); background-color: transparent; border: transparent;"></p>
                    <p style="z-index:2; transform: translateX(-47px); background-color: transparent; border: transparent;"></p>

                 </div>

                 <h3>01/12/2023</h3>

                 <p class="idntgo"></p>
            </div></a>

            <a href=""><div class="event_line" style="border-left: 5px solid rgb(187 197 41)";>
                 <h2>Entretien Cézac</h2>
                 <div class="participant_pdp">
                    <p>+2</p>

                    <img style="z-index:5; transform: translateX(-15px);" src="../assets/images/avatars/4.jpg" alt="">
                    <p style="z-index:2; transform: translateX(-27px); background-color: transparent; border: transparent;"></p>
                    <p style="z-index:2; transform: translateX(-37px); background-color: transparent; border: transparent;"></p>
                    <p style="z-index:2; transform: translateX(-47px); background-color: transparent; border: transparent;"></p>

                 </div>

                 <h3>01/12/2023</h3>

                 <p class="idntgo"></p>
            </div></a>
        

        </div>


    </main>



    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>