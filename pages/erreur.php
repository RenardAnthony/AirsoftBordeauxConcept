<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter


$code_error = htmlspecialchars($_GET['code']);

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
    <title>Erreur <?=$code_error?> | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/error.css"/>
</head>
<body>



    <?php if($code_error == "404"){ ?><main style="background-image: url('../assets/images/theme/page404.png');"><?php } ?>  

        <div id="inner">

            <h1>Erreur <?=$code_error?></h1>
            <a href="../pages/index.php">Retour à l'accueil</a>

        </div>

    </main>



</body>
</html>