<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Récupérer les valeurs du formulaire
        $email = $_POST['email'];
        $username = $_POST['username'];
        $genre = $_POST['genre'];
        $date_naissance = $_POST['date_naissance'];
        $ville = $_POST['ville'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $groupe_sang = $_POST['groupe_sang'];
        $bio = $_POST['bio'];
        $cansee_sanguin = isset($_POST['cansee_sanguin']) ? 1 : 0;
        $cansee_nom = isset($_POST['cansee_nom']) ? 1 : 0;
        $cansee_prenom = isset($_POST['cansee_prenom']) ? 1 : 0;
        $cansee_localisation = isset($_POST['cansee_localisation']) ? 1 : 0;

        // Mettre à jour les informations de l'utilisateur dans la base de données
        $updateUserQuery = $conn->prepare('UPDATE users SET email = ?, username = ?, genre = ?, date_naissance = ?, ville = ?, nom = ?, prenom = ?, groupe_sang = ?, bio = ?, cansee_sanguin = ?, cansee_nom = ?, cansee_prenom = ?, cansee_localisation = ? WHERE id = ?');
        $updateUserQuery->execute(array($email, $username, $genre, $date_naissance, $ville, $nom, $prenom, $groupe_sang, $bio, $cansee_sanguin, $cansee_nom, $cansee_prenom, $cansee_localisation, $_SESSION['id']));

        // Rediriger l'utilisateur vers la page de profil
        header("Location: ../pages/profil.php?id=".$_SESSION['id']);
        exit;
    } else {
        header("Location: ../pages/index.php");
        exit;
    }
} else {
    header("Location: ../pages/index.php");
    exit;
}
?>
