<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

// Récupération des données du formulaire
$mail = htmlspecialchars($_POST['mail']);
$mdp = htmlspecialchars($_POST['mot_de_passe']);

if (!empty($mail) && !empty($mdp)) {

    $requser = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $requser->execute(array($mail));
    $userinfo = $requser->fetch();

    if ($userinfo && password_verify($mdp, $userinfo['mdp'])) {
        // Mail et mot de passe corrects, on connecte l'utilisateur
        $_SESSION['id'] = $userinfo['id'];
        $_SESSION['pseudo'] = $userinfo['pseudo'];
        $_SESSION['mail'] = $userinfo['mail'];

        header("Location: ../pages/profil.php?id=" . $_SESSION['id']);
        exit();
    } else {
        $erreur = "Mauvais mail ou mot de passe";
    }
} else {
    $erreur = "Veuillez remplir tous les champs";
}

// Redirection avec message d'erreur si nécessaire
if (isset($erreur)) {
    header("Location: ../pages/connection.php?error=$erreur");
    exit();
}
?>
