<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../pages/index.php");
    exit();
}

// Vérifiez si l'ID de la partie est passé en paramètre dans l'URL
if (!isset($_GET['id'])) {
    header("Location: ../pages/index.php");
    exit();
}

$get_eventId = htmlspecialchars($_GET['id']);

// Utilisez la fonction pour supprimer l'inscription
removeInscription($conn, $_SESSION['id'], $get_eventId);

// Redirigez l'utilisateur vers la page de la partie
header("Location: partie.php?id=" . $get_eventId);
exit();

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
    <title>Nom de la page | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>



    <main>
        



    </main>



    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>