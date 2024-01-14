<?php
session_start();

include_once '../config/functions.php';

$conn = connectDB();
$loggedInUser = getLoggedInUserInfo($conn);

if ($loggedInUser) {
    $selfuser_id = $loggedInUser['id'];
    $selfuser_email = $loggedInUser['email'];
    $selfuser_username = $loggedInUser['username'];
    $selfuser_role = $loggedInUser['role'];
    $selfuser_avatar = $loggedInUser['avatar'];
    $selfuser_prenom = $loggedInUser['prenom'];
    $selfuser_nom = $loggedInUser['nom'];
    $selfuser_genre = $loggedInUser['genre'];
    $selfuser_groupe_sang = $loggedInUser['groupe_sang'];
    $selfuser_date_naissance = $loggedInUser['date_naissance'];
    $selfuser_ville = $loggedInUser['ville'];
    $selfuser_bio = $loggedInUser['bio'];
    $selfuser_date_inscription = $loggedInUser['date_inscription'];

    $selfuser_cansee_nom = $loggedInUser['cansee_nom'];
    $selfuser_cansee_prenom = $loggedInUser['cansee_prenom'];
    $selfuser_cansee_sanguin = $loggedInUser['cansee_sanguin'];
    $selfuser_cansee_localisation = $loggedInUser['cansee_localisation'];
}
?>
