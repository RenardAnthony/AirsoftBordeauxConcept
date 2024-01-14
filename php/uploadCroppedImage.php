<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

// Vérification de la session et de l'ID de l'utilisateur
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    // ...
} else {
    // Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
    header("Location: ../pages/index.php");
    exit();
}


// Connexion à la base de données
include '../config/db.php';
$conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

// Vérification de la session et de l'ID de l'utilisateur
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
    // Récupérer les données de l'image recadrée depuis le client
    $croppedImageData = file_get_contents($_FILES['avatar']['tmp_name']);

    // Générer le nom de fichier pour la nouvelle image (basé sur l'ID de l'utilisateur)
    $new_filename = $user_id . '.jpg'; // Par exemple, vous pouvez enregistrer au format JPEG

    // Chemin où enregistrer l'image recadrée
    $upload_dir = '../assets/images/avatars/';
    $upload_path = $upload_dir . $new_filename;

    // Enregistrer l'image recadrée sur le serveur
    if (file_put_contents($upload_path, $croppedImageData)) {
        // Mettre à jour le nom de fichier de l'image dans la base de données
        $update_query = "UPDATE users SET avatar = :filename WHERE id = :user_id";
        $stmt = $conn->prepare($update_query);
        $stmt->bindParam(':filename', $new_filename);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Envoyer une réponse JSON pour indiquer le succès
        echo json_encode(array('success' => true, 'message' => 'L\'image a été enregistrée avec succès.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement de l\'image.'));
    }
}

?>