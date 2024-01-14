<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

// Vérification de la session et de l'ID de l'utilisateur
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    // Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
    header("Location: ../pages/index.php");
    exit();
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
    <title>Upload d'image de profil | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>

    <!-- Feuilles de style CSS -->
    <link rel="stylesheet" href="../css/ABC_design.css">
    <link rel="stylesheet" href="../css/profil_photo_uploader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.js" defer></script>
    <script src="../js/ImageUploader.js" defer></script>

</head>
<body>
    <header><?php include "../includes/header.php";?></header>

    <div id="image_uploader">
        <main>
            <h1>Upload d'image de profil</h1>

            <!-- Formulaire d'upload d'image -->
            <form method="post" action="" enctype="multipart/form-data">
                <!-- Champ pour sélectionner l'image -->
                <input type="file" id="avatar" name="avatar" accept="image/*" required>
                
                <div id="imgview">
                    <div id="uploadedImage"></div>
                    <div id="sidebyside">
                        <img id="croppedImage"/>
                        <div id="cropResult"></div>
                    </div>
                </div>

                <button type="submit" onclick="cropImageAndUpload()">Envoyer l'image</button>

                <div id="message">
                    <?php
                    if (isset($error_message)) {
                        echo '<p style="color: red;">' . $error_message . '</p>';
                    } elseif (isset($_SESSION['success_message'])) {
                        echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
                        unset($_SESSION['success_message']);
                    }
                    ?>
                </div>
            </form>
        </main>
    </div>

    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>