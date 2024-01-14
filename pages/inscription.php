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
    <title>Inscription | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/login-register.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>



    <main>
        

        <div id="Box_general">
            <img src="../assets/images/theme/logo.png" alt="">
            <h1>Inscription</h1>

            <form method="POST" action="../php/traitement_inscription.php">
                <input id="pseudo" name="pseudo" class="input-text-base" type="text" placeholder="Pseudo" minlength="5" maxlength="15" required>
                <input id="champMail" name="champMail" class="input-text-base" type="email" placeholder="Email" required>
                <input id="mot_de_passe" name="mot_de_passe" class="input-text-base" type="password" placeholder="Mot de passe" minlength="8" maxlength="255" required>



                    <!--En cas d'erreur, afficher un message-->
                    <?php if(isset($_GET['error'])){ ?>
                        <div id="erreur_message">
                            <p><?=htmlspecialchars($_GET['error'])?></p>
                        </div>
                    <?php } ?>

                    <script src="../js/destroy_error_message.js"></script>



                <input type="submit" class="valider" value="Inscription">
                <a href="../pages/connection.php" class="nostyle">J'ai déjà un compte</a>
            </form>
        </div>



    </main>



    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>